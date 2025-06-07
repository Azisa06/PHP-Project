<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Orcamento;

class HomeAdmController extends Controller
{
    public function index(){
        $estoqueMinimo = 6;
        $produtos = Produto::withSum('itensCompra as estoque', 'quantidade')->get();
        $produtosEstoqueBaixo = $produtos->filter(function ($produto) use ($estoqueMinimo) {
            return $produto->estoque < $estoqueMinimo;
        });
        //$orcamentosAbertos = Orcamento::where('status', 'aberto')->count();
        //$orcamentosFinalizados = Orcamento::where('status', 'finalizado')->count();

        return view('home-adm', compact('produtos', 'produtosEstoqueBaixo', /*'orcamentosAbertos', 'orcamentosFinalizados'*/));
    }
}
