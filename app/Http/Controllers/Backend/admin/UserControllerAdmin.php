<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Usuario;
use App\Models\Consultor;
use App\Models\RolConsultor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserControllerAdmin extends Controller
{
    public function index()
    {
        //$users = Usuario::where('status', 'active')->get();
        $administradores = Usuario::where('role', 'admin')
            ->get()
            ->map(function ($user) {
            $nameParts = explode(',', $user->name, 2);
            $user->nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
            $user->apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';
            return $user;
            });
            $consultores = Usuario::where('role', 'consultor')
            ->get()
            ->map(function ($user) {
            $nameParts = explode(',', $user->name, 2);
            $user->nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
            $user->apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';
            return $user;
            });
            $users = Usuario::where('role', 'user')
            ->get()
            ->map(function ($user) {
            $nameParts = explode(',', $user->name, 2);
            $user->nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
            $user->apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';
            return $user;
            });
        return view('admin.users.index', compact('users', 'administradores', 'consultores'));
    }

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

        $request->name_user = strtoupper($request->name_user);
        $request->lastname_user = strtoupper($request->lastname_user);
        $request->username = strtoupper($request->username);


        $name = $request->name_user . ', ' . $request->lastname_user;
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_user' => 'required|string|max:100',
            'lastname_user' => 'nullable|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'phone' => 'nullable|string|min:8',
        ]);

        $request->name_user = strtoupper($request->name_user);
        $request->lastname_user = strtoupper($request->lastname_user);
        $request->username = strtoupper($request->username);

        $user = Usuario::findOrFail($id);
        $user_data = Usuario::where('id', $id)->first();
        $name = $request->name_user . ', ' . $request->lastname_user;
        $user->update([
            'name' => $name,
            'username' => $request->username ?? null, 
            'phone' => $request->phone ?? null,
            'email' => $request->email,
        ]);
        if($user_data->role === 'consultor'){
            $consultor_data = Consultor::where('id_usuario', $id)->first();
            $consultor = Consultor::findOrFail($consultor_data->id);
            
            $consultor->update([
                'telefono' => $request->phone ?? null,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function status(Request $request, $id)
    {
        $user = Usuario::findOrFail($id);

        $newStatus = filter_var($request->estado, FILTER_VALIDATE_BOOLEAN) ? 'active' : 'inactive';

        $user->update([
            'status' => $newStatus,
        ]);

        return response()->json([
            'success' => true,
            'status' => $user->status, 
        ]);
    }

}