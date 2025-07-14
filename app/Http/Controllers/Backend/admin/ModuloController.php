<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modulos = Modulo::where('estado', true)->get();
        return view('admin.modulo.index', compact('modulos'));
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
    public function store(Request $request)
    {
        $request->validate([
            'abre_modulo' => 'required|string|max:3',
            'desc_modulo' => 'nullable|string|max:255',
        ]);

        Modulo::create([
            'abre_modulo' => $request->abre_modulo,
            'desc_modulo' => $request->desc_modulo,
            'estado' => true, // por defecto, el módulo está activo
        ]);

        return redirect()->route('admin.modulo')->with('success', 'Módulo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $modulo = Modulo::findOrFail($id);
        return view('admin.modulos.show', compact('modulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modulo $modulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $modulo = Modulo::findOrFail($id);
        $request->validate([
            'abre_modulo' => 'required|string|max:3',
            'desc_modulo' => 'nullable|string|max:255',
        ]);

        $modulo->update([
            'abre_modulo' => $request->abre_modulo,
            'desc_modulo' => $request->desc_modulo,
        ]);

        return redirect()->route('admin.modulo')->with('success', 'Módulo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->estado = false; // Cambiamos el estado a inactivo
        $modulo->save();

        return redirect()->route('admin.modulo')->with('success', 'Módulo desactivado exitosamente.');
    }
}
