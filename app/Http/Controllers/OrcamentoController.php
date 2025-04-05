<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CategoriaOrcamento;
use App\Models\Orcamento;
use Illuminate\Support\Facades\Log;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orcamentos = Orcamento::with('categoria')->get();
        return view("orcamentos.index", compact('orcamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = CategoriaOrcamento::all(); //metodo all() trás todas as informações sobre categoria
        return view("orcamentos.create", compact("categorias")); //esse método serve para mostrar o formulário
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
        $categorias = CategoriaOrcamento::all();
        return view ("orcamentos.show", compact('orcamento', 'categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orcamento = Orcamento::findOrFail($id); 
        $categorias = CategoriaOrcamento::all();
        return view ("orcamentos.edit", compact('orcamento', 'categorias'));
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
