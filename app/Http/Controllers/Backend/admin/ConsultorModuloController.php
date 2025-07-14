<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\ConsultorModulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultorModuloController extends Controller
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
    public function store(Request $request,$id)
    {
        $modulosSeleccionados = $request->input('modulos', []);
        $costosFuncionales = $request->input('costo_funcional', []);
        $costosClientes = $request->input('costo_cliente', []);

        // Desactivar todos los módulos anteriores del consultor
        ConsultorModulo::where('id_consultor', $id)->update(['estado' => false]);

        foreach ($modulosSeleccionados as $moduloId) {
            $registro = ConsultorModulo::updateOrCreate(
                ['id_consultor' => $id, 'id_modulo' => $moduloId],
                [
                    'costo_funcional' => $costosFuncionales[$moduloId] ?? 0,
                    'costo_cliente' => $costosClientes[$moduloId] ?? 0,
                    'estado' => true,
                ]
            );
        }

        return redirect()->back()->with('success', 'Módulos guardados correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultorModulo $consultorModulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConsultorModulo $consultorModulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConsultorModulo $consultorModulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsultorModulo $consultorModulo)
    {
        //
    }
}
