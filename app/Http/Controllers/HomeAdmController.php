<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Orcamento;
use App\Models\Estoque;

class HomeAdmController extends Controller
{
    public function index(){
        $estoqueMinimo = 5; // valor desejado

        //grafico de estoque
        $produtos = Estoque::with('produto')->select('produto_id', 'quantidade')->get();

        // Busca todos produtos e filtra os com estoque baixo
        $produtosEstoqueBaixo = Produto::all()->filter(function($produto) use ($estoqueMinimo) {
            return $produto->estoque_atual <= $estoqueMinimo;
        });

        $orcamentosAbertos = Orcamento::whereBetween('status_id', [1, 5])->count();
        $orcamentosFinalizados = Orcamento::where('status_id', 6)->count();

        return view('home-adm', compact('produtos', 'produtosEstoqueBaixo', 'orcamentosAbertos', 'orcamentosFinalizados'));
    }
}
