<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Ticket;
use App\Models\Modulo;
use App\Models\Consultor;
use App\Models\Estado;
use App\Models\UserSociety;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Sociedad;
use App\Models\Documento;
use App\Models\ConsultorModulo;
use App\Models\HistoryTicketUser;
use App\Models\HistoryTicketCosto;
use App\Models\EstadoFechaTicket;
use App\Models\FacturaTicket;
use App\Models\RolConsultor;
use App\Models\ClienteModulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clientes = Cliente::where('estado', true)->get();

        $pendientes = collect();
        $estimados = collect();
        $aprobados = collect();
        $planificados = collect();
        $observados = collect();
        $prueba_clientes = collect();
        $cerrados = collect();
        $facturados = collect();
        $tickets = collect();
        if ($request->filled('cliente') || $request->filled('codigo')) {

            $query = Ticket::with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
                ->where('status', true);

            // Filtrar por cliente
            if ($request->filled('cliente') && $request->cliente !== 'all') {
                $query->where('id_cliente', $request->cliente);
            }

            // Filtrar por código
            if ($request->filled('codigo')) {
                $query->where('cod_ticket', 'like', '%' . $request->codigo . '%');
            }

            $tickets = $query->get();

            // Dividir en colecciones por estado
            $pendientes     = $tickets->where('estado.id', 1);
            $estimados      = $tickets->where('estado.id', 2);
            $aprobados      = $tickets->where('estado.id', 3);
            $planificados   = $tickets->where('estado.id', 4);
            $observados     = $tickets->where('estado.id', 5);
            $prueba_clientes= $tickets->where('estado.id', 6);
            $cerrados       = $tickets->where('estado.id', 7);
            $facturados     = $tickets->where('estado.id', 8);
        }
        return view('admin.ticket.index', compact(
            'tickets', 'pendientes', 'estimados', 'aprobados',
            'planificados', 'observados', 'prueba_clientes',
            'cerrados', 'facturados', 'clientes'
        ));
    }

    public function create()
    {
        $modulos = Modulo::where('estado', true)->get();
        $consultores = Consultor::where('estado', true)
        ->with(['usuario', 'roles' => function ($query) {
            $query->where('estado', true);
        }])
        ->get();
        

        $abaps = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'abap');
        });

        $clientes = Cliente::where('estado', true)
        ->get();

        $estados = Estado::where('estado', true)->get();
        return view('admin.ticket.create', compact('modulos', 'estados', 'clientes'));
    }

    public function getSociedades($id)
    {
        $sociedades = Sociedad::where('id_cliente', $id)
            ->where('estado', true)
            ->select('id', 'nombre_sociedad')
            ->get();

        return response()->json($sociedades);
    }

    public function getByFuncional($idCliente, $idModulo, $tipoCosto)
    {
        $clienteModulo = ClienteModulo::where('id_cliente', $idCliente)
            ->where('id_modulo', $idModulo)
            ->where('estado', true)
            ->first();

        if (!$clienteModulo) {
            return response()->json([]); 
        }

        $campoCosto = match ($tipoCosto) {
            'soporte' => 'costo_soporte',
            'proyecto' => 'costo_proyecto',
            'bolsa_hora' => 'costo_bolsa_hora',
            default => null
        };

        if (!$campoCosto || $clienteModulo->$campoCosto < 0.01) {
            return response()->json([]); 
        }

        $consultorModulo = ConsultorModulo::where('id_modulo', $idModulo)
            ->where('estado', true)
            ->whereHas('consultor', function ($q) {
                $q->where('estado', true)
                ->whereHas('roles', function ($r) {
                    $r->where('estado', true)
                        ->where('detalle', 'funcional');
                });
            })
            ->with([
                'consultor' => function ($query) {
                    $query->where('estado', true)
                        ->with([
                            'usuario',
                            'roles' => function ($q) {
                                $q->where('estado', true)
                                    ->where('detalle', 'funcional');
                            }
                        ]);
                }
            ])
            ->get();

        return response()->json($consultorModulo);
    }

    public function getAbaps($idCliente, $tipoCosto)
    {
        // Buscar el módulo ABAP
        $moduloAbap = Modulo::where('abre_modulo', 'ABAP')
            ->orWhere('desc_modulo', 'ABAP')
            ->first();

        if (!$moduloAbap) {
            return response()->json([]);
        }

        // Buscar ClienteModulo con ABAP
        $clienteModulo = ClienteModulo::where('id_cliente', $idCliente)
            ->where('id_modulo', $moduloAbap->id)
            ->where('estado', true)
            ->first();

        if (!$clienteModulo) {
            return response()->json([]);
        }

        // Campo de costo dinámico
        $campoCosto = match ($tipoCosto) {
            'soporte'    => 'costo_soporte',
            'proyecto'   => 'costo_proyecto',
            'bolsa_hora' => 'costo_bolsa_hora',
            default      => null,
        };

        // Validar costo: debe existir y ser mayor que 0
        if (!$campoCosto || $clienteModulo->$campoCosto <= 0) {
            return response()->json([]);
        }

        // Consultores ABAP directamente filtrados
        $abaps = Consultor::where('estado', true)
            ->whereHas('roles', function ($q) {
                $q->where('estado', true)
                ->where('detalle', 'abap');
            })
            ->with('usuario')
            ->get();

        return response()->json([
            'costo' => (float) $clienteModulo->$campoCosto,
            'abaps' => $abaps->map(fn($a) => [
                'id' => $a->id,
                'name' => $a->usuario->name ?? '',
            ]),
        ]);
    }

    public function store(Request $request)
    {

        $request->nombre_ticket = strtoupper($request->nombre_ticket);
        $request->solicitante = strtoupper($request->solicitante);
        $year = date('Y'); // Año actual
        // Buscar el último ticket del año actual
        $ultimo_ticket = Ticket::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        // Obtener el último número correlativo o iniciar en 1
        if ($ultimo_ticket && preg_match('/RSR-\d{4}-(\d{4})/', $ultimo_ticket->cod_ticket, $matches)) {
            $ultimo_numero = (int)$matches[1];
            $nuevo_numero = str_pad($ultimo_numero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nuevo_numero = '0001';
        }
        // Construir el código del ticket
        $cod_ticket = "RSR-$year-$nuevo_numero";
        $id_estado = 1;
        $request->descripcion = strtoupper($request->descripcion);

        
        #costo abap y funcional
        $abap_costo = 0.00;
        $funcional_costo = 0.00;
        if(!empty($request->abap)){
            $moduloAbap = Modulo::where('abre_modulo', 'ABAP')
                ->orWhere('desc_modulo', 'ABAP')
                ->first();
            $clienteModuloAbap = ClienteModulo::where('id_cliente', $request->cliente)
                ->where('id_modulo', $moduloAbap->id)
                ->where('estado', true)
                ->first();

            $campoCostoAbap = match ($request->tipoCosto) {
                'soporte'    => 'costo_soporte',
                'proyecto'   => 'costo_proyecto',
                'bolsa_hora' => 'costo_bolsa_hora',
                default      => null,
            };
            $abap_costo = $clienteModuloAbap->$campoCostoAbap;
        }
        if(!empty($request->funcional)){
            $clienteModuloFun = ClienteModulo::where('id_cliente', $request->cliente)
                ->where('id_modulo', $request->id_modulo)
                ->where('estado', true)
                ->first();

            $campoCostoFun = match ($request->tipoCosto) {
                'soporte' => 'costo_soporte',
                'proyecto' => 'costo_proyecto',
                'bolsa_hora' => 'costo_bolsa_hora',
                default => null
            };
            $funcional_costo = $clienteModuloFun->$campoCostoFun;
        }

        $costo_total = 0;
        $total_horas = 0;
        if(!empty($request->hora_abap)){
            $costo_total = $costo_total + ( $abap_costo * $request->hora_abap);
            $total_horas = $total_horas + $request->hora_abap;
        }

        if (!empty($request->hora_funcional)) {
            $costo_total = $costo_total + ( $funcional_costo * $request->hora_funcional);
            $total_horas = $total_horas + $request->hora_funcional;
        }

        $request->validate([
            'solicitante' => 'nullable|string',
        ]);
        $creado_por = Auth::user()->id;

        $ticket = Ticket::create([
            'cod_ticket' => $cod_ticket, //
            'nombre_ticket' => $request->nombre_ticket, //
            'tipo_ticket' => $request->tipo_ticket ?? null, //
            'oc_bolsa' => $request->oc_bolsa ?? null, //
            'id_modulo' => $request->id_modulo ?? null, //
            'tipo_costo' => $request->tipoCosto ?? null, //
            'id_estado' => $id_estado, //
            'id_cliente' => $request->cliente, //
            'id_sociedad' => $request->sociedad, //
            'solicitante' => $request->solicitante ?? null, //
            'id_abap' => $request->abap ?? null, //
            'hora_abap' => $request->hora_abap ?? null, 
            // 'costo_abap' => $abap_con->costo ?? 0.00, //
            'costo_abap' => $abap_costo ?? 0.00, //
            'id_funcional' => $request->funcional ?? null, //
            'hora_funcional' => $request->hora_funcional ?? null, 
            // 'costo_funcional' => $funcional_con->costo_cliente ?? 0.00, //
            'costo_funcional' => $funcional_costo ?? 0.00, //
            'costo_total' => $costo_total ?? null,
            'total_horas' => $total_horas ?? null,
            'user_create' => $creado_por,
        ]);
        //crear estado ticket
        $idticket = $ticket->id;
        $abap_rol = RolConsultor::where('id_consult', $request->abap)
            ->where('estado', true)
            ->where('detalle', 'abap')
        ->first();
        $funcional_rol = RolConsultor::where('id_consult', $request->funcional)
            ->where('estado', true)
            ->where('detalle', 'funcional')
        ->first();
        if(!empty($request->abap)){
            $history_ticket_users_abap = HistoryTicketUser::create([
                'id_ticket' => $idticket,
                'id_consultor' => $request->abap,
                'id_rol' => $abap_rol->id,
            ]);
        }
        if(!empty($request->funcional)){
            $history_ticket_users_func = HistoryTicketUser::create([
                'id_ticket' => $idticket,
                'id_consultor' => $request->funcional,
                'id_rol' => $funcional_rol->id,
            ]);
        }

        if(!empty($request->hora_abap)){
            $history_ticket_costos_abap = HistoryTicketCosto::create([
                'id_ticket' => $idticket,
                'rol' => 'abap',
                'condicion' => 'normal',
                'horas' => $request->hora_abap,
                'estado' => true,
            ]);
        }

        if (!empty($request->hora_funcional)) {
            $history_ticket_costos_func = HistoryTicketCosto::create([
                'id_ticket' => $idticket,
                'rol' => 'funcional',
                'condicion' => 'normal',
                'horas' => $request->hora_funcional,
                'estado' => true,
            ]);
        }
        
        $estado_fecha_ticket = EstadoFechaTicket::create([
            'id_ticket' => $idticket,
            'id_estado' => $id_estado,
            'fecha_estado' => now(),
            'descripcion' => $request->descripcion ?? null,
        ]);

        $id_estadoFecha = $estado_fecha_ticket->id;

        $uploadedFiles = [];
        $ruta_doc = [];

        if ($request->hasFile('archivos')) {
            // Carpeta por fecha: "uploads/2025-07-18/"
            $fechaCarpeta = now()->format('Y-m-d');
            $carpeta = 'documentos/' . $fechaCarpeta;

            // Crear carpeta si no existe
            if (!file_exists(public_path($carpeta))) {
                mkdir(public_path($carpeta), 0777, true);
            }

            foreach ($request->file('archivos') as $file) {
                $fechaHora = now()->format('Y-m-d_H-i-s');
                $uniqueId = uniqid(); // o Str::uuid()
                $nombreOriginal = $file->getClientOriginalName();
                $filename = $fechaHora . '_' . $uniqueId . '_' . $nombreOriginal;
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                $file->move(public_path($carpeta), $filename);

                $rutaCompleta = $carpeta . '/' . $filename;

                $uploadedFiles[] = $filename;
                $ruta_doc[] = $rutaCompleta;

                $subido_por = Auth::user()->id;

                $documentos = Documento::create([
                    'id_ticket_estado' => $id_estadoFecha,
                    'nombre_original' => $nombreOriginal,
                    'extension' => $extension,
                    'ruta_documento' => $rutaCompleta,
                    'tamano_bytes' => $size,
                    'subido_por' => $subido_por,
                    'fecha_subida' => now(),
                    'estado' => true,
                ]);
            }

        }

        return redirect()->route('admin.ticket.create')->with('success', __('Ticket created successfully.'));
    }

    public function store3(Request $request)
    {

        $request->nombre_ticket = strtoupper($request->nombre_ticket);
        $request->solicitante = strtoupper($request->solicitante);
        $year = date('Y'); // Año actual
        // Buscar el último ticket del año actual
        $ultimo_ticket = Ticket::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        // Obtener el último número correlativo o iniciar en 1
        if ($ultimo_ticket && preg_match('/RSR-\d{4}-(\d{4})/', $ultimo_ticket->cod_ticket, $matches)) {
            $ultimo_numero = (int)$matches[1];
            $nuevo_numero = str_pad($ultimo_numero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nuevo_numero = '0001';
        }
        // Construir el código del ticket
        $cod_ticket = "RSR-$year-$nuevo_numero";
        $id_estado = 1;
        $request->descripcion = strtoupper($request->descripcion);

        $abap_con = Consultor::where('id', $request->abap)
            ->where('estado', true)
        ->first();
        $funcional_con = ConsultorModulo::where('id_consultor', $request->funcional)
            ->where('id_modulo', $request->id_modulo)
            ->where('estado', true)
        ->first();


        $costo_total = 0;
        $total_horas = 0;
        if(!empty($request->hora_abap)){
            $costo_total = $costo_total + ( $abap_con->costo * $request->hora_abap);
            $total_horas = $total_horas + $request->hora_abap;
        }

        if (!empty($request->hora_funcional)) {
            $costo_total = $costo_total + ( $funcional_con->costo_cliente * $request->hora_funcional);
            $total_horas = $total_horas + $request->hora_funcional;
        }

        $request->validate([
            'solicitante' => 'nullable|string',
        ]);

        $ticket = Ticket::create([
            'cod_ticket' => $cod_ticket, //
            'nombre_ticket' => $request->nombre_ticket, //
            'tipo_ticket' => $request->tipo_ticket ?? null, //
            'oc_bolsa' => $request->oc_bolsa ?? null, //
            'id_modulo' => $request->id_modulo ?? null, //
            'id_estado' => $id_estado, //
            'id_cliente' => $request->cliente, //
            'id_sociedad' => $request->sociedad, //
            'solicitante' => $request->solicitante ?? null, //
            'id_abap' => $request->abap ?? null, //
            'hora_abap' => $request->hora_abap ?? null, 
            'costo_abap' => $abap_con->costo ?? 0.00, //
            'id_funcional' => $request->funcional ?? null, //
            'hora_funcional' => $request->hora_funcional ?? null, 
            'costo_funcional' => $funcional_con->costo_cliente ?? 0.00, //
            'costo_total' => $costo_total ?? null,
            'total_horas' => $total_horas ?? null,
            // 'fecha_prd' => $request->fecha_prd,
            // 'fecha_inicio' => $request->fecha_inicio,
            // 'fecha_resolucion' => $request->fecha_resolucion
        ]);
        //crear estado ticket
        $idticket = $ticket->id;
        $abap_rol = RolConsultor::where('id_consult', $request->abap)
            ->where('estado', true)
            ->where('detalle', 'abap')
        ->first();
        $funcional_rol = RolConsultor::where('id_consult', $request->funcional)
            ->where('estado', true)
            ->where('detalle', 'funcional')
        ->first();
        if(!empty($request->abap)){
            $history_ticket_users_abap = HistoryTicketUser::create([
                'id_ticket' => $idticket,
                'id_consultor' => $request->abap,
                'id_rol' => $abap_rol->id,
            ]);
        }
        if(!empty($request->funcional)){
            $history_ticket_users_func = HistoryTicketUser::create([
                'id_ticket' => $idticket,
                'id_consultor' => $request->funcional,
                'id_rol' => $funcional_rol->id,
            ]);
        }

        if(!empty($request->hora_abap)){
            $history_ticket_costos_abap = HistoryTicketCosto::create([
                'id_ticket' => $idticket,
                'rol' => 'abap',
                'condicion' => 'normal',
                'horas' => $request->hora_abap,
                'estado' => true,
            ]);
        }

        if (!empty($request->hora_funcional)) {
            $history_ticket_costos_func = HistoryTicketCosto::create([
                'id_ticket' => $idticket,
                'rol' => 'funcional',
                'condicion' => 'normal',
                'horas' => $request->hora_funcional,
                'estado' => true,
            ]);
        }
        
        $estado_fecha_ticket = EstadoFechaTicket::create([
            'id_ticket' => $idticket,
            'id_estado' => $id_estado,
            'fecha_estado' => now(),
            'descripcion' => $request->descripcion ?? null,
        ]);

        $id_estadoFecha = $estado_fecha_ticket->id;

        $uploadedFiles = [];
        $ruta_doc = [];

        if ($request->hasFile('archivos')) {
            // Carpeta por fecha: "uploads/2025-07-18/"
            $fechaCarpeta = now()->format('Y-m-d');
            $carpeta = 'documentos/' . $fechaCarpeta;

            // Crear carpeta si no existe
            if (!file_exists(public_path($carpeta))) {
                mkdir(public_path($carpeta), 0777, true);
            }

            foreach ($request->file('archivos') as $file) {
                $fechaHora = now()->format('Y-m-d_H-i-s');
                $uniqueId = uniqid(); // o Str::uuid()
                $nombreOriginal = $file->getClientOriginalName();
                $filename = $fechaHora . '_' . $uniqueId . '_' . $nombreOriginal;
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                $file->move(public_path($carpeta), $filename);

                $rutaCompleta = $carpeta . '/' . $filename;

                $uploadedFiles[] = $filename;
                $ruta_doc[] = $rutaCompleta;

                $subido_por = Auth::user()->id;

                $documentos = Documento::create([
                    'id_ticket_estado' => $id_estadoFecha,
                    'nombre_original' => $nombreOriginal,
                    'extension' => $extension,
                    'ruta_documento' => $rutaCompleta,
                    'tamano_bytes' => $size,
                    'subido_por' => $subido_por,
                    'fecha_subida' => now(),
                    'estado' => true,
                ]);
            }

        }

        return redirect()->route('admin.ticket.create')->with('success', __('Ticket created successfully.'));
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404); 
        }
        $ticket = Ticket::with(['modulo', 'estado', 'cliente', 
        'sociedad', 'abap', 'funcional'])
        ->findOrFail($id);

        $estados = Estado::where('estado', true)
            ->get();

        $estado_fechas_tickets = EstadoFechaTicket::where('id_ticket', $id)
            ->orderBy('fecha_estado', 'desc')
            ->with(['estado', 'documentos' => function ($doc){
                $doc->where('estado', true);
            }])
            ->get();

        $history_ticket_costos = HistoryTicketCosto::where('id_ticket', $id)
            ->orderBy('created_at', 'desc')
            ->where('estado', true)
            ->get();

        $moduloAbap = Modulo::where('abre_modulo', 'ABAP')
            ->orWhere('desc_modulo', 'ABAP')
            ->first();

        $abaps = collect(); // colección vacía por defecto
        if ($moduloAbap) {
            $clienteModuloAbap = ClienteModulo::where('id_cliente', $ticket->id_cliente)
                ->where('id_modulo', $moduloAbap->id)
                ->where('estado', true)
                ->first();

            if ($clienteModuloAbap) {
                $campoCostoAbap = match ($ticket->tipo_costo) {
                    'soporte'    => 'costo_soporte',
                    'proyecto'   => 'costo_proyecto',
                    'bolsa_hora' => 'costo_bolsa_hora',
                    default      => null,
                };

                if ($campoCostoAbap && $clienteModuloAbap->$campoCostoAbap > 0) {
                    $abaps = Consultor::where('estado', true)
                        ->whereHas('roles', function ($q) {
                            $q->where('estado', true)
                            ->where('detalle', 'abap');
                        })
                        ->with('usuario')
                        ->get();
                }
            }
        }
        $funcionales = collect(); // vacío por defecto

        $clienteModuloFun = ClienteModulo::where('id_cliente', $ticket->id_cliente)
            ->where('id_modulo', $ticket->id_modulo)
            ->where('estado', true)
            ->first();

        if ($clienteModuloFun) {
            $campoCostoFun = match ($ticket->tipo_costo) {
                'soporte'    => 'costo_soporte',
                'proyecto'   => 'costo_proyecto',
                'bolsa_hora' => 'costo_bolsa_hora',
                default      => null,
            };

            if ($campoCostoFun && $clienteModuloFun->$campoCostoFun > 0) {
                $funcionales = ConsultorModulo::where('id_modulo', $ticket->id_modulo)
                    ->where('estado', true)
                    ->whereHas('consultor', function ($q) {
                        $q->where('estado', true)
                        ->whereHas('roles', function ($r) {
                            $r->where('estado', true)
                                ->where('detalle', 'funcional');
                        });
                    })
                    ->with([
                        'consultor' => function ($query) {
                            $query->where('estado', true)
                                ->with([
                                    'usuario',
                                    'roles' => function ($q) {
                                        $q->where('estado', true)
                                            ->where('detalle', 'funcional');
                                    }
                                ]);
                        }
                    ])
                    ->get();
            }
        }
        
        return view('admin.ticket.view', compact('ticket', 'estado_fechas_tickets', 'history_ticket_costos', 
            'abaps', 'funcionales', 'estados')); 
    }

    public function putOcBolsaCam(Request $request, $id){
        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'oc_bolsa' => $request->num_oc_bolsa_cam ?? null,
            'tipo_ticket' => $request->tipo_ticket ?? null,
        ]);

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Numero actualizado correctamente.');
    }

    public function storeFechaIniFin(Request $request, $id){
        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'fecha_inicio' => $request->fecha_inicio ?? null,
            'fecha_resolucion' => $request->fecha_final ?? null,
        ]);

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Se registró la fecha.');
    }
    public function storeDocuTicket(Request $request, $id){
        $ticket = Ticket::findOrFail($id);
        $ticket_data = Ticket::where('id', $id)->first();

        $request->comentario_data = strtoupper($request->comentario_data);

        $estado_fecha_ticket = EstadoFechaTicket::create([
            'id_ticket' => $id,
            'id_estado' => $ticket_data->id_estado,
            'fecha_estado' => now(),
            'descripcion' => $request->comentario_data ?? null,
        ]);

        $id_estadoFecha = $estado_fecha_ticket->id;

        $uploadedFiles = [];
        $ruta_doc = [];

        if ($request->hasFile('documentos')) {
            // Carpeta por fecha: "uploads/2025-07-18/"
            $fechaCarpeta = now()->format('Y-m-d');
            $carpeta = 'documentos/' . $fechaCarpeta;

            // Crear carpeta si no existe
            if (!file_exists(public_path($carpeta))) {
                mkdir(public_path($carpeta), 0777, true);
            }

            foreach ($request->file('documentos') as $file) {
                $fechaHora = now()->format('Y-m-d_H-i-s');
                $uniqueId = uniqid(); // o Str::uuid()
                $nombreOriginal = $file->getClientOriginalName();
                $filename = $fechaHora . '_' . $uniqueId . '_' . $nombreOriginal;
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                $file->move(public_path($carpeta), $filename);

                $rutaCompleta = $carpeta . '/' . $filename;

                $uploadedFiles[] = $filename;
                $ruta_doc[] = $rutaCompleta;

                $subido_por = Auth::user()->id;

                $documentos = Documento::create([
                    'id_ticket_estado' => $id_estadoFecha,
                    'nombre_original' => $nombreOriginal,
                    'extension' => $extension,
                    'ruta_documento' => $rutaCompleta,
                    'tamano_bytes' => $size,
                    'subido_por' => $subido_por,
                    'fecha_subida' => now(),
                    'estado' => true,
                ]);
            }

        }

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Documento añadido.');
    }

    public function subir(Request $request)
    {
        
        $uploadedFiles = [];
        $ruta_doc = [];

        if ($request->hasFile('archivos')) {
            // Carpeta por fecha: "uploads/2025-07-18/"
            $fechaCarpeta = now()->format('Y-m-d');
            $carpeta = 'documentos/' . $fechaCarpeta;

            // Crear carpeta si no existe
            if (!file_exists(public_path($carpeta))) {
                mkdir(public_path($carpeta), 0777, true);
            }

            foreach ($request->file('archivos') as $file) {
                $fechaHora = now()->format('Y-m-d_H-i-s');
                $uniqueId = uniqid(); // o Str::uuid()
                $nombreOriginal = $file->getClientOriginalName();
                $filename = $fechaHora . '_' . $uniqueId . '_' . $nombreOriginal;

                $file->move(public_path($carpeta), $filename);

                $rutaCompleta = $carpeta . '/' . $filename;

                $uploadedFiles[] = $filename;
                $ruta_doc[] = $rutaCompleta;
            }

            return response()->json([
                'success' => true,
                'files' => $uploadedFiles,
                'rutas' => $ruta_doc,
                'resorse' => $request->cliente,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontraron archivos para subir.',
            'resorse' => $request->cliente,
        ], 400);
    }

    
    public function descripTicketupd(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'nombre_ticket' => $request->descrip_tick,
        ]);

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Se cambió la descripción del ticket');
    }

    public function solicitanteTicketupd(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->solicitante_tick = strtoupper($request->solicitante_tick);

        $ticket->update([
            'solicitante' => $request->solicitante_tick,
        ]);

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Se editó el solicitante');
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'status' => false,
        ]);

        return redirect()->back()->with('success', 'Ticket eliminado correctamente.');

    }

    public function hesTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'num_hes' => $request->num_hes,
        ]);

        return redirect()->back()->with('success', 'Numero de la Hes actualizado.');
    }

}
