<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\ConsultorController;
use App\Http\Controllers\ConsultorProfileController;

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
});

Route::middleware(['auth', 'role:consultor'])->group(function () {
    Route::get('/consultor/dashboard', [ConsultorController::class, 'dashboard'])->name('consultor.dashboard');
    Route::get('/consultor/profile', [ConsultorProfileController::class, 'index'])->name('consultor.profile');
    Route::post('/consultor/profile/update', [ConsultorProfileController::class, 'updateProfile'])->name('consultor.profile.update');
    Route::post('/consultor/profile/update/password', [ConsultorProfileController::class, 'updatePassword'])->name('consultor.password.update');
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
