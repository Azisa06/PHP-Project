<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CategoriaFuncionario;
use App\Models\MovimentacaoEstoque;
use App\Models\Compra;
use App\Models\ItemCompra;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with(['itens.produto'])->get();
        return view("compras.index", compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::all();
        return view("compras.create", compact("produtos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'data' => 'required|date',
                'produtos.*.produto_id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
            ]);

            $compra = Compra::create([
                'data' => $request->data
            ]);

            foreach ($request->produtos as $item) {
                $produto = Produto::find($item['produto_id']);
                ItemCompra::create([
                    'compra_id' => $compra->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $produto->preco, // Puxa o preço atual do produto
                ]);

                // Atualiza o estoque do produto
                MovimentacaoEstoque::create([
                    'produto_id' => $produto->id,
                    'quantidade' => $item['quantidade'], // positivo = entrada
                    'tipo' => 'entrada',
                    'descricao' => 'Compra ID ' . $compra->id,
                ]);
            }

            return redirect()->route('compras.index')
                ->with('sucesso', 'Compra cadastrada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar compra: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return redirect()->route('compras.index')
                ->with('erro', 'Erro ao cadastrar a compra!');
        }
    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
    {
        $compra = Compra::with(['itens.produto'])->findOrFail($id);
        return view("compras.show", compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $compra = Compra::with('itens')->findOrFail($id);
        $produtos = Produto::all();
        return view("compras.edit", compact('compra', 'produtos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $request->validate([
            'data' => 'required|date',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        $compra = Compra::with('itens')->findOrFail($id);
        $compra->update([
            'data' => $request->data,
        ]);

        // Reverter o estoque dos produtos anteriores
        foreach ($compra->itens as $itemAntigo) {
            $produto = Produto::find($itemAntigo->produto_id);
            if ($produto) {
                $produto->estoque -= $itemAntigo->quantidade;
                $produto->save();
            }
        }

        // Apagar os itens antigos da compra
        $compra->itens()->delete();

        // Adicionar os novos itens e atualizar o estoque
        foreach ($request->produtos as $itemNovo) {
            $produto = Produto::find($itemNovo['produto_id']);
            ItemCompra::create([
                'compra_id' => $compra->id,
                'produto_id' => $itemNovo['produto_id'],
                'quantidade' => $itemNovo['quantidade'],
                'preco_unitario' => $produto->preco,
            ]);

            $produto = Produto::find($itemNovo['produto_id']);
            if ($produto) {
                $produto->estoque += $itemNovo['quantidade'];
                $produto->save();
            }
        }

        return redirect()->route('compras.index')
            ->with('sucesso', 'Compra e itens atualizados com sucesso!');
    } catch (Exception $e) {
        Log::error("Erro ao atualizar a compra: " . $e->getMessage(), [
            'stack' => $e->getTraceAsString(),
            'compra_id' => $id,
            'request' => $request->all()
        ]);
        return redirect()->route('compras.index')
            ->with('erro', 'Erro ao atualizar a compra!');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $compra = Compra::findOrFail($id);
            $compra->itens()->delete();
            $compra->delete();

            return redirect()->route('compras.index')
                ->with('sucesso', 'Compra excluída com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao excluir a compra: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'compra_id' => $id,
            ]);
            return redirect()->route('compras.index')
                ->with('erro', 'Erro ao excluir a compra!');
        }
    }
}
