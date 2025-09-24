<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Ticket;
use App\Models\Consultor;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ajusta las condiciones a tus modelos reales
        $administradores = Usuario::where('role', 'admin')->get();
        $consultores = Usuario::where('role', 'consultor')->get();
        $users = Usuario::where('role', 'user')->get();
        $tickets = Ticket::where('status', true)->get();
        $pendientes     = $tickets->where('estado.id', 1);
        $estimados      = $tickets->where('estado.id', 2);
        $aprobados      = $tickets->where('estado.id', 3);
        $planificados   = $tickets->where('estado.id', 4);
        $observados     = $tickets->where('estado.id', 5);
        $prueba_clientes= $tickets->where('estado.id', 6);
        $cerrados       = $tickets->where('estado.id', 7);
        $facturados     = $tickets->where('estado.id', 8);
        $cancelados = $tickets->filter(function ($ticket) {
            return $ticket->estado && $ticket->estado->id === 9;
        });

        $totales_cantidad = Ticket::where('status', true)
            ->whereNotIn('id_estado', [8, 9])
            ->get();

        // dd($totales_cantidad);


        $clientes = Cliente::where('estado', true)->get();
        //mes de hoy
        $hoy = Carbon::now();
        $ticket_mes = Ticket::where('status', true)
            ->whereMonth('fecha_resolucion', $hoy->month)
            ->whereYear('fecha_resolucion', $hoy->year)
            ->whereNotIn('id_estado', [8, 9])
            ->get();
        
        $cantidad = (object) [
            'totales' => $totales_cantidad->count(),
            'completos_mes' => $ticket_mes->count(),
        ];

        $estados = (object) [
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

        $brisza = Consultor::where('estado', true)
            ->whereHas('usuario', function ($q) {
                $q->where('status', true)
                    ->where('username', 'BMESIAS');
            })
            ->first();
        $camila = Consultor::where('estado', true)
            ->whereHas('usuario', function ($q) {
                $q->where('status', true)
                    ->where('username', 'CPACHECO');
            })
            ->first();
        $keila = Consultor::where('estado', true)
            ->whereHas('usuario', function ($q) {
                $q->where('status', true)
                    ->where('username', 'KMAGALLANES');
            })
            ->first();
        $diosanto = Consultor::where('estado', true)
            ->whereHas('usuario', function ($q) {
                $q->where('status', true)
                    ->where('username', 'DMONTOYA');
            })
            ->first();
        $bryan = Consultor::where('estado', true)
            ->whereHas('usuario', function ($q) {
                $q->where('status', true)
                    ->where('username', 'BLEVANO');
            })
            ->first();


        $diego = Consultor::where('estado', true)
            ->whereHas('usuario', function ($q) {
                $q->where('status', true)
                    ->where('username', 'DLEGUA');
            })
            ->first();

        //tickets
        $b = $brisza ? Ticket::where('id_abap',$brisza->id)
            ->where('status', true)
            ->get() : collect();
        $a = $camila ? Ticket::where('id_abap',$camila->id)
            ->where('status', true)
            ->get() : collect();
        $c = $keila ? Ticket::where('id_abap',$keila->id)
            ->where('status', true)
            ->get() : collect();
        $d = $diosanto ? Ticket::where('id_abap',$diosanto->id)
            ->where('status', true)
            ->get() : collect();
        $e = $bryan ? Ticket::where('id_abap',$bryan->id)
            ->where('status', true)
            ->get() : collect();
        $f = $diego ? Ticket::where('id_abap',$diego->id)
            ->where('status', true)
            ->get() : collect();
        
        $oc = $facturados->where('tipo_ticket','OC');
        $bolsa = $facturados->where('tipo_ticket','Bolsa');

        $pendientes_a = $a ? $a->where('id_estado', 1) : collect();
            $pendientes_b = $b ? $b->where('id_estado', 1) : collect();
            $pendientes_c = $c ? $c->where('id_estado', 1) : collect();
            $pendientes_d = $d ? $d->where('id_estado', 1) : collect();
            $pendientes_e = $e ? $e->where('id_estado', 1) : collect();
            $pendientes_f = $f ? $f->where('id_estado', 1) : collect();
        
        $estimados_a = $a ? $a->where('id_estado', 2) : collect();
            $estimados_b = $b ? $b->where('id_estado', 2) : collect();
            $estimados_c = $c ? $c->where('id_estado', 2) : collect();
            $estimados_d = $d ? $d->where('id_estado', 2) : collect();
            $estimados_e = $e ? $e->where('id_estado', 2) : collect();
            $estimados_f = $f ? $f->where('id_estado', 2) : collect();

        $aprobados_a = $a ? $a->where('id_estado', 3) : collect();
            $aprobados_b = $b ? $b->where('id_estado', 3) : collect();
            $aprobados_c = $c ? $c->where('id_estado', 3) : collect();
            $aprobados_d = $d ? $d->where('id_estado', 3) : collect();
            $aprobados_e = $e ? $e->where('id_estado', 3) : collect();
            $aprobados_f = $f ? $f->where('id_estado', 3) : collect();

        $planificados_a = $a ? $a->where('id_estado', 4) : collect();
            $planificados_b = $b ? $b->where('id_estado', 4) : collect();
            $planificados_c = $c ? $c->where('id_estado', 4) : collect();
            $planificados_d = $d ? $d->where('id_estado', 4) : collect();
            $planificados_e = $e ? $e->where('id_estado', 4) : collect();
            $planificados_f = $f ? $f->where('id_estado', 4) : collect();

        $observados_a = $a ? $a->where('id_estado', 5) : collect();
            $observados_b = $b ? $b->where('id_estado', 5) : collect();
            $observados_c = $c ? $c->where('id_estado', 5) : collect();
            $observados_d = $d ? $d->where('id_estado', 5) : collect();
            $observados_e = $e ? $e->where('id_estado', 5) : collect();
            $observados_f = $f ? $f->where('id_estado', 5) : collect();

        $prueba_cliente_a = $a ? $a->where('id_estado', 6) : collect();
            $prueba_cliente_b = $b ? $b->where('id_estado', 6) : collect();
            $prueba_cliente_c = $c ? $c->where('id_estado', 6) : collect();
            $prueba_cliente_d = $d ? $d->where('id_estado', 6) : collect();
            $prueba_cliente_e = $e ? $e->where('id_estado', 6) : collect();
            $prueba_cliente_f = $f ? $f->where('id_estado', 6) : collect();

        $cerrados_a = $a ? $a->where('id_estado', 7) : collect();
            $cerrados_b = $b ? $b->where('id_estado', 7) : collect();
            $cerrados_c = $c ? $c->where('id_estado', 7) : collect();
            $cerrados_d = $d ? $d->where('id_estado', 7) : collect();
            $cerrados_e = $e ? $e->where('id_estado', 7) : collect();
            $cerrados_f = $f ? $f->where('id_estado', 7) : collect();

        $facturados_a = $a ? $a->where('id_estado', 8) : collect();
            $facturados_b = $b ? $b->where('id_estado', 8) : collect();
            $facturados_c = $c ? $c->where('id_estado', 8) : collect();
            $facturados_d = $d ? $d->where('id_estado', 8) : collect();
            $facturados_e = $e ? $e->where('id_estado', 8) : collect();
            $facturados_f = $f ? $f->where('id_estado', 8) : collect();

        //CAMILA
            // Inicializamos el array con 0 de enero a diciembre
            $ticketsPorMes_a = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $tickets_a = $camila ? Ticket::where('id_abap', $camila->id)
                ->whereYear('fecha_resolucion', Carbon::now()->year)
                ->where('status', true)
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteos_a = $tickets_a->groupBy(function ($ticket) {
                return Carbon::parse($ticket->fecha_resolucion)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteos_a as $mes => $count) {
                $ticketsPorMes_a[$mes] = $count;
            }
        //brisza
            $ticketsPorMes_b = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $tickets_b = $brisza ? Ticket::where('id_abap', $brisza->id)
                ->whereYear('fecha_resolucion', Carbon::now()->year)
                ->where('status', true)
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteos_b = $tickets_b->groupBy(function ($ticket) {
                return Carbon::parse($ticket->fecha_resolucion)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteos_b as $mes => $count) {
                $ticketsPorMes_b[$mes] = $count;
            }

        //keila
            $ticketsPorMes_c = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $tickets_c = $keila ? Ticket::where('id_abap', $keila->id)
                ->whereYear('fecha_resolucion', Carbon::now()->year)
                ->where('status', true)
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteos_c = $tickets_c->groupBy(function ($ticket) {
                return Carbon::parse($ticket->fecha_resolucion)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteos_c as $mes => $count) {
                $ticketsPorMes_c[$mes] = $count;
            }

        //diosanto
            $ticketsPorMes_d = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $tickets_d = $diosanto ? Ticket::where('id_abap', $diosanto->id)
                ->whereYear('fecha_resolucion', Carbon::now()->year)
                ->where('status', true)
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteos_d = $tickets_d->groupBy(function ($ticket) {
                return Carbon::parse($ticket->fecha_resolucion)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteos_d as $mes => $count) {
                $ticketsPorMes_d[$mes] = $count;
            }
        //bryan
            $ticketsPorMes_e = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $tickets_e = $bryan ? Ticket::where('id_abap', $bryan->id)
                ->whereYear('fecha_resolucion', Carbon::now()->year)
                ->where('status', true)
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteos_e = $tickets_e->groupBy(function ($ticket) {
                return Carbon::parse($ticket->fecha_resolucion)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteos_e as $mes => $count) {
                $ticketsPorMes_e[$mes] = $count;
            }
        //diego
            $ticketsPorMes_f = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $tickets_f = $diego ? Ticket::where('id_abap', $diego->id)
                ->whereYear('fecha_resolucion', Carbon::now()->year)
                ->where('status', true)
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteos_f = $tickets_f->groupBy(function ($ticket) {
                return Carbon::parse($ticket->fecha_resolucion)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteos_f as $mes => $count) {
                $ticketsPorMes_f[$mes] = $count;
            }

        //FACTURADOS
        //CAMILA
            $ticketsFacPorMes_a = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $ticketsFac_a = $camila ? Ticket::where('id_abap', $camila->id)
                ->where('status', true)
                ->where('id_estado', 8)
                ->whereNotNull('factura_id')
                ->whereHas('factura', function ($a) use ($hoy) {
                    $a->where('estado', true)
                    ->whereYear('fecha_factura', $hoy->year);
                })
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteosFac_a = $ticketsFac_a->groupBy(function ($ticket) {
                return Carbon::parse($ticket->factura->fecha_factura)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteosFac_a as $mes => $count) {
                $ticketsFacPorMes_a[$mes] = $count;
            }
        //BRISZA
            $ticketsFacPorMes_b = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $ticketsFac_b = $brisza ? Ticket::where('id_abap', $brisza->id)
                ->where('status', true)
                ->where('id_estado', 8)
                ->whereNotNull('factura_id')
                ->whereHas('factura', function ($a) use ($hoy) {
                    $a->where('estado', true)
                    ->whereYear('fecha_factura', $hoy->year);
                })
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteosFac_b = $ticketsFac_b->groupBy(function ($ticket) {
                return Carbon::parse($ticket->factura->fecha_factura)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteosFac_b as $mes => $count) {
                $ticketsFacPorMes_b[$mes] = $count;
            }
        //KEILA
            $ticketsFacPorMes_c = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $ticketsFac_c = $keila ? Ticket::where('id_abap', $keila->id)
                ->where('status', true)
                ->where('id_estado', 8)
                ->whereNotNull('factura_id')
                ->whereHas('factura', function ($a) use ($hoy) {
                    $a->where('estado', true)
                    ->whereYear('fecha_factura', $hoy->year);
                })
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteosFac_c = $ticketsFac_c->groupBy(function ($ticket) {
                return Carbon::parse($ticket->factura->fecha_factura)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteosFac_c as $mes => $count) {
                $ticketsFacPorMes_c[$mes] = $count;
            }
        //DIOSANTO
            $ticketsFacPorMes_d = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $ticketsFac_d = $diosanto ? Ticket::where('id_abap', $diosanto->id)
                ->where('status', true)
                ->where('id_estado', 8)
                ->whereNotNull('factura_id')
                ->whereHas('factura', function ($a) use ($hoy) {
                    $a->where('estado', true)
                    ->whereYear('fecha_factura', $hoy->year);
                })
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteosFac_d = $ticketsFac_d->groupBy(function ($ticket) {
                return Carbon::parse($ticket->factura->fecha_factura)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteosFac_d as $mes => $count) {
                $ticketsFacPorMes_d[$mes] = $count;
            }
        //BRYAN
            $ticketsFacPorMes_e = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $ticketsFac_e = $bryan ? Ticket::where('id_abap', $bryan->id)
                ->where('status', true)
                ->where('id_estado', 8)
                ->whereNotNull('factura_id')
                ->whereHas('factura', function ($a) use ($hoy) {
                    $a->where('estado', true)
                    ->whereYear('fecha_factura', $hoy->year);
                })
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteosFac_e = $ticketsFac_e->groupBy(function ($ticket) {
                return Carbon::parse($ticket->factura->fecha_factura)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteosFac_e as $mes => $count) {
                $ticketsFacPorMes_e[$mes] = $count;
            }
        //DIEGO
            $ticketsFacPorMes_f = collect(range(1, 12))->mapWithKeys(function ($mes) {
                return [$mes => 0];
            });

            // Traemos los tickets de ese abap con fecha_resolucion válida
            $ticketsFac_f = $diego ? Ticket::where('id_abap', $diego->id)
                ->where('status', true)
                ->where('id_estado', 8)
                ->whereNotNull('factura_id')
                ->whereHas('factura', function ($a) use ($hoy) {
                    $a->where('estado', true)
                    ->whereYear('fecha_factura', $hoy->year);
                })
                ->get() : collect();

            // Agrupamos por mes y contamos
            $conteosFac_f = $ticketsFac_f->groupBy(function ($ticket) {
                return Carbon::parse($ticket->factura->fecha_factura)->month;
            })->map->count();

            // Mezclamos con el array inicial
            foreach ($conteosFac_f as $mes => $count) {
                $ticketsFacPorMes_f[$mes] = $count;
            }

        return view('admin.dashboard', compact('administradores', 'consultores', 'users', 'tickets',
            'ticket_mes', 'cantidad', 'estados', 'pendientes', 'clientes',
            'estimados', 'aprobados', 'planificados', 'observados', 'prueba_clientes', 'cerrados', 'facturados',
            'a', 'b', 'c', 'd', 'e', 'f', 'oc', 'bolsa',
            'pendientes_a','pendientes_b', 'pendientes_c','pendientes_d', 'pendientes_e', 'pendientes_f',
            'estimados_a','estimados_b', 'estimados_c','estimados_d', 'estimados_e', 'estimados_f',
            'aprobados_a','aprobados_b', 'aprobados_c','aprobados_d', 'aprobados_e', 'aprobados_f',
            'planificados_a','planificados_b', 'planificados_c','planificados_d', 'planificados_e', 'planificados_f',
            'observados_a','observados_b', 'observados_c','observados_d', 'observados_e', 'observados_f',
            'prueba_cliente_a','prueba_cliente_b', 'prueba_cliente_c','prueba_cliente_d', 'prueba_cliente_e', 'prueba_cliente_f',
            'cerrados_a','cerrados_b', 'cerrados_c','cerrados_d', 'cerrados_e', 'cerrados_f',
            'facturados_a','facturados_b', 'facturados_c','facturados_d', 'facturados_e', 'facturados_f',
            'ticketsPorMes_a', 'ticketsPorMes_b', 'ticketsPorMes_c', 'ticketsPorMes_d', 'ticketsPorMes_e', 'ticketsPorMes_f',
            'ticketsFacPorMes_a', 'ticketsFacPorMes_b', 'ticketsFacPorMes_c', 'ticketsFacPorMes_d', 'ticketsFacPorMes_e', 'ticketsFacPorMes_f'));
    }
    public function login(){
        return view('admin.auth.login');
    }
    public function dashCliente($id_cliente = null)
{
    $hoy = Carbon::now();

    // 🔹 Query principal con filtro opcional por cliente
    $query = Ticket::with(['modulo', 'estado', 'cliente', 'sociedad', 'abap', 'funcional'])
        ->where('status', true);

    if (!empty($id_cliente) && $id_cliente != 0) {
        $query->where('id_cliente', $id_cliente);
    }

    $tickets = $query->get();

    // 🔹 Totales del mes usando la misma lógica
    $queryMes = Ticket::where('status', true)
        ->whereMonth('created_at', $hoy->month)
        ->whereYear('created_at', $hoy->year)
        ->whereNotIn('id_estado', [8, 9]);

    if (!empty($id_cliente) && $id_cliente != 0) {
        $queryMes->where('id_cliente', $id_cliente);
    }

    $totales_mes = $queryMes->count();

    $totales_cantidad = $tickets
        ->whereNotIn('estado.id', [8, 9])
        ->count();

    $estados = (object) [
        // 'totales'        => $tickets->count(),
        'totales'        => $totales_cantidad,
        'mes'            => $totales_mes,
        'pendientes'     => $tickets->where('id_estado', 1)->count(),
        'estimados'      => $tickets->where('id_estado', 2)->count(),
        'aprobados'      => $tickets->where('id_estado', 3)->count(),
        'planificados'   => $tickets->where('id_estado', 4)->count(),
        'observados'     => $tickets->where('id_estado', 5)->count(),
        'prueba_cliente' => $tickets->where('id_estado', 6)->count(),
        'cerrados'       => $tickets->where('id_estado', 7)->count(),
        'facturados'     => $tickets->where('id_estado', 8)->count(),
        'cancelados'     => $tickets->where('id_estado', 9)->count(),
    ];

    return response()->json($estados);
}



}
