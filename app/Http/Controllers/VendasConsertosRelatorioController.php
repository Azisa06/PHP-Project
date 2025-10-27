<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Orcamento;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class VendasConsertosRelatorioController extends Controller
{
    public function gerarRelatorioVendas(Request $request)
    {
        $periodo = $request->input('periodo', 'dia'); // 'dia' ou 'mes'
        $dataReferencia = Carbon::now('America/Sao_Paulo');
        $titulo = 'Relatório de Vendas';
        $nomeArquivo = 'relatorio-vendas';

        $inicioSemana = null;
        $fimSemana = null;

        if ($periodo === 'dia') {
            $vendas = Venda::with(['itens.produto'])
                ->whereDate('data', $dataReferencia->toDateString())
                ->get();
            $nomeArquivo .= '-dia-' . $dataReferencia->format('Y-m-d') . '.pdf';
        } elseif ($periodo === 'mes') {
            $vendas = Venda::with(['itens.produto'])
                ->whereMonth('data', $dataReferencia->month)
                ->whereYear('data', $dataReferencia->year)
                ->get();
            $nomeArquivo .= '-mes-' . $dataReferencia->format('Y-m') . '.pdf';
        } elseif ($periodo === 'semanal') {
            $inicioSemana = $dataReferencia->clone()->startOfWeek();
            $fimSemana = $dataReferencia->clone()->endOfWeek();

            $vendas = Venda::with(['itens.produto'])
                ->whereBetween('data', [
                    $inicioSemana,
                    $fimSemana
                ])
                ->get();
            $nomeArquivo .= '-semanal-' . $dataReferencia->format('Y-m-d') . '.pdf'; 
        } else {
            // Caso padrão ou inválido, retorna relatório do dia
            $vendas = Venda::with(['itens.produto'])
                ->whereDate('data', $dataReferencia->toDateString())
                ->get();
            $titulo .= ' do Dia ' . $dataReferencia->format('d/m/Y');
            $nomeArquivo .= '-dia-' . $dataReferencia->format('Y-m-d') . '.pdf';
        }

        // Calcula totais
        $totalGeralVendas = $vendas->sum(function ($venda) {
            return $venda->preco_total;
        });

        // Passa os dados para a view Blade correspondente
        $pdf = Pdf::loadView('relatorios.relatorio-vendas', compact('vendas', 'titulo', 'totalGeralVendas', 'periodo', 'dataReferencia', 'inicioSemana', 'fimSemana'));
        return $pdf->download($nomeArquivo);
    }

    public function gerarRelatorioConsertos(Request $request)
    {
        $periodo = $request->input('periodo', 'dia'); // 'dia' ou 'mes'
        $dataReferencia = Carbon::now('America/Sao_Paulo');
        $titulo = 'Relatório de Consertos Finalizados';
        $nomeArquivo = 'relatorio-consertos';
        $statusFinalizadoId = 6; // ID do status "Conserto Finalizado"

        $inicioSemana = null;
        $fimSemana = null;

        if ($periodo === 'dia') {
            $consertos = Orcamento::with(['cliente', 'servico'])
                ->where('status_id', $statusFinalizadoId)
                ->whereDate('updated_at', $dataReferencia->toDateString())
                ->get();
            $titulo .= ' do Dia ' . $dataReferencia->format('d/m/Y');
            $nomeArquivo .= '-dia-' . $dataReferencia->format('Y-m-d') . '.pdf';
        } elseif ($periodo === 'semanal') {
            $inicioSemana = $dataReferencia->clone()->startOfWeek();
            $fimSemana = $dataReferencia->clone()->endOfWeek();

            $consertos = Orcamento::with(['cliente', 'servico'])
                ->where('status_id', $statusFinalizadoId)
                ->whereBetween('updated_at', [
                    $inicioSemana,
                    $fimSemana
                ])
                ->get();
            $nomeArquivo .= '-semanal-' . $dataReferencia->format('Y-m-d') . '.pdf';
        } elseif ($periodo === 'mes') {
            $consertos = Orcamento::with(['cliente', 'servico'])
                ->where('status_id', $statusFinalizadoId)
                ->whereMonth('updated_at', $dataReferencia->month)
                ->whereYear('updated_at', $dataReferencia->year)
                ->get();
            $nomeArquivo .= '-mes-' . $dataReferencia->format('Y-m') . '.pdf';
        } else {
            $consertos = Orcamento::with(['cliente', 'servico'])
                ->where('status_id', $statusFinalizadoId)
                ->whereDate('updated_at', $dataReferencia->toDateString())
                ->get();
            $titulo .= ' do Dia ' . $dataReferencia->format('d/m/Y');
            $nomeArquivo .= '-dia-' . $dataReferencia->format('Y-m-d') . '.pdf';
        }

        // Calcula total
        $totalGeralConsertos = $consertos->sum('preco');

        // Passa os dados para a view Blade correspondente
        $pdf = Pdf::loadView('relatorios.relatorio-consertos', compact('consertos', 'titulo', 'totalGeralConsertos', 'periodo', 'dataReferencia', 'inicioSemana', 'fimSemana'));
        return $pdf->download($nomeArquivo);
    }
}