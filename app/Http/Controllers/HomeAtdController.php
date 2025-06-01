<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Cliente;

class HomeAtdController extends Controller
{
    public function index(){
        $ultimosClientes = Cliente::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home-atd', compact('ultimosClientes'));
    }
}
