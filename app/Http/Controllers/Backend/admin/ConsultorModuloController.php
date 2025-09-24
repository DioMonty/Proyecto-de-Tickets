<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\ConsultorModulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultorModuloController extends Controller
{
    public function store(Request $request,$id)
    {
        $modulosSeleccionados = $request->input('modulos', []);
        $costosFuncionales = $request->input('costo_funcional', []);

        // Desactivar todos los módulos anteriores del consultor
        ConsultorModulo::where('id_consultor', $id)->update(['estado' => false]);

        foreach ($modulosSeleccionados as $moduloId) {
            $registro = ConsultorModulo::updateOrCreate(
                ['id_consultor' => $id, 'id_modulo' => $moduloId],
                [
                    'costo_funcional' => $costosFuncionales[$moduloId] ?? 0,
                    'estado' => true,
                ]
            );
        }

        return redirect()->back()->with('success', 'Módulos guardados correctamente.');
    }
}
