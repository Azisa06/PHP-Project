<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Orcamento;

class HomeAdmController extends Controller
{
    public function index(){
        $estoqueMinimo = 6;
        $produtos = Produto::select('nome', 'estoque')->get();
        $produtosEstoqueBaixo = Produto::where('estoque', '<', $estoqueMinimo)->get();
        //$orcamentosAbertos = Orcamento::where('status', 'aberto')->count();
        //$orcamentosFinalizados = Orcamento::where('status', 'finalizado')->count();

        return view('home-adm', compact('produtos', 'produtosEstoqueBaixo', /*'orcamentosAbertos', 'orcamentosFinalizados'*/));
    }
}
