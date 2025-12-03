<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\RegistraActividad;

class AuthController extends Controller
{
    use RegistraActividad;
    
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $credenciales = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        if (Auth::attempt($credenciales, $request->remember)) {
            $request->session()->regenerate();
            
            $usuario = Auth::user();
            
            if (!$usuario->estado) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Esta cuenta está deshabilitada.',
                ]);
            }
            
            return redirect()->intended('dashboard');
        }
        
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}