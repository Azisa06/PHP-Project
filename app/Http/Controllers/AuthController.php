<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class AuthController extends Controller
{
    public function showFormLogin(){
        return view('login');
    }

    public function login(Request $request)
    {
        $credenciais = $request->only('email', 'password');

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === "ADM") {
                return redirect()->intended('/home-adm');
            } elseif ($user->role === "ATD") {
                return redirect()->intended('/home-atd');
            } elseif ($user->role === "TEC") {
                return redirect()->intended('/home-tec');
            } else {
                // Em caso de papel inesperado
                /*Auth::logout();
                return redirect('/login')->withErrors([
                    'acesso' => 'Perfil de usuário não autorizado!'
                ]);*/
            }
        }

        return back()->withErrors([
            'login' => 'Credenciais inválidas!'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

     public function adm()
    {
        return view('home-adm');
    }

    public function atd()
    {
        return view('home-atd');
    }

    public function tec()
    {
        return view('home-tec');
    }
}
