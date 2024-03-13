<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
// Route::redirect('/', '/');
Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Route::get('/login', function () {
//     return view('pages.auth.auth-login');
// });
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('users', UserController::class)->parameters([
        'users' => 'user_id',
    ])->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
    Route::resource('doctors', DoctorController::class)->parameters([
        'doctors' => 'doctor_id',
    ])->names([
        'index' => 'doctors.index',
        'create' => 'doctors.create',
        'store' => 'doctors.store',
        'show' => 'doctors.show',
        'edit' => 'doctors.edit',
        'update' => 'doctors.update',
        'destroy' => 'doctors.destroy',
        'indexPolyclinic' => 'doctors.indexPolyclinic',
    ]);
});
