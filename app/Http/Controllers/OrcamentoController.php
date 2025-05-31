<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Servico;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrcamentoController extends Controller
{
    public function index()
    {
        $orcamentos = Orcamento::with('servicos')->paginate(10);
        return view('orcamentos.index', compact('orcamentos'));
    }

    public function create()
    {
        $servicos = Servico::all();
        return view('orcamentos.create', compact('servicos'));
    }

    public function store(Request $request)
    {
        dd('CHEGUEI NO ORCAMENTO CONTROLLER -> STORE!', $request->all());  
        
        try {
            Orcamento::create($request->all());
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
        $orcamento = Orcamento::with('servicos')->findOrFail($id);
        return view("orcamentos.show", compact('orcamento'));
    }

    public function edit(string $id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $servicos = Servico::all();
        return view("orcamentos.edit", compact('orcamento', 'servicos'));
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
