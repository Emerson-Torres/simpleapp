<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Verifica si el usuario es administrador
        if (str_contains($user->email, 'thecodeartisans.com') ||
            str_contains($user->name, 'QA') ||
            $user->email === 'emerson.torres0308@gmail.com') {
            return $next($request);
        }

        // Si no es administrador, redirige al dashboard con un mensaje de error
        return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta página.');

    }
}
