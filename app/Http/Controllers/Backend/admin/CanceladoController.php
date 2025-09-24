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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CanceladoController extends Controller
{

    public function index(Request $request)
    {
        $clientes = Cliente::where('estado', true)->get();

        $cancelados = collect();
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
            $cancelados     = $tickets->where('estado.id', 9);
        }
        return view('admin.cancel.index', compact('clientes', 'tickets', 'cancelados'));
    }

    public function restaurar($id)
    {
        $ticket = Ticket::findOrFail($id);
        $id_estado = 1;
        $descripcion = 'Ticket Restaurado';

        $ticket->update([
            'id_estado' => $id_estado,
        ]);

        $estado_fecha_ticket = EstadoFechaTicket::create([
            'id_ticket' => $id,
            'id_estado' => $id_estado,
            'fecha_estado' => now(),
            'descripcion' => $descripcion ?? null,
        ]);
        return redirect()->back()->with('success', 'Ticket Restaurado');
    }

    public function show($id){
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

        $consultores = Consultor::where('estado', true)
            ->with(['usuario', 'roles' => function ($query) {
                $query->where('estado', true);
            }])
            ->get();
        $abaps = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'abap');
        });
        // $funcionales = $consultores->filter(function ($consultor) {
        //     return $consultor->roles->contains('detalle', 'funcional');
        // });

        $funcionales = ConsultorModulo::where('id_modulo', $ticket->modulo->id)
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
        
        return view('admin.cancel.show', compact('ticket', 'estado_fechas_tickets', 'history_ticket_costos', 
            'abaps', 'funcionales', 'estados')); 
    }
}