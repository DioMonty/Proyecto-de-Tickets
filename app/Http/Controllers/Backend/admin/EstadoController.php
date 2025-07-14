<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Estado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::where('estado', true)->get();
        return view('admin.estado.index', compact('estados'));
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
            'abre_estado' => 'required|string|max:3',
            'desc_estado' => 'required|string|max:255',
        ]);

        Estado::create([
            'abre_estado' => $request->abre_estado,
            'desc_estado' => $request->desc_estado,
            'estado' => true, // por defecto, el estado está activo
        ]);

        return redirect()->route('admin.estado')->with('success', 'Estado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $estado = Estado::findOrFail($id);
        return view('admin.estado.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $estado = Estado::findOrFail($id);

        $request->validate([
            'abre_estado' => 'required|string|max:3',
            'desc_estado' => 'required|string|max:255',
        ]);

        $estado->update([
            'abre_estado' => $request->abre_estado,
            'desc_estado' => $request->desc_estado,
        ]);

        return redirect()->route('admin.estado')->with('success', 'Estado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estado = Estado::findOrFail($id);
        $estado->estado = false; // Cambia el estado a inactivo
        $estado->save();

        return redirect()->route('admin.estado')->with('success', 'Estado eliminado exitosamente.');
    }
}
