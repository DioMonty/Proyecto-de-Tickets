<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Ticket;
use App\Models\Modulo;
use App\Models\Consultor;
use App\Models\Estado;
use App\Models\UserSociety;
use App\Models\Usuario;
use App\Models\HistoryTicketUser;
use App\Models\HistoryTicketCosto;
use App\Models\EstadoFechaTicket;
use App\Models\FacturaTicket;
use App\Models\RolConsultor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        
        return view('admin.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modulos = Modulo::where('estado', true)->get();
        $consultores = Consultor::where('estado', true)
        ->with(['usuario', 'roles' => function ($query) {
            $query->where('estado', true);
        }])
        ->get();

        // Filtrar según el detalle del rol
        $funcionales = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'funcional');
        });

        $abaps = $consultores->filter(function ($consultor) {
            return $consultor->roles->contains('detalle', 'abap');
        });

        $clientes = Usuario::where('status', 'active')
        ->where('role', 'user')
        ->get();

        $estados = Estado::where('estado', true)->get();
        return view('admin.ticket.create', compact('modulos', 'funcionales', 'abaps', 'estados', 'clientes'));
    }
    public function getSociedades($id)
    {
        $sociedades = UserSociety::where('id_cliente', $id)
            ->where('estado', true)
            ->with('sociedad')
            ->get()
            ->pluck('sociedad'); 

        return response()->json($sociedades);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_ticket' => 'required|string|max:255',
            'tipo_ticket' => 'required|string|max:50',
            'oc_bolsa' => 'nullable|string|max:50',
            'id_modulo' => 'required|exists:modulos,id',
            'id_estado' => 'required|exists:estados,id',
            'id_cliente' => 'required|exists:users,id',
            'id_sociedad' => 'required|exists:user_societies,id',
            'solicitante' => 'required|string|max:255',
            'id_abap' => 'nullable|exists:consultors,id',
            'hora_abap' => 'nullable|numeric|min:0',
            'costo_abap' => 'nullable|numeric|min:0',
            'id_funcional' => 'nullable|exists:consultors,id',
            'hora_funcional' => 'nullable|numeric|min:0',
            'costo_funcional' => 'nullable|numeric|min:0',
            'costo_total' => 'nullable|numeric|min:0',
            'total_horas' => 'nullable|numeric|min:0',
            'fecha_prd' => 'nullable|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_resolucion' => 'nullable|date'
        ]);

        $ticket = Ticket::create([
            'nombre_ticket' => $request->nombre_ticket,
            'tipo_ticket' => $request->tipo_ticket,
            'oc_bolsa' => $request->oc_bolsa,
            'id_modulo' => $request->id_modulo,
            'id_estado' => $request->id_estado,
            'id_cliente' => $request->id_cliente,
            'id_sociedad' => $request->id_sociedad,
            'solicitante' => $request->solicitante,
            'id_abap' => $request->id_abap,
            'hora_abap' => $request->hora_abap,
            'costo_abap' => $request->costo_abap,
            'id_funcional' => $request->id_funcional,
            'hora_funcional' => $request->hora_funcional,
            'costo_funcional' => $request->costo_funcional,
            'costo_total' => $request->costo_total,
            'total_horas' => $request->total_horas,
            'fecha_prd' => $request->fecha_prd,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_resolucion' => $request->fecha_resolucion
        ]);
        //crear estado ticket
        $idticket = $ticket->id;
        $abap = RolConsultor::where('id_consult', $request->id_abap)
            ->where('estado', true)
            ->where('detalle', 'abap')
        ->get();
        $funcional = RolConsultor::where('id_consult', $request->id_abap)
            ->where('estado', true)
            ->where('detalle', 'funcional')
        ->get();
        $history_ticket_users_abap = HistoryTicketUser::create([
            'id_ticket' => $idticket,
            'id_consultor' => $abap->id_consult,
            'id_rol' => $abap->id,
        ]);
        $history_ticket_users_func = HistoryTicketUser::create([
            'id_ticket' => $idticket,
            'id_consultor' => $funcional->id_consult,
            'id_rol' => $funcional->id,
        ]);

        $history_ticket_costos_abap = HistoryTicketCosto::create([
            'id_ticket' => $idticket,
            'rol' => 'abap',
            'condicion' => 'normal',
            'horas' => $request->hora_abap,
            'estado' => true,
        ]);
        $history_ticket_costos_func = HistoryTicketCosto::create([
            'id_ticket' => $idticket,
            'rol' => 'funcional',
            'condicion' => 'normal',
            'horas' => $request->hora_funcional,
            'estado' => true,
        ]);
        
        $estado_fecha_ticket = EstadoFechaTicket::create([
            'id_ticket' => $idticket,
            'id_estado' => $request->id_estado,
            'fecha_estado' => now(),
            'descripcion' => $request->descripcion ?? null,
        ]);

        return redirect()->route('admin.ticket')->with('success', __('Ticket created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
