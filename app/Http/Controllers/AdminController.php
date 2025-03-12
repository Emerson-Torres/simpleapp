<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Login;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    // Obtener usuarios únicos ordenados por último inicio de sesión
    $users = User::with('logins')
        ->orderByDesc('updated_at')
        ->paginate(10, ['*'], 'users_page'); // 'users_page' es el nombre personalizado

    // Obtener todos los inicios de sesión con detalles del usuario
    $logins = Login::with('user')
        ->orderByDesc('login_time')
        ->paginate(10, ['*'], 'logins_page'); // 'logins_page' es el nombre personalizado

    return view('admin', compact('users', 'logins'));
}
}
