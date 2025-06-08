<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Orcamento;

class HomeAdmController extends Controller
{
    public function index(){
        $estoqueMinimo = 5; // ou qualquer valor desejado

        // Busca todos produtos e filtra os com estoque baixo
        $produtosEstoqueBaixo = Produto::all()->filter(function($produto) use ($estoqueMinimo) {
            return $produto->estoque_atual <= $estoqueMinimo;
        });

        $orcamentosAbertos = Orcamento::where('status_id', 1)->count();
        $orcamentosFinalizados = Orcamento::where('status_id', 6)->count();

        return view('home-adm', compact('produtosEstoqueBaixo', 'orcamentosAbertos', 'orcamentosFinalizados'));
    }
}
