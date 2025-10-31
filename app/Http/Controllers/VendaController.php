<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Estoque;
use App\Models\ItemVenda;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carrega as vendas com os itens e os produtos
        $vendas = Venda::with(['itens.produto'])->get();
        // O cálculo do total está no Model Venda (getPrecoTotalAttribute)
        return view("vendas.index", compact('vendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Busca os produtos que têm estoque para a venda
        $produtosEmEstoque = Estoque::where('quantidade', '>', 0)
            ->with('produto')
            ->get();
        
        // Mapeia os dados para uma coleção fácil de usar na view
        $produtos = $produtosEmEstoque->map(function ($estoque) {
            return (object) [
                'id' => $estoque->produto_id,
                'nome' => $estoque->produto->nome,
                'quantidade_estoque' => $estoque->quantidade,
                'preco_venda' => $estoque->preco_venda,
            ];
        });

        return view("vendas.create", compact("produtos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $produtos = $request->input('produtos', []);

            foreach ($produtos as &$produto) {
                if (isset($produto['preco_venda'])) {
                    // Remove R$, pontos de milhar, e substitui a vírgula (decimal) por ponto
                    $produto['preco_venda'] = floatval(
                        str_replace(',', '.', preg_replace('/[^\d,]/', '', $produto['preco_venda']))
                    );
                }
            }

            $request->merge(['produtos' => $produtos]);
            
            // Validação
            $request->validate([
                'data' => 'required|date',
                'produtos.*.produto_id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
                'produtos.*.preco_venda' => 'required|numeric|min:0.01',
            ]);

            DB::transaction(function () use ($request) {
                // 1. Cria a Venda
                $venda = Venda::create([
                    'data' => $request->data
                ]);

                // 2. Processa os itens e atualiza/verifica o estoque
                foreach ($request->produtos as $item) {
                    $produtoId = $item['produto_id'];
                    $quantidadeVendida = $item['quantidade'];
                    $precoVenda = $item['preco_venda']; 

                    $estoque = Estoque::where('produto_id', $produtoId)->first();

                    $produto = Produto::find($produtoId); // Busca o objeto Produto
                    $estoque = Estoque::where('produto_id', $produtoId)->first();

                    // Validação de Estoque Suficiente (Fundamental para Vendas)
                    if (!$estoque || $estoque->quantidade < $quantidadeVendida) {
                        $nomeProduto = $produto ? $produto->nome : 'Produto Desconhecido';
                        $disponivel = $estoque ? $estoque->quantidade : 0;
         
                        // mensagem de erro
                        throw new Exception("Não foi possível atualizar a quantidade para '{$nomeProduto}'. Estoque disponível: {$disponivel}. Você tentou vender: {$quantidadeVendida}.");
                    }

                    // Cria o ItemVenda
                    ItemVenda::create([
                        'venda_id' => $venda->id,
                        'produto_id' => $produtoId,
                        'quantidade' => $quantidadeVendida,
                        'preco_venda' => $precoVenda,
                    ]);

                    // Subtrai do Estoque (Operação Inversa à Compra)
                    $estoque->quantidade -= $quantidadeVendida;
                    // O campo 'data' no estoque será atualizado para refletir a última movimentação
                    $estoque->data = $request->data;
                    $estoque->save();
                }
            });

            return redirect()->route('vendas.index')
                ->with('sucesso', 'Venda cadastrada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar venda: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            // Redireciona de volta com o erro. O 'withInput()' é útil para manter os dados no formulário.
            return redirect()->route('vendas.create') 
                ->withInput()
                ->with('erro', 'Erro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venda = Venda::with(['itens.produto'])->findOrFail($id);
        // O total é calculado via Accessor no Model Venda, mas podemos calcular aqui se necessário.
        $venda->preco_total = $venda->preco_total; 

        return view("vendas.show", compact('venda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $venda = Venda::with('itens')->findOrFail($id);
        
        // Busca todos os produtos com o estoque atual. Isso é necessário para recalcular o estoque.
        $produtosEmEstoque = Estoque::with('produto')->get();
        
        // Mapeia para uma coleção com info do produto e estoque
        $produtos = $produtosEmEstoque->map(function ($estoque) {
            return (object) [
                'id' => $estoque->produto_id,
                'nome' => $estoque->produto->nome,
                'quantidade_estoque' => $estoque->quantidade,
                'preco_venda' => $estoque->preco_venda,
            ];
        });
        
        return view("vendas.edit", compact('venda', 'produtos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Sanitização do preço (igual ao CompraController)
            $produtos = $request->input('produtos', []);
            foreach ($produtos as &$produto) {
                if (isset($produto['preco_venda'])) {
                    $produto['preco_venda'] = floatval(
                        str_replace(',', '.', preg_replace('/[^\d,]/', '', $produto['preco_venda']))
                    );
                }
            }
            $request->merge(['produtos' => $produtos]);

            $request->validate([
                'data' => 'required|date',
                'produtos.*.produto_id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
                'produtos.*.preco_venda' => 'required|numeric|min:0.01',
            ]);

            DB::transaction(function () use ($request, $id) {
                $venda = Venda::with('itens')->findOrFail($id);
                $venda->update(['data' => $request->data]);

                // 1. RE-ADICIONA as quantidades antigas ao estoque (Desfaz a venda anterior para recalcular)
                foreach ($venda->itens as $itemAntigo) {
                    $estoque = Estoque::where('produto_id', $itemAntigo->produto_id)->first();
                    if ($estoque) {
                        $estoque->quantidade += $itemAntigo->quantidade; // Adiciona de volta
                        $estoque->save();
                    }
                }

                // Deleta itens antigos
                $venda->itens()->delete();

                // 2. Adiciona os novos itens e SUBTRAI do estoque (Nova venda)
                foreach ($request->produtos as $item) {
                    $produtoId = $item['produto_id'];
                    $quantidadeVendida = $item['quantidade'];
                    $precoVenda = $item['preco_venda'];

                    $estoque = Estoque::where('produto_id', $produtoId)->first();

                    $produto = Produto::find($produtoId); // Busca o objeto Produto
                    $estoque = Estoque::where('produto_id', $produtoId)->first();

                    // Validação de Estoque Suficiente (Fundamental para Vendas)
                    if (!$estoque || $estoque->quantidade < $quantidadeVendida) {
                        $nomeProduto = $produto ? $produto->nome : 'Produto Desconhecido';
                        $disponivel = $estoque ? $estoque->quantidade : 0;
         
                        // mensagem de erro
                        throw new Exception("Não foi possível atualizar a quantidade para '{$nomeProduto}'. Estoque disponível: {$disponivel}. Você tentou vender: {$quantidadeVendida}.");
                    }

                    // Cria o novo ItemVenda
                    ItemVenda::create([
                        'venda_id' => $venda->id,
                        'produto_id' => $produtoId,
                        'quantidade' => $quantidadeVendida,
                        'preco_venda' => $precoVenda,
                    ]);

                    // Subtrai do Estoque novamente
                    $estoque->quantidade -= $quantidadeVendida;
                    $estoque->data = $request->data;
                    $estoque->save();
                }
            });

            return redirect()->route('vendas.index')
                ->with('sucesso', 'Venda atualizada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao atualizar a venda: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'venda_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->route('vendas.edit', $id)
                ->withInput()
                ->with('erro', 'Erro ao atualizar a venda: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $venda = Venda::with('itens')->findOrFail($id);
                
                // 1. Reverte o estoque (Adiciona a quantidade de volta ao estoque)
                foreach ($venda->itens as $item) {
                    $estoque = Estoque::where('produto_id', $item->produto_id)->first();
                    if ($estoque) {
                        $estoque->quantidade += $item->quantidade; // Reverte a subtração
                        $estoque->save();
                    }
                }

                // 2. Deleta os itens e a venda
                $venda->itens()->delete();
                $venda->delete();
            });

            return redirect()->route('vendas.index')
                ->with('sucesso', 'Venda excluída com sucesso! Estoque restaurado.');
        } catch (Exception $e) {
            Log::error("Erro ao excluir a venda: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'venda_id' => $id,
            ]);
            return redirect()->route('vendas.index')
                ->with('erro', 'Erro ao excluir a venda!');
        }
    }

    /**
 * Busca produtos para o Select2/Tom Select.
 * Para Vendas, buscamos produtos que tenham estoque > 0.
 */
public function searchProdutos(Request $request)
{
    $termo = $request->get('q');
    
    $query = Produto::select('produtos.id', 'produtos.nome', 'estoques.preco_venda')
        ->join('estoques', 'produtos.id', '=', 'estoques.produto_id')
        ->where('estoques.quantidade', '>', 0)
        ->limit(10);

    // Se houver termo de busca, aplicamos o filtro pelo nome do produto
    if (!empty($termo)) {
        $query->where('produtos.nome', 'like', '%' . $termo . '%');
    }

    $produtos = $query->get();

    // Formata o resultado no formato esperado pelo Tom Select, incluindo preco_venda
    $resultados = $produtos->map(function ($produto) {
        // Formatamos o preço para o padrão brasileiro (0,00)
        $preco_venda_br = number_format($produto->preco_venda ?? 0, 2, ',', '.');
        
        return [
            'id' => $produto->id,
            // Exibimos o nome e a info de preço/estoque aqui
            'text' => $produto->nome . ' (R$ ' . $preco_venda_br . ')', 
            // O Tom Select pode armazenar dados adicionais na opção
            'preco_venda' => $preco_venda_br,
        ];
    });
    
    // Adicionamos um log para debug da API
    Log::info('Busca de Produtos Venda API', ['termo' => $termo, 'resultados_count' => $resultados->count()]);

    return response()->json(['results' => $resultados]);
}
}
