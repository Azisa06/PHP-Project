<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CategoriaServico;
use App\Models\Servico;
use Illuminate\Support\Facades\Log;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicos = Servico::with('categoria')->get();
        return view("servicos.index", compact('servicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = CategoriaServico::all(); //metodo all() trás todas as informações sobre categoria
        return view("servicos.create", compact("categorias")); //esse método serve para mostrar o formulário
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Servico::create($request->all()); //request->all() vai fazer um vetor com todos os dados de produto
            return redirect()->route('servicos.index')
                ->with('sucesso', 'Serviço criado com sucesso!');


        }catch(Exception $e){
            Log::error("Erro ao criar o serviço: ". $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]); 
            return redirect()->route('servicos.index')
                ->with('erro', 'Erro ao criar o serviço!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servico = Servico::findOrFail($id); 
        $categorias = CategoriaServico::all();
        return view ("servicos.show", compact('servico', 'categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servico = Servico::findOrFail($id); 
        $categorias = CategoriaServico::all();
        return view ("servicos.edit", compact('servico', 'categorias'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $servico = Servico::findOrFail($id);
            $servico->update($request->all());
            return redirect()->route('servicos.index')
                ->with('sucesso', 'Serviço alterado com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao atualizar o serviço: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'servico_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('servicos.index')->with('Erro ao editar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $servico = Servico::findOrFail($id);
            $servico->delete();
            return redirect()->route('servicos.index')
                ->with('sucesso', 'Serviço excluído com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao excluir o serviço: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'servico_id' => $id,
            ]);
            return redirect()->route('servicos.index')
                ->with('Erro ao excluir!');
        }
    }
}