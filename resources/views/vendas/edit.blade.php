@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-pencil-square"></i> Editar Venda
        </h1>

        <form method="POST" action="/vendas/{{ $venda->id }}">
          @csrf
          @method('PUT')

          <div class="row g-3 align-items-center mb-3">
            <div class="col-auto">
              <label for="data" class="form-label"><h5>Data da Venda</h5></label>
            </div>
            <div class="col-auto">
              <input type="date" name="data" id="data" class="form-control" value="{{ old('data', $venda->data) }}" required>
            </div>
          </div>

          <h4 class="mt-3">Produtos Vendidos</h4>

          @foreach ($venda->itens as $index => $item)
            @php 
              $produtoEstoque = $produtos->firstWhere('id', $item->produto_id);
              $nomeProduto = $produtoEstoque->nome ?? 'Produto não encontrado';
              $estoqueAposReversao = ($produtoEstoque->quantidade_estoque ?? 0) + $item->quantidade; 
            @endphp

            <h6 class="mt-2">Produto {{ $index + 1 }}</h6>
            <div class="produto-item border rounded p-3 mb-3">
              <div class="row mb-2">
                <div class="col-12 col-md-6">
                  <label for="produto_{{ $index }}" class="form-label">Nome</label>
                  <input type="text" class="form-control" value="{{ $nomeProduto }}" disabled>
                  <input type="hidden" name="produtos[{{ $index }}][produto_id]" value="{{ $item->produto_id }}">
                  <small class="text-info estoque-info">Estoque disponível: {{ $estoqueAposReversao }}</small>
                </div>

                <div class="col-6 col-md-3">
                  <label for="quantidade_{{ $index }}" class="form-label">Quantidade</label>
                  <input 
                    type="number" 
                    name="produtos[{{ $index }}][quantidade]" 
                    id="quantidade_{{ $index }}" 
                    value="{{ old("produtos.$index.quantidade", $item->quantidade) }}" 
                    class="form-control quantidade" 
                    required min="1"
                    data-original-qtd="{{ $item->quantidade }}"
                  >
                </div>

                <div class="col-6 col-md-3">
                  <label for="preco_{{ $index }}" class="form-label">Preço Unitário</label>
                  <input type="text" name="produtos[{{ $index }}][preco_venda]" id="preco_{{ $index }}" value="{{ old("produtos.$index.preco_venda", number_format($item->preco_venda, 2, ',', '.')) }}" class="form-control preco" required>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-md-6">
                  <label class="form-label">Subtotal</label>
                  <input type="text" class="form-control subtotal" value="{{ 'R$ ' . number_format($item->quantidade * $item->preco_venda, 2, ',', '.') }}" readonly>
                </div>
              </div>
            </div>
          @endforeach

          <label class="form-label"><h4>Total da venda:</h4></label>
          <input type="text" id="preco_total" class="form-control mb-3" value="{{ 'R$ ' . number_format($venda->preco_total, 2, ',', '.') }}" readonly>

          <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-check-circle"></i> Atualizar Venda
            </button>
            <a href="{{ route('vendas.index') }}" class="btn btn-danger">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>

          @if (session('sucesso'))
            <div class="alert alert-success mt-3">
              <p class="mensagem-sucesso mb-0">{{ session('sucesso') }}</p>
            </div>
          @endif

          @if (session('erro'))
            <div class="alert alert-danger mt-3">
              {{ session('erro') }}
            </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Estoque e produtos vindos do Controller
  const produtosEstoque = <?php echo json_encode($produtos); ?>;
  const itensOriginais = <?php echo json_encode($venda->itens); ?>;

  function formatarReal(valor) {
    return 'R$ ' + valor.toFixed(2).replace('.', ',');
  }

  function parseNumberBr(text) {
    // Recebe "1.234,56" ou "1234,56" ou "R$ 1.234,56" e retorna Number
    if (!text) return 0;
    const cleaned = text.toString().replace(/[^\d,-]/g, '').replace(/\./g, '').replace(',', '.');
    return parseFloat(cleaned) || 0;
  }

  function atualizarTotais(container) {
    const select = container.querySelector('.produto-select');
    const produtoId = select ? select.value : null;
    const qtdInput = container.querySelector('input[name*="[quantidade]"]');
    const precoInput = container.querySelector('input[name*="[preco_venda]"]');
    const subtotalInput = container.querySelector('input.subtotal');
    const estoqueInfo = container.querySelector('.estoque-info');
    const originalQtd = parseInt(qtdInput?.getAttribute('data-original-qtd')) || 0;

    const qtd = parseInt(qtdInput?.value) || 0;
    const preco = parseNumberBr(precoInput?.value || '0');
    const subtotal = qtd * preco;

    const produtoEmEstoque = produtosEstoque.find(p => p.id == produtoId);
    const estoqueAtual = produtoEmEstoque ? produtoEmEstoque.quantidade_estoque : 0;

    // Estoque disponível considerando o rollback da venda original para este item
    const estoqueDisponivelParaNovaVenda = estoqueAtual + originalQtd;

    if (produtoId && qtd > estoqueDisponivelParaNovaVenda) {
      qtdInput.classList.add('is-invalid');
      estoqueInfo.textContent = `Atenção: Qtd. excede o estoque disponível (${estoqueDisponivelParaNovaVenda}).`;
      estoqueInfo.classList.remove('text-info');
      estoqueInfo.classList.add('text-danger');
    } else {
      qtdInput.classList.remove('is-invalid');
      estoqueInfo.textContent = `Estoque disponível: ${estoqueDisponivelParaNovaVenda}`;
      estoqueInfo.classList.add('text-info');
      estoqueInfo.classList.remove('text-danger');
    }

    if (subtotalInput) {
      subtotalInput.value = formatarReal(subtotal);
    }

    // Recalcula total geral
    let totalGeral = 0;
        document.querySelectorAll('.produto-item').forEach(i => {
            const itemQtd = parseInt(i.querySelector('input[name*="[quantidade]"]')?.value) || 0;
            // Usa parseNumberBr para converter o preço do formato BR (vírgula)
            const itemPreco = parseNumberBr(i.querySelector('input[name*="[preco_venda]"]')?.value || '0'); 
            totalGeral += itemQtd * itemPreco;
        });

        const totalInput = document.getElementById('preco_total');
        if (totalInput) {
            totalInput.value = formatarReal(totalGeral);
        }
    }

    // Inicializa listeners em cada item
    document.querySelectorAll('.produto-item').forEach(container => {
        const qtdInput = container.querySelector('input[name*="[quantidade]"]');
        const precoInput = container.querySelector('input[name*="[preco_venda]"]');
        
        // 1. Liga o listener à entrada da QUANTIDADE
        qtdInput.addEventListener('input', () => atualizarTotais(container));
        
        // 2. LIGA O LISTENER À ENTRADA DO PREÇO (ISSO DEVE RESOLVER O PROBLEMA)
        precoInput.addEventListener('input', () => atualizarTotais(container));

        // 3. Calcula inicialmente os totais
        atualizarTotais(container);
    });
});
</script>
@endsection