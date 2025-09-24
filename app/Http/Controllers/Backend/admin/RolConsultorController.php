<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\RolConsultor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolConsultorController extends Controller
{
    public function store(Request $request, $idConsultor)
    {
        $tipos = ['abap' => $request->has('tipo_abap'), 'funcional' => $request->has('tipo_funcional')];

        foreach ($tipos as $detalle => $activo) {
            $rol = RolConsultor::where('id_consult', $idConsultor)
                ->where('detalle', $detalle)
                ->first();

            if ($activo) {
                if ($rol) {
                    $rol->estado = true;
                    $rol->save();
                } else {
                    RolConsultor::create([
                        'id_consult' => $idConsultor,
                        'detalle' => $detalle,
                        'estado' => true,
                    ]);
                }
            } else {
                if ($rol) {
                    $rol->estado = false; // eliminaci¨®n l¨®gica
                    $rol->save();
                }
            }
        }

        return redirect()->route('admin.consultor')->with('success', 'Roles actualizados correctamente.');
    }

}
