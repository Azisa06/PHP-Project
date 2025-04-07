<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::with('categoria')->get();
        return view("produtos.index", compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = CategoriaProduto::all(); //metodo all() trás todas as informações sobre categoria
        return view("produtos.create", compact("categorias")); //esse método serve para mostrar o formulário
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Produto::create($request->all()); //request->all() vai fazer um vetor com todos os dados de produto
            return redirect()->route('produtos.index')
                ->with('sucesso', 'Produto inserido com sucesso!');


        }catch(Exception $e){
            Log::error("Erro ao criar o produto: ". $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]); 
            return redirect()->route('produtos.index')
                ->with('erro', 'Erro ao criar o produto!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Produto::findOrFail($id); 
        $categorias = CategoriaProduto::all();
        return view ("produtos.show", compact('produto', 'categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Produto::findOrFail($id); 
        $categorias = CategoriaProduto::all();
        return view ("produtos.edit", compact('produto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $produto = Produto::findOrFail($id);
            $produto->update($request->all());
            return redirect()->route('produtos.index')
                ->with('sucesso', 'Produto alterado com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao atualizar o produto: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'produto_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('produtos.index')->with('Erro ao editar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $produto = Produto::findOrFail($id);
            $produto->delete();
            return redirect()->route('produtos.index')
                ->with('sucesso', 'Produto excluído com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao excluir o produto: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'produto_id' => $id,
            ]);
            return redirect()->route('produtos.index')
                ->with('Erro ao excluir!');
        }
    }
}
