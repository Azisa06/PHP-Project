<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CategoriaFuncionario;
use App\Models\MovimentacaoEstoque;
use App\Models\Compra;
use App\Models\Estoque;
use App\Models\ItemCompra;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
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

        foreach ($compras as $compra) {
            $quantidadeTotal = 0;
            $precoTotal = 0;

            foreach ($compra->itens as $item) {
                $quantidadeTotal += $item->quantidade;
                $precoTotal += $item->quantidade * $item->preco_compra ?? 0;
            }

            $compra->quantidade_total = $quantidadeTotal;
            $compra->preco_total = $precoTotal;
        }
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
                'produtos.*.preco_compra' => 'required|numeric|min:0.01',
            ]);

            DB::transaction(function () use ($request) {
                $compra = Compra::create([
                    'data' => $request->data
                ]);

                foreach ($request->produtos as $item) {
                    ItemCompra::create([
                        'compra_id' => $compra->id,
                        'produto_id' => $item['produto_id'],
                        'quantidade' => $item['quantidade'],
                        'preco_compra' => $item['preco_compra'],
                    ]);

                    $precoVenda = $item['preco_compra'] * 1.4;

                    $estoque = Estoque::where('produto_id', $item['produto_id'])->first();

                    if ($estoque) {
                        $estoque->quantidade += $item['quantidade'];
                        $estoque->preco_venda = $precoVenda;
                        $estoque->data = $request->data;
                        $estoque->save();
                    } else {
                        Estoque::create([
                            'produto_id' => $item['produto_id'],
                            'quantidade' => $item['quantidade'],
                            'tipo' => 'entrada',
                            'descricao' => 'Compra ID ' . $compra->id,
                            'preco_venda' => $precoVenda,
                            'data' => $request->data,
                        ]);
                    }
                }
            });

            return redirect()->route('compras.index')
                ->with('sucesso', 'Compra cadastrada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar compra: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return redirect()->route('compras.index')
                ->with('erro', 'Erro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $compra = Compra::with(['itens.produto'])->findOrFail($id);
        $precoTotal = 0;
        foreach ($compra->itens as $item) {
            $precoTotal += $item->quantidade * $item->preco_compra;
        }

        $compra->preco_total = $precoTotal;

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
            $produtos = $request->input('produtos', []);

            foreach ($produtos as &$produto) {
                if (isset($produto['preco_compra'])) {
                    $produto['preco_compra'] = floatval(
                        str_replace(',', '.', preg_replace('/[^\d,]/', '', $produto['preco_compra']))
                    );
                }
            }

            $request->merge(['produtos' => $produtos]);

            $request->validate([
                'data' => 'required|date',
                'produtos.*.produto_id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
                'produtos.*.preco_compra' => 'required|numeric|min:0.01',
            ]);

            DB::transaction(function () use ($request, $id) {
                $compra = Compra::with('itens')->findOrFail($id);
                $compra->update(['data' => $request->data]);

                // SUBTRAI as quantidades antigas do estoque
                foreach ($compra->itens as $itemAntigo) {
                    $estoque = Estoque::where('produto_id', $itemAntigo->produto_id)->first();
                    if ($estoque) {
                        $estoque->quantidade -= $itemAntigo->quantidade;
                        $estoque->save();
                    }
                }

                // Deleta itens antigos
                $compra->itens()->delete();

                // Adiciona os novos itens
                foreach ($request->produtos as $item) {
                    ItemCompra::create([
                        'compra_id' => $compra->id,
                        'produto_id' => $item['produto_id'],
                        'quantidade' => $item['quantidade'],
                        'preco_compra' => $item['preco_compra'],
                    ]);

                    $precoVenda = $item['preco_compra'] * 1.4;

                    $estoque = Estoque::firstOrNew(['produto_id' => $item['produto_id']]);
                    $estoque->quantidade += $item['quantidade'];
                    $estoque->preco_venda = $precoVenda;
                    $estoque->data = $request->data;
                    $estoque->tipo = 'entrada';
                    $estoque->save();
                }
            });

            return redirect()->route('compras.index')
                ->with('sucesso', 'Compra atualizada com sucesso!');
        } catch (Exception $e) {
            dd($e->getMessage());
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