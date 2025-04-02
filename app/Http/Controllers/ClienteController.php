<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view("clientes.index", compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("clientes.create"); //esse método serve para mostrar o formulário
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Cliente::create($request->all()); //request->all() vai fazer um vetor com todos os dados de produto
            return redirect()->route('clientes.index')
                ->with('sucesso', 'Cliente cadastrado com sucesso!');


        }catch(Exception $e){
            Log::error("Erro ao cadastrar o cliente: ". $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]); 
            return redirect()->route('clientes.index')
                ->with('erro', 'Erro ao cadastrar o cliente!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::findOrFail($id); 
        return view ("clientes.show", compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::findOrFail($id); 
        return view ("clientes.edit", compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $cliente = Cliente::findOrFail($id);
            $cliente->update($request->all());
            return redirect()->route('clientes.index')
                ->with('sucesso', 'Cliente alterado com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao atualizar o cliente: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'cliente_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('clientes.index')->with('Erro ao editar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return redirect()->route('clientes.index')
                ->with('sucesso', 'Cliente excluído com sucesso!');
        }catch (Exception $e){
            Log::error("Erro ao excluir o cliente: ".$e->getMessage(),[
                'stack' => $e->getTraceAsString(),
                'cliente_id' => $id,
            ]);
            return redirect()->route('clientes.index')
                ->with('Erro ao excluir!');
        }
    }
}
