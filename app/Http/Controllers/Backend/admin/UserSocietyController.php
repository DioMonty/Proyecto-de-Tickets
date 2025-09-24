<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\UserSociety;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Sociedad;
use App\Models\Cliente;
use App\Http\Controllers\Controller;

class UserSocietyController extends Controller
{
    public function index()
    {
        // $usuarios = Usuario::where('role', 'user')
        //     ->get()
        //     ->map(function ($user) {
        //         $nameParts = explode(',', $user->name, 2);
        //         $user->nombre = trim($nameParts[0] ?? '');
        //         $user->apellido = trim($nameParts[1] ?? '');

        //         // Obtener cliente único desde user_society
        //         $cliente = UserSociety::where('id_usuario', $user->id)
        //     ->where('user_societies.estado', true) // 👈 tabla especificada
        //     ->with('cliente')
        //     ->join('clientes', 'user_societies.id_cliente', '=', 'clientes.id')
        //     ->orderBy('clientes.descripcion', 'asc')
        //     ->select('user_societies.*')
        //     ->first();


        //         $user->cliente_asignado = $cliente ? $cliente->cliente : null;

        //         return $user;
        //     });
        $usuarios = Usuario::where('role', 'user')
    ->get()
    ->map(function ($user) {
        $nameParts = explode(',', $user->name, 2);
        $user->nombre = trim($nameParts[0] ?? '');
        $user->apellido = trim($nameParts[1] ?? '');

        $cliente = UserSociety::where('id_usuario', $user->id)
            ->where('user_societies.estado', true)
            ->with('cliente')
            ->first();

        $user->cliente_asignado = $cliente ? $cliente->cliente : null;

        return $user;
    })
    ->sortBy(fn($user) => $user->cliente_asignado->descripcion ?? '');


        $clientes = Cliente::where('estado', true)->get();
        $sociedades = Sociedad::where('estado', true)->get();

        $idclientes = UserSociety::where('estado', true)
            ->with(['usuario', 'cliente', 'sociedad' => function ($query) {
                $query->where('estado', true);
            }])
            ->get();

        return view('admin.userCliente.index', compact('usuarios', 'sociedades', 'idclientes', 'clientes'));
    }

    public function updateSociedades(Request $request, $id_usuario)
    {
        $sociedades = json_decode($request->input('sociedades_json', '[]'), true);

        if (!is_array($sociedades) || empty($sociedades)) {
            return back()->withErrors(['sociedades_json' => 'No se han enviado sociedades válidas.']);
        }

        // Validar que todas las sociedades pertenezcan al mismo cliente
        $clienteIds = [];

        foreach ($sociedades as $soc) {
            $sociedad = Sociedad::where('id', $soc['id_sociedad'] ?? null)->first();

            if (!$sociedad || !isset($sociedad->id_cliente)) {
                continue;
            }

            $clienteIds[] = $sociedad->id_cliente;
        }

        $clienteIds = array_unique($clienteIds);

        if (count($clienteIds) !== 1) {
            return redirect()->back()->with('error'
                , 'Todas las sociedades deben pertenecer al mismo cliente.');
        }

        $id_cliente = $clienteIds[0];

        // Eliminar asociaciones anteriores (soft delete)
        UserSociety::where('id_usuario', $id_usuario)->update(['estado' => false]);

        // Crear/actualizar nuevas asociaciones
        foreach ($sociedades as $soc) {
            $id_sociedad = $soc['id_sociedad'] ?? null;

            if (!$id_sociedad) continue;

            $rel = UserSociety::where('id_usuario', $id_usuario)
                ->where('id_sociedad', $id_sociedad)
                ->first();

            if ($rel) {
                $rel->update([
                    'id_cliente' => $id_cliente,
                    'estado' => true,
                ]);
            } else {
                UserSociety::create([
                    'id_usuario' => $id_usuario,
                    'id_cliente' => $id_cliente,
                    'id_sociedad' => $id_sociedad,
                    'estado' => true,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Sociedades actualizadas correctamente.');
    }

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
            'role' => 'user', 
            'status' => 'active',
        ]);
        return redirect()->route('admin.user_society')->with('success', 'Usuario creado exitosamente.');
    }

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
        $request->nombre = strtoupper($request->nombre);
        $request->apellido = strtoupper($request->apellido);
        $request->username = strtoupper($request->username);

        $name = $request->nombre . ', ' . $request->apellido;
        $user->update([
            'name' => $name,
            'username' => $request->username ?? null, 
            'phone' => $request->phone ?? null,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.user_society')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function getByCliente($id)
    {
        $sociedades = Sociedad::where('id_cliente', $id)->select('id', 'nombre_sociedad')->get();
        return response()->json($sociedades);
    }

}
