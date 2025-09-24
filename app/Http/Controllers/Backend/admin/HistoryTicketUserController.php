<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\HistoryTicketUser;
use App\Models\Ticket;
use App\Models\RolConsultor;
use App\Models\ConsultorModulo;
use App\Models\Consultor;
use App\Models\ClienteModulo;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class HistoryTicketUserController extends Controller
{
    public function putAbapCambio(Request $request, $id)
    {
        $ticket_data = Ticket::where('id', $id)->first();
        $ticket = Ticket::findOrFail($id);
        $abap_rol = RolConsultor::where('id_consult', $request->abap_cam)
            ->where('estado', true)
            ->where('detalle', 'abap')
        ->first();

        HistoryTicketUser::create([
            'id_ticket' => $id,
            'id_consultor' => $request->abap_cam,
            'id_rol' => $abap_rol->id,
        ]);

        $ticket->update([
            'id_abap' => $request->abap_cam,
        ]);

        if ($ticket_data->costo_abap == 0.00) {

            $moduloAbap = Modulo::where('abre_modulo', 'ABAP')
                ->orWhere('desc_modulo', 'ABAP')
                ->first();

            $clienteModuloAbap = ClienteModulo::where('id_cliente', $ticket_data->id_cliente)
                ->where('id_modulo', $moduloAbap->id)
                ->where('estado', true)
                ->first();

            $campoCostoAbap = match ($ticket_data->tipo_costo) {
                'soporte'    => 'costo_soporte',
                'proyecto'   => 'costo_proyecto',
                'bolsa_hora' => 'costo_bolsa_hora',
                default      => null,
            };

            $abap_costo = $clienteModuloAbap->$campoCostoAbap;

            // $costo = Consultor::where('id', $request->abap_cam)->first();

            $ticket->update([
                // 'costo_abap' => $costo->costo ?? 0.00,
                'costo_abap' => $abap_costo ?? 0.00,
            ]);
        }

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Cambio de Abap correctamente.');

    }
    public function putFuncionalCambio(Request $request, $id)
    {
        $ticket_data = Ticket::where('id', $id)->first();
        $ticket = Ticket::findOrFail($id);
        $funcional_rol = RolConsultor::where('id_consult', $request->funcional_cam)
            ->where('estado', true)
            ->where('detalle', 'funcional')
        ->first();
        HistoryTicketUser::create([
            'id_ticket' => $id,
            'id_consultor' => $request->funcional_cam,
            'id_rol' => $funcional_rol->id,
        ]);

        $ticket->update([
            'id_funcional' => $request->funcional_cam,
        ]);
        
        if ($ticket_data->costo_funcional == 0.00) {

            $clienteModuloFun = ClienteModulo::where('id_cliente', $ticket_data->id_cliente)
                ->where('id_modulo', $ticket_data->id_modulo)
                ->where('estado', true)
                ->first();

            $campoCostoFun = match ($ticket_data->tipo_costo) {
                'soporte' => 'costo_soporte',
                'proyecto' => 'costo_proyecto',
                'bolsa_hora' => 'costo_bolsa_hora',
                default => null
            };
            $funcional_costo = $clienteModuloFun->$campoCostoFun;

            // $costo = ConsultorModulo::where('id_consultor', $request->funcional_cam)
            // ->where('id_modulo', $ticket_data->id_modulo)->first();

            $ticket->update([
                // 'costo_funcional' => $costo->costo_cliente ?? 0.00,
                'costo_funcional' => $funcional_costo ?? 0.00,
            ]);
        }


        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Cambio de Funcional correctamente.');

    }
    
}
