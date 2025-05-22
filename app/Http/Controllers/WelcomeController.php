<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class WelcomeController extends Controller
{
    public function index(){
        $produtos = Produto::all();
        return view('welcome', compact('produtos'));
    }
}
