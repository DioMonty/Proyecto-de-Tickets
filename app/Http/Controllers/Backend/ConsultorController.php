<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Consultor;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ConsultorController extends Controller
{
    public function dashboard()
    {
        $id_usuario = Auth::user()->id;
        $consultor = Consultor::where('id_usuario', $id_usuario)->first();

        $tickets = Ticket::where(function ($query) use ($consultor) {
            $query->where('id_abap', $consultor->id)
                ->orWhere('id_funcional', $consultor->id);
            })
            ->with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
            ->where('status', true)
            ->get();

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
        $cancelados = $tickets->filter(function ($ticket) {
            return $ticket->estado && $ticket->estado->id === 9;
        });

        $hoy = Carbon::now();
        $totales_mes = Ticket::where(function ($query) use ($consultor) {
            $query->where('id_abap', $consultor->id)
                ->orWhere('id_funcional', $consultor->id);
            })
            ->with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
            ->where('status', true)
            ->whereMonth('created_at', $hoy->month)
            ->whereYear('created_at', $hoy->year)
            ->get();

        $estados = (object) [
            'mes' => $totales_mes->count(),
            'totales' => $tickets->count(),
            'pendientes' => $pendientes->count(),
            'estimados' => $estimados->count(),
            'aprobados' => $aprobados->count(),
            'planificados' => $planificados->count(),
            'observados' => $observados->count(),
            'prueba_cliente' => $prueba_clientes->count(),
            'cerrados' => $cerrados->count(),
            'facturados' => $facturados->count(),
            'cancelados' => $cancelados->count(),
        ];

        $oc = $facturados ? $facturados->where('tipo_ticket','OC') : collect();
        $bolsa = $facturados ? $facturados->where('tipo_ticket','Bolsa'): collect();

        $ticketsPorMes = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });


        $tickets_mes = $facturados ? Ticket::where(function ($query) use ($consultor) {
            $query->where('id_abap', $consultor->id)
                ->orWhere('id_funcional', $consultor->id);
            })
            ->with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
            ->where('status', true)
            ->whereYear('fecha_resolucion', Carbon::now()->year)
            ->get() : collect();

        $conteos = $tickets_mes->groupBy(function ($ticket) {
            return Carbon::parse($ticket->fecha_resolucion)->month;
        })->map->count();

        foreach ($conteos as $mes => $count) {
            $ticketsPorMes[$mes] = $count;
        }

        return view('consultor.dashboard', compact('pendientes', 
        'estimados', 'aprobados', 'planificados', 'observados', 
        'prueba_clientes', 'cerrados', 'facturados', 'oc', 'bolsa',
        'ticketsPorMes', 'estados'));
    }

    
}
