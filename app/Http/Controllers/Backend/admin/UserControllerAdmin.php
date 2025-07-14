<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Usuario;
use App\Models\Consultor;
use App\Models\RolConsultor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$users = Usuario::where('status', 'active')->get();
        $users = Usuario::where('status', 'active')
            ->get()
            ->map(function ($user) {
            $nameParts = explode(',', $user->name, 2);
            $user->nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
            $user->apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';
            return $user;
            });
        return view('admin.users.index', compact('users'));
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
            'name_user' => 'required|string|max:100',
            'lastname_user' => 'required|string|max:100',
            'username' => 'nullable|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'nullable|string|min:8',
            'password' => 'required|string|max:50',
            'rol' => 'required|string|max:50',
        ]);

        $name = $request->name_user . ' ' . $request->lastname_user;
        $user = Usuario::create([
            'name' => $name,
            'username' => $request->username ?? null, 
            'phone' => $request->phone ?? null,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->rol,
            'status' => 'active',
        ]);
        $createdUserId = $user->id;

        if($request->rol === 'consultor'){

            $consultor = Consultor::create([
                'id_usuario' => $createdUserId,
                'telefono' => $request->telefono ?? null,
                'costo' => '0.00', // por defecto, el costo es 0.00
                'estado' => true, // por defecto, el consultor está activo
            ]);

        }
        if($request->rol === 'admin'){
        }
        if($request->rol === 'user'){
        }

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultor $consultor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_user' => 'required|string|max:100',
            'lastname_user' => 'nullable|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'phone' => 'nullable|string|min:8',
        ]);

        $user = Usuario::findOrFail($id);
        $name = $request->name_user . ', ' . $request->lastname_user;
        $user->update([
            'name' => $name,
            'username' => $request->username ?? null, 
            'phone' => $request->phone ?? null,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultor $consultor)
    {
        //
    }
}
