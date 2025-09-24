<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Ticket;
use App\Models\HistoryTicketCosto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class HistoryTicketCostoController extends Controller
{
    
    public function store(Request $request, $id)
    {
        $condicion = 'normal';
        $ticket = Ticket::where('id', $id)->first();
        $ticket_upd = Ticket::findOrFail($id);
        $hora_abap = 0;
        $costo_abap = 0;
        $costo_total = 0;
        $total_horas = 0;
        $hora_funcional = 0;
        $costo_funcional = 0;
        $hora_abap = $ticket->hora_abap;
        $costo_total = $ticket->costo_total;
        $total_horas = $ticket->total_horas;
        $hora_funcional = $ticket->hora_funcional;

        if($request->consultor_costo === 'abap'){
            $hora_abap = $ticket->hora_abap + $request->horas_costo;
            $costo_abap = $request->horas_costo * $ticket->costo_abap;
            $costo_total = $costo_total + $costo_abap;
            $total_horas = $total_horas + $request->horas_costo;
        }elseif($request->consultor_costo === 'funcional'){
            $hora_funcional =  $ticket->hora_funcional + $request->horas_costo;
            $costo_funcional = $request->horas_costo * $ticket->costo_funcional;
            $costo_total = $costo_total + $costo_funcional;
            $total_horas = $total_horas + $request->horas_costo;
        }

        $validate = HistoryTicketCosto::where('id_ticket', $id)
            ->where('rol', $request->consultor_costo)
            ->where('condicion', $condicion)
            ->first();

        if(!empty($validate)){
            $history_ticket_costos_abap = HistoryTicketCosto::create([
                'id_ticket' => $id,
                'rol' => $request->consultor_costo,
                'condicion' => 'adicional',
                'horas' => $request->horas_costo,
                'estado' => true,
            ]);

        }else{
            $history_ticket_costos_abap = HistoryTicketCosto::create([
                'id_ticket' => $id,
                'rol' => $request->consultor_costo,
                'condicion' => 'normal',
                'horas' => $request->horas_costo,
                'estado' => true,
            ]);
        }

        $ticket_upd->update([
            'hora_abap' => $hora_abap,
            'hora_funcional' => $hora_funcional,
            'costo_total' => $costo_total,
            'total_horas' => $total_horas,
        ]);

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Costo registrado exitosamente.');
    }

    public function costoEditTicket(Request $request, $id)
    {
        $historial = HistoryTicketCosto::where('id', $id)->first();
        $historial_upd = HistoryTicketCosto::findOrFail($id);

        $ticket = Ticket::where('id', $historial->id_ticket)->first();
        $ticket_upd = Ticket::findOrFail($historial->id_ticket);

        $rol = $historial->rol;
        $a = 0;
        $b = 0.00;

        if($rol === 'abap'){
            if($request->horas_edit_costo > $historial->horas){
                $a = $request->horas_edit_costo - $historial->horas;
                $ticket->hora_abap = $ticket->hora_abap + $a;
                $b = $ticket->costo_abap * $a;
                $ticket->total_horas = $ticket->total_horas + $a;
                $ticket->costo_total = $ticket->costo_total + $b;
            } else {
                $a = $historial->horas - $request->horas_edit_costo;
                $ticket->hora_abap = $ticket->hora_abap - $a;
                $b = $ticket->costo_abap * $a;
                $ticket->total_horas = $ticket->total_horas - $a;
                $ticket->costo_total = $ticket->costo_total - $b;
            }
            $ticket_upd->update([
                'hora_abap' => $ticket->hora_abap,
                'costo_total' => $ticket->costo_total,
                'total_horas' => $ticket->total_horas,
            ]);

            $historial_upd->update([
                'horas' => $request->horas_edit_costo,
            ]);
        }
        if($rol === 'funcional'){
            if($request->horas_edit_costo > $historial->horas){
                $a = $request->horas_edit_costo - $historial->horas;
                $ticket->hora_funcional = $ticket->hora_funcional + $a;
                $b = $ticket->costo_funcional * $a;
                $ticket->total_horas = $ticket->total_horas + $a;
                $ticket->costo_total = $ticket->costo_total + $b;
            } else {
                $a = $historial->horas - $request->horas_edit_costo;
                $ticket->hora_funcional = $ticket->hora_funcional - $a;
                $b = $ticket->costo_funcional * $a;
                $ticket->total_horas = $ticket->total_horas - $a;
                $ticket->costo_total = $ticket->costo_total - $b;
            }
            $ticket_upd->update([
                'hora_funcional' => $ticket->hora_funcional,
                'costo_total' => $ticket->costo_total,
                'total_horas' => $ticket->total_horas,
            ]);

            $historial_upd->update([
                'horas' => $request->horas_edit_costo,
            ]);
        }

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($historial->id_ticket)])->with('success', 'Horas y costo actualizado correctamente.');
    }

    public function costoDeleteTicket($id)
    {
        $historial = HistoryTicketCosto::where('id', $id)->first();
        $historial_upd = HistoryTicketCosto::findOrFail($id);

        $ticket = Ticket::where('id', $historial->id_ticket)->first();
        $ticket_upd = Ticket::findOrFail($historial->id_ticket);

        $rol = $historial->rol;
        $a = 0.00;

        if($rol === 'abap'){
            $ticket->hora_abap = $ticket->hora_abap - $historial->horas;
            $ticket->total_horas = $ticket->total_horas - $historial->horas;
            $a = $ticket->costo_abap * $historial->horas;
            $ticket->costo_total = $ticket->costo_total - $a;

            $ticket_upd->update([
                'hora_abap' => $ticket->hora_abap,
                'costo_total' => $ticket->costo_total,
                'total_horas' => $ticket->total_horas,
            ]);

            $historial_upd->update([
                'estado' => false,
            ]);
        }
        if($rol === 'funcional'){
            $ticket->hora_funcional = $ticket->hora_funcional - $historial->horas;
            $ticket->total_horas = $ticket->total_horas - $historial->horas;
            $a = $ticket->costo_funcional * $historial->horas;
            $ticket->costo_total = $ticket->costo_total - $a;

            $ticket_upd->update([
                'hora_funcional' => $ticket->hora_funcional,
                'costo_total' => $ticket->costo_total,
                'total_horas' => $ticket->total_horas,
            ]);

            $historial_upd->update([
                'estado' => false,
            ]);
        }

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($historial->id_ticket)])->with('success', 'Costo eliminado correctamente.');
    }

}
