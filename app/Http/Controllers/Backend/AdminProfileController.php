<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }
    public function updateProfile(Request $request)
    {   
        $request->validate([
            'name'=> ['required','max:100'],
            'apellido'=> ['max:100'],
            'email' => ['required','email','unique:users,email,'.Auth::user()->id],
            'image' => ['image','max:2048']
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {

            if (File::exists(public_path($user->image)) && $user->image != 'uploads/avatar.png') {
                File::delete(public_path($user->image));
            }


            $image = $request->image;
            $imageName = rand() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $path = "/uploads/" . $imageName;
            $user->image = $path;
        }

        $nombre_completo = $request->name . ', ' . $request->apellido;
        $nombre_completo = strtoupper($nombre_completo);

        $user->name = $nombre_completo;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Sus datos se han actualizado exitosamente','Notificación');

        return redirect()->back();
    }
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],

        ]);

        if (Hash::check($request->password, $user->password)){
            toastr()->error('La nueva contraseña no puede ser igual a la contraseña actual.','Notificación');
        } else {
            toastr()->success('La contraseña se ha actualizado correctamente.','Notificación');
        }

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back();
    }
}
