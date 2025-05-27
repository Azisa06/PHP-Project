<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Servico;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orcamentos = Orcamento::all();
        return view("clientes.index", compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicos = Servico::all();
        return view('orcamentos.create', compact('servicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Orcamento::create($request->all()); //request->all() vai fazer um vetor com todos os dados de produto
            return redirect()->route('orcamentos.index')
                ->with('sucesso', 'Orçamento criado com sucesso!');


        }catch(Exception $e){
            Log::error("Erro ao criar o orçamento: ". $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]); 
            return redirect()->route('orcamentos.index')
                ->with('erro', 'Erro ao criar o orçamento!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orcamento = Orcamento::findOrFail($id); 
        return view ("orcamentos.show", compact('orcamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orcamento = Orcamento::findOrFail($id); 
        return view ("orcamentos.edit", compact('orcamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $orcamento = Orcamento::findOrFail($id);
            $orcamento->update($request->all());
            return redirect()->route('orcamentos.index')
                ->with('sucesso', 'Orçamento alterado com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao atualizar o orçamento: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'orcamento_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('orcamentos.index')->with('Erro ao editar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $orcamento = Orcamento::findOrFail($id);
            $orcamento->delete();
            return redirect()->route('orcamentos.index')
                ->with('sucesso', 'Orçamento excluído com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao excluir o orçamento: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'orcamento_id' => $id,
            ]);
            return redirect()->route('orcamentos.index')
                ->with('Erro ao excluir!');
        }
    }
}
