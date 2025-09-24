<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Estado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// export
use App\Exports\EstadoExport;
use Maatwebsite\Excel\Facades\Excel;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::all();
        return view('admin.estado.index', compact('estados'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'abre_estado' => 'required|string|max:3',
            'desc_estado' => 'required|string|max:255',
        ]);

        $abre_estado = strtoupper($request->abre_estado);
        $desc_estado = strtoupper($request->desc_estado);

        Estado::create([
            'abre_estado' => $abre_estado,
            'desc_estado' => $desc_estado,
            'estado' => true, // por defecto, el estado está activo
        ]);

        return redirect()->route('admin.estado')->with('success', 'Estado creado exitosamente.');
    }
    public function update(Request $request, $id)
    {
        $estado = Estado::findOrFail($id);

        $request->validate([
            'abre_estado' => 'required|string|max:3',
            'desc_estado' => 'required|string|max:255',
        ]);

        $abre_estado = strtoupper($request->abre_estado);
        $desc_estado = strtoupper($request->desc_estado);

        $estado->update([
            'abre_estado' => $abre_estado,
            'desc_estado' => $desc_estado,
        ]);

        return redirect()->route('admin.estado')->with('success', 'Estado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $estado = Estado::findOrFail($id);
        $estado->estado = false; // Cambia el estado a inactivo
        $estado->save();

        return redirect()->route('admin.estado')->with('success', 'Estado eliminado exitosamente.');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $modulo = Estado::findOrFail($id);
        $modulo->estado = filter_var($request->estado, FILTER_VALIDATE_BOOLEAN);
        $modulo->save();

        return response()->json(['success' => true, 'estado' => $modulo->estado]);
    }

    public function export()
    {
        // el navegador preguntará dónde guardar el archivo
        return Excel::download(new EstadoExport, 'estados.xlsx');
    }
}
