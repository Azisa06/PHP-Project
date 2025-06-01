<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function index(){
        $produtos = Produto::select('nome', 'estoque')->get();
        return view("relatorios.index", compact('produtos'));
    }

    public function gerarRelatorioEstoque(){
        $dados = Produto::all();
        $pdf = Pdf::loadView('relatorios.relatorio-estoque', compact('dados'));
        return $pdf->download('relatorio-estoque.pdf');
    }
}
