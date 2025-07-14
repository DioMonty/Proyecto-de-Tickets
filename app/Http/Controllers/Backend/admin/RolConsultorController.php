<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\RolConsultor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolConsultorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
                    $rol->estado = false; // eliminación lógica
                    $rol->save();
                }
            }
        }

        return redirect()->route('admin.consultor')->with('success', 'Roles actualizados correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RolConsultor $rolConsultor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RolConsultor $rolConsultor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RolConsultor $rolConsultor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RolConsultor $rolConsultor)
    {
        //
    }
}
