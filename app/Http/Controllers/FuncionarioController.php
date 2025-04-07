<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CategoriaFuncionario;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Log;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funcionarios = Funcionario::with('categoria')->get();
        return view("funcionarios.index", compact('funcionarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = CategoriaFuncionario::all(); //metodo all() trás todas as informações sobre categoria
        return view("funcionarios.create", compact("categorias")); //esse método serve para mostrar o formulário
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Funcionario::create($request->all()); //request->all() vai fazer um vetor com todos os dados de produto
            return redirect()->route('funcionarios.index')
                ->with('sucesso', 'Funcionário cadastrado com sucesso!');


        }catch(Exception $e){
            Log::error("Erro ao cadastrar funcionário: ". $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]); 
            return redirect()->route('funcionarios.index')
                ->with('erro', 'Erro ao cadastrar o funcionário!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $funcionario = Funcionario::findOrFail($id); 
        $categorias = CategoriaFuncionario::all();
        return view ("funcionarios.show", compact('funcionario', 'categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $funcionario = Funcionario::findOrFail($id); 
        $categorias = CategoriaFuncionario::all();
        return view ("funcionarios.edit", compact('funcionario', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $funcionario = Funcionario::findOrFail($id);
            $funcionario->update($request->all());
            return redirect()->route('funcionarios.index')
                ->with('sucesso', 'Funcionário alterado com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao atualizar o funcionário: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'funcionario_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('funcionarios.index')->with('Erro ao editar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $funcionario = Funcionario::findOrFail($id);
            $funcionario->delete();
            return redirect()->route('funcionarios.index')
                ->with('sucesso', 'Funcionário excluído com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao excluir o funcionário: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'funcionario_id' => $id,
            ]);
            return redirect()->route('funcionarios.index')
                ->with('Erro ao excluir!');
        }
    }
}
