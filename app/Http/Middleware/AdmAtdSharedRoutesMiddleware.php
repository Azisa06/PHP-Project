<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Se estiver usando o Auth do Laravel

class AdmAtdSharedRoutesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Supondo que você tenha um método no seu modelo User ou em um helper
        // para verificar as roles. Ex: Auth::user()->isAdm() ou Auth::user()->isAtd()
        if (Auth::check() && (Auth::user()->role =="ADM" || Auth::user()->role == "ATD")) {
            return $next($request);
        }

        // Se o usuário não tiver nenhuma das roles necessárias
        abort(403, 'Acesso não autorizado para esta seção.'); // Ou redirecione para uma página de erro/login
    }
}