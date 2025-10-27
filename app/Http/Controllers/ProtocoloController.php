<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orcamento;
use Barryvdh\DomPDF\Facade\Pdf;

class ProtocoloController extends Controller
{

    public function gerar($id)
    {
        // Busca o orçamento com os relacionamentos necessários
        $orcamento = Orcamento::with(['cliente', 'servico', 'statusOrcamento'])->findOrFail($id);

        // Gera o PDF usando a view 'protocolo-atendimento'
        $pdf = Pdf::loadView('relatorios.protocolo-atendimento', compact('orcamento'))
                  ->setPaper('a4', 'portrait');

        // Retorna o download do PDF
        return $pdf->download('protocolo_orcamento_' . ($orcamento->protocolo ?? $orcamento->id) . '.pdf');
    }
}
