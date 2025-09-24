<?php

namespace App\Http\Controllers\Backend\client;

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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TicketClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_usuario = Auth::user()->id;
        $sociedades = UserSociety::where('id_usuario', $id_usuario)
            ->where('estado', true)
            ->get();

        $pendientes = collect();
        $estimados = collect();
        $aprobados = collect();
        $planificados = collect();
        $observados = collect();
        $prueba_clientes = collect();
        $cerrados = collect();
        $facturados = collect();
        $tickets = collect();

        // if($request->filled('sociedad') || $request->filled('codigo')){
            // $baseQuery = Ticket::whereIn('di',$id)->get();
            $query = Ticket::whereIn('id_cliente', $sociedades->pluck('id_cliente'))
                ->whereIn('id_sociedad', $sociedades->pluck('id_sociedad'))
                ->with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
                ->where('status', true);

            // filtro por sociedad
            // if ($request->filled('sociedad') && $request->sociedad !== 'all') {
            //     $query->where('id_sociedad', $request->sociedad);
            // }

            // // filtro por código
            // if ($request->filled('codigo')) {
            //     $query->where('cod_ticket', 'like', '%' . $request->codigo . '%');
            // }

            // ejecutar query
            $tickets = $query->get();

            // Filtrar tickets por estado
            $pendientes = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 1;
            });
            $estimados = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 2;
            });
            $aprobados = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 3;
            });
            $planificados = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 4;
            });
            $observados = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 5;
            });
            $prueba_clientes = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 6;
            });
            $cerrados = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 7;
            });
            $facturados = $tickets->filter(function ($ticket) {
                return $ticket->estado && $ticket->estado->id === 8;
            });
        // }   

        
        
        return view('client.ticket.index', compact('tickets', 'pendientes', 
        'estimados', 'aprobados', 'planificados', 'observados', 
        'prueba_clientes', 'cerrados', 'facturados', 'sociedades')); 
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
            ->with(['estado', 'documentos'])
            ->get();

        $history_ticket_costos = HistoryTicketCosto::where('id_ticket', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $consultores = Consultor::where('estado', true)
            ->with(['usuario', 'roles' => function ($query) {
                $query->where('estado', true);
            }])
            ->get();
        $abaps = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'abap');
        });
        $funcionales = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'funcional');
        });
        
        return view('client.ticket.show', compact('ticket', 'estado_fechas_tickets', 'history_ticket_costos', 
            'abaps', 'funcionales', 'estados')); 
    }

    public function storeDocuTicket(Request $request, $id)
    {
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

        return redirect()->route('client.ticket.show', ['id' => Crypt::encrypt($id)])
        ->with('success', 'Documento añadido.');
    }

    public function allTicket(Request $request)
    {
        $id_usuario = Auth::user()->id;
        $sociedades = UserSociety::where('id_usuario', $id_usuario)
            ->where('estado', true)
            ->get();

        $ordenCompra = collect();
        $bolsa = collect();

        // if($request->filled('sociedad') || $request->filled('codigo')){
            // $baseQuery = Ticket::whereIn('di',$id)->get();
            $query = Ticket::whereIn('id_cliente', $sociedades->pluck('id_cliente'))
                ->whereIn('id_sociedad', $sociedades->pluck('id_sociedad'))
                ->with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
                ->where('id_estado', 7)
                ->where('status', true);

            // filtro por sociedad
            // if ($request->filled('sociedad') && $request->sociedad !== 'all') {
            //     $query->where('id_sociedad', $request->sociedad);
            // }

            // // filtro por código
            // if ($request->filled('codigo')) {
            //     $query->where('cod_ticket', 'like', '%' . $request->codigo . '%');
            // }

            // ejecutar query
            $tickets = $query->get();

            $ordenCompra = (clone $query)->where('tipo_ticket', 'OC')->get();
            $bolsa = (clone $query)->where('tipo_ticket', 'Bolsa')->get();
        // }   
        return view('client.ticket.allTicket', compact('ordenCompra', 'bolsa', 'sociedades')); 
    }

    public function vistaIndividual($id)
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
            ->with(['estado', 'documentos'])
            ->get();

        $history_ticket_costos = HistoryTicketCosto::where('id_ticket', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $consultores = Consultor::where('estado', true)
            ->with(['usuario', 'roles' => function ($query) {
                $query->where('estado', true);
            }])
            ->get();
        $abaps = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'abap');
        });
        $funcionales = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'funcional');
        });
        
        return view('client.ticket.allShow', compact('ticket', 'estado_fechas_tickets', 'history_ticket_costos', 
            'abaps', 'funcionales', 'estados')); 
    }

}
