<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\FacturaTicket;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\EstadoFechaTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\Estado;
use App\Models\HistoryTicketCosto;
use App\Models\ConsultorModulo;
use App\Models\Consultor;
use App\Models\Modulo;
use App\Models\ClienteModulo;

class FacturaTicketController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::where('estado', true)->get();

        $sinOC = collect();
        $ordenCompra = collect();
        $bolsa = collect();
        $baseTicket = collect();

        // Solo aplicar búsqueda si el usuario seleccionó algún filtro
        if ($request->filled('cliente') || $request->filled('codigo')) {

            $baseQuery = Ticket::query()->where('id_estado', 7)
            ->with(['cliente', 'sociedad', 'modulo', 'abap.usuario', 'funcional.usuario', 'factura']);

            // Filtro de cliente
            if ($request->filled('cliente') && $request->cliente !== 'all') {
                $baseQuery->where('id_cliente', $request->cliente);
            }

            // Filtro de código
            if ($request->filled('codigo')) {
                $baseQuery->where('cod_ticket', 'like', '%' . $request->codigo . '%');
            }

            // Subconjuntos
            $sinOC = (clone $baseQuery)->whereNull('tipo_ticket')->get();
            $ordenCompra = (clone $baseQuery)->where('tipo_ticket', 'OC')->get();
            $bolsa = (clone $baseQuery)->where('tipo_ticket', 'Bolsa')->get();
            $baseTicket= (clone $baseQuery)->get();
        }

        return view('admin.factura.index', compact('sinOC', 'ordenCompra', 'bolsa', 'clientes', 'baseTicket'));
    }

    public function ocBolsaAsing(Request $request)
    {

        $request->validate([
            'tickets_ids' => 'required|string',
            'tipo' => 'required|string|in:OC,Bolsa',
            'num_oc_bolsa_cam' => 'string'
        ]);

        $ids = explode(',', $request->tickets_ids);

        Ticket::whereIn('id', $ids)->update([
            'tipo_ticket' => $request->tipo,
            'oc_bolsa' => $request->num_oc_bolsa_cam ?? null ,
        ]);

        return redirect()->back()->with('success', 'OC - Bolsa asignados correctamente.');
    }

    public function facturarTicket(Request $request)
    {
        $ids = explode(',', $request->ids_tickets);

        $factura_id = FacturaTicket::create([
            'numero_factura' => $request->num_factura,
            'fecha_factura' => $request->date_factura,
            'estado' => true,
        ]);

        foreach ($ids as $id) {
            // FacturaTicket::create([
            //     'id_ticket' => $id,
            //     'numero_factura' => $request->num_factura,
            //     'fecha_factura' => $request->date_factura,
            //     'estado' => true,
            // ]);
            $ticket = Ticket::findOrFail($id);
            EstadoFechaTicket::create([
                'id_estado' => 8,
                'id_ticket' => $id,
                'fecha_estado' => $request->date_factura,
                'descripcion' => 'Factura de ticket',
            ]);
            $ticket->update([
                'id_estado' => 8,
                'factura_id' => $factura_id->id,
            ]);
            
        }

        return redirect()->back()->with('success', 'Tickets facturados correctamente.');
    }

    public function facturado(Request $request)
    {
        $clientes = Cliente::where('estado', true)->get();

        $ordenCompra = collect();
        $bolsa = collect();

        if (
            $request->filled('cliente') ||
            $request->filled('codigo') ||
            $request->filled('fecha_inicio') ||
            $request->filled('fecha_fin')
        ) {
            $baseQuery = Ticket::query()->where('id_estado', 8);

            // Filtro de cliente
            if ($request->filled('cliente') && $request->cliente !== 'all') {
                $baseQuery->where('id_cliente', $request->cliente);
            }

            // Filtro de código
            if ($request->filled('codigo')) {
                $baseQuery->where('cod_ticket', 'like', '%' . $request->codigo . '%');
            }

            // Filtro de rango de fechas en factura
            if ($request->filled('fecha_inicio') || $request->filled('fecha_fin')) {
                $baseQuery->whereHas('factura', function ($q) use ($request) {
                    $fechaInicio = $request->fecha_inicio;
                    $fechaFin = $request->fecha_fin;

                    // Si solo viene fecha_inicio → usarla como inicio y fin
                    if ($fechaInicio && !$fechaFin) {
                        $fechaFin = $fechaInicio;
                    }

                    // Si solo viene fecha_fin → usarla como inicio y fin
                    if ($fechaFin && !$fechaInicio) {
                        $fechaInicio = $fechaFin;
                    }

                    $q->whereDate('fecha_factura', '>=', $fechaInicio)
                    ->whereDate('fecha_factura', '<=', $fechaFin);
                });
            }

            // Subconjuntos
            $ordenCompra = (clone $baseQuery)->where('tipo_ticket', 'OC')->get();
            $bolsa = (clone $baseQuery)->where('tipo_ticket', 'Bolsa')->get();
        }

        return view('admin.factura.view', compact('ordenCompra', 'bolsa', 'clientes'));
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
        
        return view('admin.factura.show', compact('ticket', 'estado_fechas_tickets', 'history_ticket_costos', 
            'abaps', 'funcionales', 'estados')); 
    }

}
