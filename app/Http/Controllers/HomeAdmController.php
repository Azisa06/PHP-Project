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

        $produtos = Produto::with('estoques')->get();

         // Busca todos os produtos e filtra os com estoque baixo
        $produtosEstoqueBaixo = $produtos->filter(function ($produto) use ($estoqueMinimo) {
            return $produto->estoque_atual <= $estoqueMinimo;
        });

        //grafico de estoque
        $produtos = Estoque::with('produto')->select('produto_id', 'quantidade')->get();

        //grafico orçamento
        $orcamentosAbertos = Orcamento::whereBetween('status_id', [1, 5])->count();
        $orcamentosFinalizados = Orcamento::where('status_id', 6)->count();

        return view('home-adm', compact('produtos', 'produtosEstoqueBaixo', 'orcamentosAbertos', 'orcamentosFinalizados'));
    }
}
