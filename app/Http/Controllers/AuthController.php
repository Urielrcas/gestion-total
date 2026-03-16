<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Procesa el Registro
    public function registrar(Request $request)
    {
        // 1. Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Requiere campo password_confirmation
        ]);

        // 2. Crear el usuario en la DB
        User::create([
            'name' => $request->name,
            'store_name' => $request->store_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encripta la contraseña
            'role' => 'cliente', // Por defecto todos son clientes
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada con éxito. Inicia sesión.');
    }

    // Procesa el Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar conectar
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirigir según el rol
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('administrador');
            }
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // Cerrar Sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}