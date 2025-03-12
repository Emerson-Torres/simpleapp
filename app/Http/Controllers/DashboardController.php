<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Pasa los datos del usuario a la vista
        return view('dashboard', compact('user'));
    }
}
