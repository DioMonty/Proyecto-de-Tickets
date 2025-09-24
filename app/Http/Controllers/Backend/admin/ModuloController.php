<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulo::all();
        return view('admin.modulo.index', compact('modulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'abre_modulo' => 'required|string|max:6',
            'desc_modulo' => 'nullable|string|max:255',
        ]);
        
        $abre_modulo = strtoupper($request->abre_modulo);
        $desc_modulo = strtoupper($request->desc_modulo);

        Modulo::create([
            'abre_modulo' => $abre_modulo,
            'desc_modulo' => $desc_modulo,
            'estado' => true, // por defecto, el módulo está activo
        ]);

        return redirect()->route('admin.modulo')->with('success', 'Módulo creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $modulo = Modulo::findOrFail($id);
        $request->validate([
            'abre_modulo' => 'required|string|max:6',
            'desc_modulo' => 'nullable|string|max:255',
        ]);

        $abre_modulo = strtoupper($request->abre_modulo);
        $desc_modulo = strtoupper($request->desc_modulo);

        $modulo->update([
            'abre_modulo' => $abre_modulo,
            'desc_modulo' => $desc_modulo,
        ]);

        return redirect()->route('admin.modulo')->with('success', 'Módulo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->estado = false; // Cambiamos el estado a inactivo
        $modulo->save();

        return redirect()->route('admin.modulo')->with('success', 'Módulo desactivado exitosamente.');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->estado = filter_var($request->estado, FILTER_VALIDATE_BOOLEAN);
        $modulo->save();

        return response()->json(['success' => true, 'estado' => $modulo->estado]);
    }

}
