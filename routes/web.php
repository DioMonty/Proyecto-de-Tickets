<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\ConsultorController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\ConsultorProfileController;
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
use App\Http\Controllers\Backend\admin\HistoryTicketCostoController;
use App\Http\Controllers\Backend\admin\HistoryTicketUserController;
use App\Http\Controllers\Backend\admin\EstadoFechaTicketController;
use App\Http\Controllers\Backend\admin\FacturaTicketController;
use App\Http\Controllers\Backend\admin\DocumentoController;
use App\Http\Controllers\Backend\admin\CanceladoController;
use App\Http\Controllers\Backend\admin\ClienteModuloController;

use App\Http\Controllers\Backend\consultor\TicketConsultorController;

use App\Http\Controllers\Backend\client\TicketClientController;
use App\Http\Controllers\ClienteProfileController;

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
        case 'user':
            return redirect()->route('client.dashboard');
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
    Route::post('/admin/society', [SociedadController::class, 'store'])->name('admin.society.store'); // Guardar nuevo
    Route::put('/admin/society/{sociedad}', [SociedadController::class, 'update'])->name('admin.society.update'); // Guardar edición
    Route::delete('/admin/society/{id}', [SociedadController::class, 'destroy'])->name('admin.society.destroy'); // Cambiar estado
    Route::post('/admin/society/estado/{id}', [SociedadController::class, 'cambiarEstado']);

    Route::get('/admin/modulo', [ModuloController::class, 'index'])->name('admin.modulo'); // Listado de modulos
    Route::post('/admin/modulo', [ModuloController::class, 'store'])->name('admin.modulo.store'); // Guardar nuevo
    Route::put('/admin/modulo/{modulo}', [ModuloController::class, 'update'])->name('admin.modulo.update'); // Guardar edición
    Route::delete('/admin/modulo/{id}', [ModuloController::class, 'destroy'])->name('admin.modulo.destroy'); // Cambiar estado
    Route::post('/admin/modulo/estado/{id}', [ModuloController::class, 'cambiarEstado']);


    Route::get('/admin/estado', [EstadoController::class, 'index'])->name('admin.estado'); // Listado de estados
    Route::post('/admin/estado', [EstadoController::class, 'store'])->name('admin.estado.store'); // Guardar nuevo
    Route::put('/admin/estado/{estado}', [EstadoController::class, 'update'])->name('admin.estado.update'); // Guardar edición
    Route::delete('/admin/estado/{id}', [EstadoController::class, 'destroy'])->name('admin.estado.destroy'); // Cambiar estado
    Route::post('/admin/estado/estado/{id}', [EstadoController::class, 'cambiarEstado']);

    Route::get('/admin/consultor', [ConsultorControllerAdmin::class, 'index'])->name('admin.consultor'); // Listado de consultores
    Route::post('/admin/consultor', [ConsultorControllerAdmin::class, 'store'])->name('admin.consultor.store'); // Guardar nuevo
    Route::put('/admin/consultor/{consultor}', [ConsultorControllerAdmin::class, 'update'])->name('admin.consultor.update'); // Guardar edición
    Route::post('/admin/consultor/estado/{id}', [ConsultorControllerAdmin::class, 'cambiarEstado']);

    Route::post('/admin/consultor/rol/{id}', [RolConsultorController::class, 'store'])->name('admin.consultor.rol.store'); // Guardar nuevo

    Route::post('/admin/consultor/{id}/modulo', [ConsultorModuloController::class, 'store'])->name('admin.consultor.modulo.store'); // Guardar nuevo
    
    Route::get('/admin/users', [UserControllerAdmin::class, 'index'])->name('admin.users'); // Listado de usuarios
    Route::post('/admin/users/', [UserControllerAdmin::class, 'store'])->name('admin.users.store'); // Guardar nuevo
    Route::put('/admin/users/{user}', [UserControllerAdmin::class, 'update'])->name('admin.users.update'); // Guardar edición
    Route::post('/admin/users/status/{user}', [UserControllerAdmin::class, 'status']);

    Route::get('/admin/cliente', [ClienteController::class, 'index'])->name('admin.cliente'); // Listado de clientes
    Route::post('/admin/cliente', [ClienteController::class, 'store'])->name('admin.cliente.store'); // Guardar nuevo
    Route::put('/admin/cliente/{cliente}', [ClienteController::class, 'update'])->name('admin.cliente.update'); // Guardar edición
    Route::post('/admin/cliente/estado/{id}', [ClienteController::class, 'cambiarEstado']);
    Route::post('/admin/cliente/{id}/modulo', [ClienteModuloController::class, 'store'])->name('admin.cliente.modulo.store'); // Guardar nuevo
  
    Route::get('/admin/user_society', [UserSocietyController::class, 'index'])->name('admin.user_society'); // Listado de sociedades de usuarios
    Route::post('/admin/user_society', [UserSocietyController::class, 'store'])->name('admin.user_society.store'); // Guardar nuevo
    Route::put('/admin/user_society/{userSociety}', [UserSocietyController::class, 'update'])->name('admin.user_society.update'); // Guardar edición
    Route::put('/admin/cliente/{id}/sociedades', [UserSocietyController::class, 'updateSociedades'])->name('admin.cliente.sociedad.update');
    Route::get('/api/sociedades_por_cliente/{id}', [UserSocietyController::class, 'getByCliente']);


    Route::get('/admin/ticket', [TicketController::class, 'index'])->name('admin.ticket'); // Listado de tickets
    Route::get('/admin/ticket/create', [TicketController::class, 'create'])->name('admin.ticket.create'); // Formulario crear
    Route::get('/cliente/sociedades/{id}', [TicketController::class, 'getSociedades']); // Obtener sociedades por cliente
    Route::get('/modulo/funcional/{clienteId}/{moduloId}/{tipoCosto}', [TicketController::class, 'getByFuncional']); // Obtener funcional por modulo
    Route::get('/modulo/abap/{cliente}/{tipoCosto}', [TicketController::class, 'getAbaps']);
    Route::post('/admin/ticket', [TicketController::class, 'store'])->name('admin.ticket.store'); // Guardar nuevo
    Route::get('/admin/ticket/{id}', [TicketController::class, 'show'])->name('admin.ticket.show'); // Mostrar uno

    //vista de tickets
    Route::post('/admin/costo_ticket/{id_ticket}', [HistoryTicketCostoController::class, 'store'])->name('admin.costo_ticket.store'); //agregar costo
    Route::put('/admin/abap_cambio/{id_ticket}', [HistoryTicketUserController::class, 'putAbapCambio'])->name('admin.abap_cambio.edit'); //cambiar abap
    Route::put('/admin/funcional_cambio/{id_ticket}', [HistoryTicketUserController::class, 'putFuncionalCambio'])->name('admin.funcional_cambio.edit'); //cambiar funcional
    Route::put('/admin/descrip_oc_bolsa/{id_ticket}', [TicketController::class, 'putOcBolsaCam'])->name('admin.descrip_oc_bolsa.edit');
    Route::post('/admin/cambio_estado_ticket/{id_ticket}', [EstadoFechaTicketController::class, 'storeCamEstado'])->name('admin.cam_estado.create');
    Route::post('/admin/fecha_ini_fin/{id_ticket}', [TicketController::class, 'storeFechaIniFin'])->name('admin.fecha_ini_fin.create');
    Route::post('/admin/documento_ticke/{id_ticket}', [TicketController::class, 'storeDocuTicket'])->name('admin.documento_ticket.create');
    Route::put('/admin/descrip_ticket/{id_ticket}', [TicketController::class, 'descripTicketupd'])->name('admin.descrip_ticket.update');
    Route::put('/admin/solicitante/ticket/{id_ticket}', [TicketController::class, 'solicitanteTicketupd'])->name('admin.solicitante.ticket.update');
    Route::put('/admin/costo/edit/ticket/{id_history}', [HistoryTicketCostoController::class, 'costoEditTicket'])->name('admin.costo_ticket.edit');
    Route::put('/admin/costo/delete/ticket/{id_history}', [HistoryTicketCostoController::class, 'costoDeleteTicket'])->name('admin.costo_ticket.delete');
    Route::put('/admin/documento/{id_history}', [DocumentoController::class, 'documentDeleteTicket'])->name('admin.documento.delete');

    Route::put('/admin/ticket/delete/{id_ticket}', [TicketController::class, 'deleteTicket'])->name('admin.ticket.delete'); //eliminar ticket

    Route::get('/admin/factura/ticket', [FacturaTicketController::class, 'index'])->name('admin.factura.ticket');
    Route::put('/admin/oc_bolsa_asing/ticket', [FacturaTicketController::class, 'ocBolsaAsing'])->name('admin.oc_bolsa.asing.update'); //oc bolsa
    Route::put('/admin/facturar/ticket', [FacturaTicketController::class, 'facturarTicket'])->name('admin.facturar.ticket.update'); //factura
    Route::put('/admin/num_hes/ticket/{id_ticket}', [TicketController::class, 'hesTicket'])->name('admin.num_hes.ticket.update'); //num_hes

    Route::get('/admin/factura/facturado', [FacturaTicketController::class, 'facturado'])->name('admin.ticket.facturado');
    Route::get('/admin/factura/facturado/show/{id}', [FacturaTicketController::class, 'show'])->name('admin.ticket.facturado.show');
    Route::get('/admin/cancelado/ticket', [CanceladoController::class, 'index'])->name('admin.ticket.cancelado');
    Route::put('/admin/cancelado/restaurar/{id}', [CanceladoController::class, 'restaurar'])->name('admin.restaurar.ticket');
    Route::get('/admin/cancelado/ticket/{id}', [CanceladoController::class, 'show'])->name('admin.ticket.cancelado.show');
    // dashboard
    Route::get('/dashboard/cliente/{id_cliente}', [AdminController::class, 'dashCliente']);

    //prueba de documento
    Route::post('/subir-documento', [TicketController::class, 'subir'])->name('documento.subir');
    Route::post('/ticket/upload-temp', [TicketController::class, 'uploadTemp'])->name('ticket.upload-temp');
    
    // Soporte / FAQ
    Route::get('/admin/soporte', function () { 
        return view('admin.layouts.suport'); // suport.blade.php
    })->name('admin.soporte');
});

