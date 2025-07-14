<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\ConsultorController;
use App\Http\Controllers\Backend\ConsultorProfileController;
use App\Http\Controllers\Backend\admin\SociedadController;
use App\Http\Controllers\Backend\admin\ModuloController;
use App\Http\Controllers\Backend\admin\EstadoController;
use App\Http\Controllers\Backend\admin\ConsultorControllerAdmin;
use App\Http\Controllers\Backend\admin\UserControllerAdmin;
use App\Http\Controllers\Backend\admin\RolConsultorController;
use App\Http\Controllers\Backend\admin\ConsultorModuloController;
use App\Http\Controllers\Backend\admin\UserSocietyController;
use App\Http\Controllers\Backend\admin\TicketController;
use App\Http\Controllers\Backend\admin\ClienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'consultor':
            return redirect()->route('consultor.dashboard');
        default:
            return view('dashboard'); // solo usuarios comunes ven esta vista
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/profile/update/password', [AdminProfileController::class, 'updatePassword'])->name('admin.password.update');

    Route::get('/admin/society', [SociedadController::class, 'index'])->name('admin.society'); // Listado de sociedades
    Route::get('/admin/society/create', [SociedadController::class, 'create'])->name('admin.society.create'); // Formulario crear
    Route::post('/admin/society', [SociedadController::class, 'store'])->name('admin.society.store'); // Guardar nuevo
    Route::get('/admin/society/{id}', [SociedadController::class, 'show'])->name('admin.society.show'); // Mostrar uno
    Route::get('/admin/society/{id}/edit', [SociedadController::class, 'edit'])->name('admin.society.edit'); // Formulario editar
    Route::put('/admin/society/{sociedad}', [SociedadController::class, 'update'])->name('admin.society.update'); // Guardar edición
    Route::delete('/admin/society/{id}', [SociedadController::class, 'destroy'])->name('admin.society.destroy'); // Cambiar estado

    Route::get('/admin/modulo', [ModuloController::class, 'index'])->name('admin.modulo'); // Listado de modulos
    Route::get('/admin/modulo/create', [ModuloController::class, 'create'])->name('admin.modulo.create'); // Formulario crear
    Route::post('/admin/modulo', [ModuloController::class, 'store'])->name('admin.modulo.store'); // Guardar nuevo
    Route::get('/admin/modulo/{id}', [ModuloController::class, 'show'])->name('admin.modulo.show'); // Mostrar uno
    Route::get('/admin/modulo/{id}/edit', [ModuloController::class, 'edit'])->name('admin.modulo.edit'); // Formulario editar
    Route::put('/admin/modulo/{modulo}', [ModuloController::class, 'update'])->name('admin.modulo.update'); // Guardar edición
    Route::delete('/admin/modulo/{id}', [ModuloController::class, 'destroy'])->name('admin.modulo.destroy'); // Cambiar estado

    Route::get('/admin/estado', [EstadoController::class, 'index'])->name('admin.estado'); // Listado de estados
    Route::get('/admin/estado/create', [EstadoController::class, 'create'])->name('admin.estado.create'); // Formulario crear
    Route::post('/admin/estado', [EstadoController::class, 'store'])->name('admin.estado.store'); // Guardar nuevo
    Route::get('/admin/estado/{id}', [EstadoController::class, 'show'])->name('admin.estado.show'); // Mostrar uno
    Route::get('/admin/estado/{id}/edit', [EstadoController::class, 'edit'])->name('admin.estado.edit'); // Formulario editar
    Route::put('/admin/estado/{estado}', [EstadoController::class, 'update'])->name('admin.estado.update'); // Guardar edición
    Route::delete('/admin/estado/{id}', [EstadoController::class, 'destroy'])->name('admin.estado.destroy'); // Cambiar estado

    Route::get('/admin/consultor', [ConsultorControllerAdmin::class, 'index'])->name('admin.consultor'); // Listado de consultores
    Route::get('/admin/consultor/create', [ConsultorControllerAdmin::class, 'create'])->name('admin.consultor.create'); // Formulario crear
    Route::post('/admin/consultor', [ConsultorControllerAdmin::class, 'store'])->name('admin.consultor.store'); // Guardar nuevo
    Route::get('/admin/consultor/{id}', [ConsultorControllerAdmin::class, 'show'])->name('admin.consultor.show'); // Mostrar uno
    Route::get('/admin/consultor/{id}/edit', [ConsultorControllerAdmin::class, 'edit'])->name('admin.consultor.edit'); // Formulario editar
    Route::put('/admin/consultor/{consultor}', [ConsultorControllerAdmin::class, 'update'])->name('admin.consultor.update'); // Guardar edición
    Route::delete('/admin/consultor/{id}', [ConsultorControllerAdmin::class, 'destroy'])->name('admin.consultor.destroy'); // Cambiar estado

    Route::get('/admin/consultor/rol', [RolConsultorController::class, 'index'])->name('admin.consultor.rol'); // Listado de roles de consultores
    Route::get('/admin/consultor/rol/create', [RolConsultorController::class, 'create'])->name('admin.consultor.rol.create'); // Formulario crear
    Route::post('/admin/consultor/rol/{id}', [RolConsultorController::class, 'store'])->name('admin.consultor.rol.store'); // Guardar nuevo
    Route::get('/admin/consultor/rol/{id}', [RolConsultorController::class, 'show'])->name('admin.consultor.rol.show'); // Mostrar uno
    Route::get('/admin/consultor/rol/{id}/edit', [RolConsultorController::class, 'edit'])->name('admin.consultor.rol.edit'); // Formulario editar
    Route::put('/admin/consultor/rol/{rol}', [RolConsultorController::class, 'update'])->name('admin.consultor.rol.update'); // Guardar edición
    Route::delete('/admin/consultor/rol/{id}', [RolConsultorController::class, 'destroy'])->name('admin.consultor.rol.destroy'); // Cambiar estado

    Route::get('/admin/consultor/modulo', [ConsultorModuloController::class, 'index'])->name('admin.consultor.modulo'); // Listado de modulos de consultores
    Route::get('/admin/consultor/modulo/create', [ConsultorModuloController::class, 'create'])->name('admin.consultor.modulo.create'); // Formulario crear
    Route::post('/admin/consultor/{id}/modulo', [ConsultorModuloController::class, 'store'])->name('admin.consultor.modulo.store'); // Guardar nuevo
    Route::get('/admin/consultor/modulo/{id}', [ConsultorModuloController::class, 'show'])->name('admin.consultor.modulo.show'); // Mostrar uno
    Route::get('/admin/consultor/modulo/{id}/edit', [ConsultorModuloController::class, 'edit'])->name('admin.consultor.modulo.edit'); // Formulario editar
    Route::put('/admin/consultor/modulo/{modulo}', [ConsultorModuloController::class, 'update'])->name('admin.consultor.modulo.update'); // Guardar edición
    Route::delete('/admin/consultor/modulo/{id}', [ConsultorModuloController::class, 'destroy'])->name('admin.consultor.modulo.destroy'); //
    
    Route::get('/admin/users', [UserControllerAdmin::class, 'index'])->name('admin.users'); // Listado de usuarios
    Route::get('/admin/users/create', [UserControllerAdmin::class, 'create'])->name('admin.users.create'); // Formulario crear
    Route::post('/admin/users/', [UserControllerAdmin::class, 'store'])->name('admin.users.store'); // Guardar nuevo
    Route::get('/admin/users/{id}', [UserControllerAdmin::class, 'show'])->name('admin.users.show'); // Mostrar uno
    Route::get('/admin/users/{id}/edit', [UserControllerAdmin::class, 'edit'])->name('admin.users.edit'); // Formulario editar
    Route::put('/admin/users/{user}', [UserControllerAdmin::class, 'update'])->name('admin.users.update'); // Guardar edición
    Route::delete('/admin/users/{id}', [UserControllerAdmin::class, 'destroy'])->name('admin.users.destroy'); // Cambiar estado

    Route::get('/admin/cliente', [ClienteController::class, 'index'])->name('admin.cliente'); // Listado de clientes
    Route::get('/admin/cliente/create', [ClienteController::class, 'create'])->name('admin.cliente.create'); // Formulario crear
    Route::post('/admin/cliente', [ClienteController::class, 'store'])->name('admin.cliente.store'); // Guardar nuevo
    Route::get('/admin/cliente/{id}', [ClienteController::class, 'show'])->name('admin.cliente.show'); // Mostrar uno
    Route::get('/admin/cliente/{id}/edit', [ClienteController::class, 'edit'])->name('admin.cliente.edit'); // Formulario editar
    Route::put('/admin/cliente/{cliente}', [ClienteController::class, 'update'])->name('admin.cliente.update'); // Guardar edición
    Route::delete('/admin/cliente/{id}', [ClienteController::class, 'destroy'])->name('admin.cliente.destroy'); // Cambiar estado

    Route::get('/admin/user_society', [UserSocietyController::class, 'index'])->name('admin.user_society'); // Listado de sociedades de usuarios
    Route::get('/admin/user_society/create', [UserSocietyController::class, 'create'])->name('admin.user_society.create'); // Formulario crear
    Route::post('/admin/user_society', [UserSocietyController::class, 'store'])->name('admin.user_society.store'); // Guardar nuevo
    Route::get('/admin/user_society/{id}', [UserSocietyController::class, 'show'])->name('admin.user_society.show'); // Mostrar uno
    Route::get('/admin/user_society/{id}/edit', [UserSocietyController::class, 'edit'])->name('admin.user_society.edit'); // Formulario editar
    Route::put('/admin/user_society/{userSociety}', [UserSocietyController::class, 'update'])->name('admin.user_society.update'); // Guardar edición
    Route::delete('/admin/user_society/{id}', [UserSocietyController::class, 'destroy'])->name('admin.user_society.destroy'); // Cambiar estado
    Route::put('/admin/cliente/{id}/sociedades', [UserSocietyController::class, 'updateSociedades'])->name('admin.cliente.sociedad.update');

    Route::get('/admin/ticket', [TicketController::class, 'index'])->name('admin.ticket'); // Listado de tickets
    Route::get('/admin/ticket/create', [TicketController::class, 'create'])->name('admin.ticket.create'); // Formulario crear
    Route::get('/cliente/{id}/sociedades', [TicketController::class, 'getSociedades']); // Obtener sociedades por cliente
    Route::post('/admin/ticket', [TicketController::class, 'store'])->name('admin.ticket.store'); // Guardar nuevo
    Route::get('/admin/ticket/{id}', [TicketController::class, 'show'])->name('admin.ticket.show'); // Mostrar uno
    Route::get('/admin/ticket/{id}/edit', [TicketController::class, 'edit'])->name('admin.ticket.edit'); // Formulario editar
    Route::put('/admin/ticket/{ticket}', [TicketController::class, 'update'])->name('admin.ticket.update'); // Guardar edición
    Route::delete('/admin/ticket/{id}', [TicketController::class, 'destroy'])->name('admin.ticket.destroy'); // Cambiar estado
});

Route::middleware(['auth', 'role:consultor'])->group(function () {
    Route::get('/consultor/dashboard', [ConsultorController::class, 'dashboard'])->name('consultor.dashboard');
    Route::get('/consultor/profile', [ConsultorProfileController::class, 'index'])->name('consultor.profile');
    Route::post('/consultor/profile/update', [ConsultorProfileController::class, 'updateProfile'])->name('consultor.profile.update');
    Route::post('/consultor/profile/update/password', [ConsultorProfileController::class, 'updatePassword'])->name('consultor.password.update');
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
