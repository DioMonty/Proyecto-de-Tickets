<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all c  lients
        $clientes = Cliente::all();

        // Return the view with the list of clients
        return view('admin.cliente.index', compact('clientes'));
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
        // Validate the request data
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'ruc' => 'nullable|string|max:20',
            'razon_social' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:255',
        ]);

        // Create a new client
        Cliente::create($request->all());

        // Redirect back with success message
        return redirect()->route('admin.cliente')->with('success', 'Cliente created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

        $cliente->update([
            'descripcion' => $request->descripcion,
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'direccion' => $request->direccion,
            'email' => $request->email,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.cliente')->with('success', 'Cliente updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
