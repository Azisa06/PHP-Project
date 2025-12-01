<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Orcamento;
use App\Models\Compra;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RelatorioFinanceiroController extends Controller
{
    public function gerarRelatorio(Request $request)
    {
        $periodo = $request->input('periodo', 'dia');
        $dataReferencia = Carbon::now('America/Sao_Paulo'); 
        $statusFinalizadoId = 6; //status "Conserto Finalizado"

        $inicioSemana = null;
        $fimSemana = null;

        $titulo = 'Relatório Financeiro';
        $nomeArquivo = 'relatorio-financeiro';

        //Queries Base
        $vendasQuery = Venda::query();
        $consertosQuery = Orcamento::where('status_id', $statusFinalizadoId);
        $comprasQuery = Compra::with('itens');

        //Filtro de Período
        if ($periodo === 'dia') {
            $vendasQuery->whereDate('data', $dataReferencia->toDateString());
            $consertosQuery->whereDate('updated_at', $dataReferencia->toDateString());
            $comprasQuery->whereDate('data', $dataReferencia->toDateString());
            
            $nomeArquivo .= '-dia-' . $dataReferencia->format('Y-m-d') . '.pdf';

        } elseif ($periodo === 'semanal') {
            $inicioSemana = $dataReferencia->clone()->startOfWeek();
            $fimSemana = $dataReferencia->clone()->endOfWeek();

            $vendasQuery->whereBetween('data', [$inicioSemana, $fimSemana]);
            $consertosQuery->whereBetween('updated_at', [$inicioSemana, $fimSemana]);
            $comprasQuery->whereBetween('data', [$inicioSemana, $fimSemana]);
            
            $nomeArquivo .= '-semanal-' . $dataReferencia->format('Y-m-d') . '.pdf';

        } elseif ($periodo === 'mes') {
            $vendasQuery->whereMonth('data', $dataReferencia->month)
                        ->whereYear('data', $dataReferencia->year);
            
            $consertosQuery->whereMonth('updated_at', $dataReferencia->month)
                           ->whereYear('updated_at', $dataReferencia->year);

            $comprasQuery->whereMonth('data', $dataReferencia->month)
                         ->whereYear('data', $dataReferencia->year);

            $nomeArquivo .= '-mes-' . $dataReferencia->format('Y-m') . '.pdf';
        }

        //listas detalhadas
        $vendas = $vendasQuery->get();
        $consertos = $consertosQuery->get();
        $compras = $comprasQuery->get();

        //Calcular Totais
        $totalReceitasVendas = $vendas->sum('preco_total');
        $totalReceitasConsertos = $consertos->sum('preco');
        $totalReceitas = $totalReceitasVendas + $totalReceitasConsertos;

        $totalDespesasCompras = $compras->sum('total');
        // para futuras despesas, adiciona-las nesse campo
        $totalDespesas = $totalDespesasCompras; 

        $balanco = $totalReceitas - $totalDespesas;

        //Gerar PDF
        $pdf = Pdf::loadView('relatorios.relatorio-financeiro', compact(
            'titulo', 'dataReferencia', 'periodo',
            'vendas', 'consertos', 'compras',
            'totalReceitasVendas', 'totalReceitasConsertos', 'totalReceitas',
            'totalDespesasCompras', 'totalDespesas',
            'balanco', 'inicioSemana', 'fimSemana'
        ));
        
        return $pdf->download($nomeArquivo);
    }
}