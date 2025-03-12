<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Login;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Obtiene los datos del usuario desde Google
            $googleUser = Socialite::driver('google')->user();
    
            // Busca al usuario en la base de datos o lo crea si no existe
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'profile_picture' => $googleUser->getAvatar(),
                ]
            );
    
            // Incrementa el contador de inicios de sesión
            $user->increment('login_count');
    
            // Registra el inicio de sesión en la tabla `logins`
            Login::create([
                'user_id' => $user->id,
                'login_time' => now()->timezone('UTC')->toDateTimeString(), // Formato UTC (ISO 8601 sin milisegundos)
            ]);
    
            // Autentica al usuario
            Auth::login($user);
    
            // Verifica si el usuario es administrador
            if ($this->isAdmin($user)) {
                return redirect()->route('admin'); // Redirige al panel de administración
            }
    
            // Si no es administrador, redirige al dashboard
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            // Maneja el error
            return redirect()->route('index')->with('error', 'Error al iniciar sesión con Google');
        }
    }

    /**
    * Verifica si el usuario es administrador.
    */
    private function isAdmin($user)
    {
        return str_contains($user->email, 'thecodeartisans.com') ||
        str_contains($user->name, 'QA') ||
        $user->email === 'emerson.torres0308@gmail.com';
    }

    // En GoogleAuthController
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
