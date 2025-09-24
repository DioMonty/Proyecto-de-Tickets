<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Sociedad;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SociedadController extends Controller
{
    public function index()
    {
        // $sociedades = Sociedad::with([
        //     'cliente',
        // ])->get();
        $sociedades = Sociedad::with('cliente')
        ->join('clientes', 'sociedads.id_cliente', '=', 'clientes.id')
        ->orderBy('clientes.descripcion', 'asc') // 👈 A a Z
        ->select('sociedads.*')
        ->get();
        $clientes = Cliente::where('estado', true)->get();

        return view('admin.society.index', compact('sociedades', 'clientes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre_sociedad' => 'required|string|max:100',
            'id_cliente' => 'required|string|max:100',
            'razon_social' => 'required|string|max:100',
            'ruc' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
        ]);

        $nombre_sociedad = strtoupper($request->nombre_sociedad);
        $razon_social = strtoupper($request->razon_social);
        $direccion = strtoupper($request->direccion);

        Sociedad::create([
            'nombre_sociedad' => $nombre_sociedad,
            'id_cliente' => $request->id_cliente,
            'razon_social' => $razon_social,
            'ruc' => $request->ruc,
            'direccion' => $direccion,
            'estado' => true, // por defecto, la sociedad está activa
        ]);

        return redirect()->route('admin.society')->with('success', 'Sociedad creada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $sociedad = Sociedad::findOrFail($id);
        $request->validate([
            'nombre_sociedad' => 'required|string|max:100',
            'id_cliente' => 'required|string|max:100',
            'razon_social' => 'required|string|max:100',
            'ruc' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
        ]);

        $nombre_sociedad = strtoupper($request->nombre_sociedad);
        $razon_social = strtoupper($request->razon_social);
        $direccion = strtoupper($request->direccion);

        $sociedad->update([
            'nombre_sociedad' => $nombre_sociedad,
            'id_cliente' => $request->id_cliente,
            'razon_social' => $razon_social,
            'ruc' => $request->ruc,
            'direccion' => $direccion,
        ]);

        return redirect()->route('admin.society')->with('success', 'Sociedad actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $sociedad = Sociedad::findOrFail($id);
        $sociedad->estado = false; // Cambiar el estado a inactivo
        $sociedad->save();

        return redirect()->route('admin.society')->with('success', 'Sociedad eliminada exitosamente.');
    }
    public function cambiarEstado(Request $request, $id)
    {
        $modulo = Sociedad::findOrFail($id);
        $modulo->estado = filter_var($request->estado, FILTER_VALIDATE_BOOLEAN);
        $modulo->save();

        return response()->json(['success' => true, 'estado' => $modulo->estado]);
    }
}
