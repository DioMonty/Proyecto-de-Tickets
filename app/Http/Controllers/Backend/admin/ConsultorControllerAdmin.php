<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Consultor;
use App\Models\Usuario;
use App\Models\RolConsultor;
use App\Models\Modulo;
use App\Models\ConsultorModulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultorControllerAdmin extends Controller
{
    public function index()
    {
        // Cargar los roles de consultor
        $consultores = Consultor::with([
            'usuario',
            'roles' => function ($query) {
                $query->where('estado', true);
            },
            'modulos'
        ])->get();

        // IDs de usuarios ya asignados como consultores
        $consultorIds = $consultores->pluck('id_usuario')->toArray();
        
        $usuarios = Usuario::where('role', 'consultor')
            ->where('status', 'active')
            ->whereNotIn('id', $consultorIds)
            ->get()
            ->map(function ($user) {
                $nameParts = explode(',', $user->name, 2);
                $user->nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
                $user->apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';
                return $user;
            });

        $modulos = Modulo::where('estado', true)->get();

        return view('admin.consultor.index', compact('consultores', 'usuarios', 'modulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_consultor' => 'required|exists:users,id',
            'telefono' => 'nullable|string|max:20',
            'ruc' => 'nullable|string|max:20',
            'banco' => 'nullable|string|max:50',
            'cta_banco' => 'nullable|string|max:50',
            'cta_cci' => 'nullable|string|max:50',
            'cta_detraccion' => 'nullable|string|max:50',
        ]);

        $banco = strtoupper($request->banco);

        Consultor::create([
            'id_usuario' => $request->id_consultor,
            'telefono' => $request->telefono ?? null,
            'ruc' => $request->ruc ?? null,
            'banco' => $banco ?? null,
            'cta_banco' => $request->cta_banco ?? null,
            'cta_cci' => $request->cta_cci ?? null,
            'cta_detraccion' => $request->cta_detraccion ?? null,
        ]);

        return redirect()->route('admin.consultor')->with('success', 'Consultor creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $consultor = Consultor::findOrFail($id);
        $consultor_data = Consultor::where('id', $id)->first();
        $usuario = Usuario::findOrFail($consultor_data->id_usuario);
        $request->validate([
            'telefono' => 'nullable|string|max:20',
            'ruc' => 'nullable|string|max:20',
            'banco' => 'nullable|string|max:50',
            'cta_banco' => 'nullable|string|max:50',
            'cta_cci' => 'nullable|string|max:50',
            'cta_detraccion' => 'nullable|string|max:50',
        ]);

        $banco = strtoupper($request->banco);

        $telefono = $request->telefono ?? null;
        
        $consultor->update([
            'telefono' => $request->telefono ?? null,
            'ruc' => $request->ruc ?? null,
            'banco' => $banco ?? null,
            'cta_banco' => $request->cta_banco ?? null,
            'cta_cci' => $request->cta_cci ?? null,
            'cta_detraccion' => $request->cta_detraccion ?? null,
            'costo' => $request->abap_costo ?? null,
        ]);
        $usuario->update([
            'phone' => $request->telefono,
        ]);

        return redirect()->route('admin.consultor')->with('success', 'Consultor actualizado exitosamente.');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $modulo = Consultor::findOrFail($id);
        $modulo->estado = filter_var($request->estado, FILTER_VALIDATE_BOOLEAN);
        $modulo->save();

        return response()->json(['success' => true, 'estado' => $modulo->estado]);
    }
}
