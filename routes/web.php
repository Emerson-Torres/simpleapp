<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
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
Route::get('/index', function () {
    return view('welcome');
})->name('index');


// Ruta para redirigir a Google
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle']);

// Ruta de callback después de la autenticación
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// En routes/web.php
Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');




Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth', 'is_admin');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');