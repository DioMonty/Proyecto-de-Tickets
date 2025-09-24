<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\ClienteModulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteModuloController extends Controller
{

    public function store(Request $request, $id)
    {
        $modulosSeleccionados = $request->input('modulos', []);
        $costosSoporte = $request->input('costo_soporte', []);
        $costosProyecto = $request->input('costo_proyecto', []);
        $costosBolsaHora = $request->input('costo_bolsa_hora', []);

        // Desactivar todos los módulos anteriores del consultor
        ClienteModulo::where('id_cliente', $id)->update(['estado' => false]);

        foreach ($modulosSeleccionados as $moduloId) {
            $registro = ClienteModulo::updateOrCreate(
                ['id_cliente' => $id, 'id_modulo' => $moduloId],
                [
                    'costo_soporte' => $costosSoporte[$moduloId] ?? 0,
                    'costo_proyecto' => $costosProyecto[$moduloId] ?? 0,
                    'costo_bolsa_hora' => $costosBolsaHora[$moduloId] ?? 0,
                    'estado' => true,
                ]
            );
        }

        return redirect()->back()->with('success', 'Módulos guardados correctamente.');
    }

}
