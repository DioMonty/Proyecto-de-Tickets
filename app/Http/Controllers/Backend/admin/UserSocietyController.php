<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\UserSociety;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Sociedad;
use App\Http\Controllers\Controller;

class UserSocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::where('status', 'active')
        ->where('role', 'user')
        ->get()
        ->map(function ($user) {
            $nameParts = explode(',', $user->name, 2);
            $user->nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
            $user->apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';
            return $user;
        });

        // Todas las sociedades disponibles para asignar en los modales
        $sociedades = Sociedad::where('estado', true)->get();

        $idclientes = UserSociety::where('estado', true)
        ->with(['usuario', 'sociedad' => function ($query) {
            $query->where('estado', true);
        }])
        ->get();

        return view('admin.userCliente.index', compact('usuarios', 'sociedades', 'idclientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

public function updateSociedades(Request $request, $id)
{
    $ids = json_decode($request->input('sociedades_json', '[]'), true);

    if (!is_array($ids)) {
        return back()->withErrors(['sociedades_json' => 'Error al procesar las sociedades.']);
    }

    // Desactivar todas las relaciones anteriores
    UserSociety::where('id_cliente', $id)->update(['estado' => false]);

    // Activar o crear nuevas
    foreach ($ids as $idSoc) {
        $rel = UserSociety::where('id_cliente', $id)->where('id_sociedad', $idSoc)->first();

        if ($rel) {
            $rel->estado = true;
            $rel->save();
        } else {
            UserSociety::create([
                'id_cliente' => $id,
                'id_sociedad' => $idSoc,
                'estado' => true
            ]);
        }
    }

    return redirect()->back()->with('success', 'Sociedades actualizadas correctamente.');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_user' => 'required|string|max:100',
            'lastname_user' => 'nullable|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'nullable|string|min:8',
            'password' => 'required|string|max:50',
        ]);

        $name = $request->name_user . ' ' . $request->lastname_user;
        $user = Usuario::create([
            'name' => $name,
            'username' => $request->username ?? null, 
            'phone' => $request->phone ?? null,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', 
            'status' => 'active',
        ]);
        return redirect()->route('admin.user_society')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserSociety $userSociety)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserSociety $userSociety)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'nullable|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'phone' => 'nullable|string|min:9',
        ]);

        $user = Usuario::findOrFail($id);
        $name = $request->nombre . ', ' . $request->apellido;
        $user->update([
            'name' => $name,
            'username' => $request->username ?? null, 
            'phone' => $request->phone ?? null,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.user_society')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSociety $userSociety)
    {
        //
    }
}
