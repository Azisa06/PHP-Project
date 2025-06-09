<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Estoque;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function index(){
        $produtos = Estoque::with('produto')->select('produto_id', 'quantidade')->get();
        return view("relatorios.index", compact('produtos'));
    }

    public function gerarRelatorioEstoque(){
        $dados = Produto::with(['estoques', 'ultimoEstoque'])->get();
        $pdf = Pdf::loadView('relatorios.relatorio-estoque', compact('dados'));
        return $pdf->download('relatorio-estoque.pdf');
    }
}