Route::middleware(['auth', 'role:consultor'])->group(function () {
    Route::get('/consultor/dashboard', [ConsultorController::class, 'dashboard'])->name('consultor.dashboard');
    Route::get('/consultor/profile', [ConsultorProfileController::class, 'index'])->name('consultor.profile');
    Route::post('/consultor/profile/update', [ConsultorProfileController::class, 'updateProfile'])->name('consultor.profile.update');
    Route::post('/consultor/profile/update/password', [ConsultorProfileController::class, 'updatePassword'])->name('consultor.password.update');

    Route::get('/consultor/ticket/index', [TicketConsultorController::class, 'index'])->name('consultor.ticket.index');
    Route::get('/consultor/ticket/show/{id}', [TicketConsultorController::class, 'show'])->name('consultor.ticket.show');
    Route::post('/consultor/ticket/documento/store/{id}', [TicketConsultorController::class, 'storeDocuTicket'])->name('consultor.ticket.documento.store');
    Route::get('/consultor/ticket_total/index', [TicketConsultorController::class, 'allTicket'])->name('consultor.ticket.all.index');
    Route::get('/consultor/all_ticket/show/{id}', [TicketConsultorController::class, 'vistaIndividual'])->name('consultor.ticket.all.show');
    
    // Soporte / FAQ
    Route::get('/consultor/soporte', function () { 
        return view('consultor.layouts.suport'); // suport.blade.php
    })->name('consultor.soporte');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/cliente/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/cliente/profile', [ClienteProfileController::class, 'index'])->name('client.profile');
    Route::post('/cliente/profile/update', [ClienteProfileController::class, 'updateProfile'])->name('client.profile.update');
    Route::post('/cliente/profile/update/password', [ClienteProfileController::class, 'updatePassword'])->name('client.password.update');

    Route::get('/cliente/ticket/index', [TicketClientController::class, 'index'])->name('client.ticket.index');
    Route::get('/cliente/ticket/show/{id}', [TicketClientController::class, 'show'])->name('client.ticket.show');
    Route::get('/cliente/ticket_total/index', [TicketClientController::class, 'allTicket'])->name('client.ticket.all.index');
    Route::get('/cliente/all_ticket/show/{id}', [TicketClientController::class, 'vistaIndividual'])->name('client.ticket.all.show');
    Route::post('/cliente/ticket/documento/store/{id}', [TicketClientController::class, 'storeDocuTicket'])->name('client.ticket.documento.store');

    // Soporte / FAQ
    Route::get('/cliente/soporte', function () { 
        return view('client.layouts.suport'); // suport.blade.php
    })->name('cliente.soporte');

});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');


// Descargar manual de usuario
Route::get('/descargar-manualv1', function () {
    $file = public_path('uploads/RESTABLECER CONTRASEÑA.pdf');

    if (!file_exists($file)) {
        abort(404, 'El archivo no existe.');
    }

    return response()->download(
        $file,
        'Manual_Restablecer_Contraseña_v1.pdf', // Nombre visible para el usuario
        ['Content-Type' => 'application/pdf']
    );
})->name('manual.download');