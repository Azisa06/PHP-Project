<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\Servico;
use App\Models\StatusOrcamento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrcamentoController extends Controller
{
    public function index()
    {
        $orcamentos = Orcamento::with('servico', 'cliente', 'statusOrcamento')->paginate(10);
        return view('orcamentos.index', compact('orcamentos'));
    }

    public function create()
    {
        $servicos = Servico::all();
        $clientes = Cliente::all();
        $status = StatusOrcamento::all();
        return view('orcamentos.create', compact('servicos', 'clientes', 'status'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $status = StatusOrcamento::where('nome', 'Aguardando Análise')->first();
            $data['status_id'] = $status->id ?? 1;

            Orcamento::create($data);

            return redirect()->route('orcamentos.index')
                ->with('sucesso', 'Orçamento criado com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao criar o orçamento: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return redirect()->route('orcamentos.index')
                ->with('erro', 'Erro ao criar o orçamento!');
        }
    }

    public function show(string $id)
    {
        $orcamento = Orcamento::with('servico', 'cliente', 'statusOrcamento')->findOrFail($id);
        return view("orcamentos.show", compact('orcamento'));
    }

    public function edit(string $id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $servicos = Servico::all();
        $clientes = Cliente::all();
        $status = StatusOrcamento::all();
        return view("orcamentos.edit", compact('orcamento', 'servicos', 'clientes', 'status'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $orcamento = Orcamento::findOrFail($id);
            $orcamento->update($request->all());
            return redirect()->route('orcamentos.index')
                ->with('sucesso', 'Orçamento alterado com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao atualizar o orçamento: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'orcamento_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('orcamentos.index')
                ->with('erro', 'Erro ao editar!');
        }
    }

    public function destroy(string $id)
    {
        try {
            $orcamento = Orcamento::findOrFail($id);
            $orcamento->delete();
            return redirect()->route('orcamentos.index')
                ->with('sucesso', 'Orçamento excluído com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao excluir o orçamento: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'orcamento_id' => $id,
            ]);
            return redirect()->route('orcamentos.index')
                ->with('erro', 'Erro ao excluir!');
        }
    }
}
