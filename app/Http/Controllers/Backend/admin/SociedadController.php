<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Sociedad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SociedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sociedades = Sociedad::where('estado', true)->get();
        return view('admin.society.index', compact('sociedades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.society.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_sociedad' => 'required|string|max:100',
            'razon_social' => 'required|string|max:100',
            'ruc' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
        ]);

        Sociedad::create([
            'nombre_sociedad' => $request->nombre_sociedad,
            'razon_social' => $request->razon_social,
            'ruc' => $request->ruc,
            'direccion' => $request->direccion,
            'estado' => true, // por defecto, la sociedad está activa
        ]);

        return redirect()->route('admin.society')->with('success', 'Sociedad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sociedad = Sociedad::findOrFail($id);
        return view('admin.society.show', compact('sociedad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sociedad = Sociedad::findOrFail($id);
        return view('admin.society.edit', compact('sociedad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sociedad = Sociedad::findOrFail($id);
        $request->validate([
            'nombre_sociedad' => 'required|string|max:100',
            'razon_social' => 'required|string|max:100',
            'ruc' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
        ]);

        $sociedad->update([
            'nombre_sociedad' => $request->nombre_sociedad,
            'razon_social' => $request->razon_social,
            'ruc' => $request->ruc,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('admin.society')->with('success', 'Sociedad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sociedad = Sociedad::findOrFail($id);
        $sociedad->estado = false; // Cambiar el estado a inactivo
        $sociedad->save();

        return redirect()->route('admin.society')->with('success', 'Sociedad eliminada exitosamente.');
    }
}
