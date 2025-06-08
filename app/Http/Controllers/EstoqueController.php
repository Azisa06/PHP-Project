<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        // Pega todas as movimentações de estoque com os dados do produto
        $estoques = Estoque::with('produto')->orderByDesc('created_at')->get();

        return view('estoques.index', compact('estoques'));
    }
}
