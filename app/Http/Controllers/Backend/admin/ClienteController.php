<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Cliente;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with([
            'modulos'
        ])->get();
        $modulos = Modulo::where('estado', true)->get();
        return view('admin.cliente.index', compact('clientes','modulos'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'ruc' => 'nullable|string|max:20',
            'razon_social' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:255',
        ]);

        $descripcion = strtoupper($request->descripcion);
        $razon_social = strtoupper($request->razon_social);
        $direccion = strtoupper($request->direccion);

        // Create a new client
        Cliente::create([
            'descripcion' => $descripcion,
            'ruc' => $request->ruc,
            'razon_social' => $razon_social,
            'direccion' => $direccion,
            'email' => $request->email,
            'estado' => true,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.cliente')->with('success', 'Cliente created successfully.');
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        // Validate the request data
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'ruc' => 'nullable|string|max:20',
            'razon_social' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:255',
        ]);

        $descripcion = strtoupper($request->descripcion);
        $razon_social = strtoupper($request->razon_social);
        $direccion = strtoupper($request->direccion);

        $cliente->update([
            'descripcion' => $descripcion,
            'ruc' => $request->ruc,
            'razon_social' => $razon_social,
            'direccion' => $direccion,
            'email' => $request->email,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.cliente')->with('success', 'Cliente updated successfully.');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $modulo = Cliente::findOrFail($id);
        $modulo->estado = filter_var($request->estado, FILTER_VALIDATE_BOOLEAN);
        $modulo->save();

        return response()->json(['success' => true, 'estado' => $modulo->estado]);
    }
}
