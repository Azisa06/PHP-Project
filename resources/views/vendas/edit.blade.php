@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-pencil-square"></i> Editar Venda
        </h1>

        <form method="POST" action="/vendas/{{ $venda->id }}">
          @csrf
          @method('PUT')

          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="data" class="form-label"><h5>Data da Venda</h5></label>
            </div>
            <div class="col-auto">
              <input type="date" name="data" id="data" class="form-control" value="{{ old('data', $venda->data) }}" required>
            </div>
          </div>

          <h4 class="mt-4">Produtos Vendidos</h4>

          @foreach ($venda->itens as $index => $item)
            @php 
              // Pega as informações de estoque do produto a partir da coleção passada pelo Controller
              $produtoEstoque = $produtos->firstWhere('id', $item->produto_id);
              // Estoque que o produto terá *após* a reversão da quantidade vendida originalmente
              $estoqueAposReversao = ($produtoEstoque->quantidade_estoque ?? 0) + $item->quantidade; 
            @endphp
            <h6>Produto {{ $index + 1 }}</h6>
            <div class="border rounded p-3 mb-3">
              <div class="row mb-2">
                <div class="col-md-4">
                  <label for="produto_{{ $index }}" class="form-label">Nome</label>
                  <select name="produtos[{{ $index }}][produto_id]" id="produto_{{ $index }}" class="form-select" required>
                    <option value="">Selecione um produto</option>
                    @foreach($produtos as $p)
                      <option value="{{ $p->id }}" {{ $item->produto_id == $p->id ? 'selected' : '' }}data-estoque="{{ $p->quantidade_estoque }}"data-preco-venda="{{ number_format($p->preco_venda, 2, ',', '.') }}">
                        {{ $p->nome }} (Estoque: {{ $p->quantidade_estoque }})
                      </option>
                    @endforeach
                  </select>
                  <small class="text-info estoque-info">Estoque disponível: {{ $estoqueAposReversao }}</small>
                </div>
                <div class="col-md-4">
                  <label for="quantidade_{{ $index }}" class="form-label">Quantidade</label>
                  <input type="number" name="produtos[{{ $index }}][quantidade]" id="quantidade_{{ $index }}" value="{{ $item->quantidade }}" class="form-control quantidade" required min="1">
                </div>
                <div class="col-md-4">
                  <label for="preco_{{ $index }}" class="form-label">Preço Unitário</label>
                  <input type="text" name="produtos[{{ $index }}][preco_venda]" id="preco_{{ $index }}" value="R$ {{ number_format($item->preco_venda, 2, ',', '.') }}" class="form-control preco" required>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-4">
                  <label class="form-label">Subtotal</label>
                  <input type="text" class="form-control subtotal" value="R$ {{ number_format($item->quantidade * $item->preco_venda, 2, ',', '.') }}" readonly>
                </div>
              </div>
            </div>
          @endforeach

          <label class="form-label"><h4>Total da venda:</h4></label>
          <input type="text" id="preco_total" class="form-control" value="R$ {{ number_format($venda->preco_total, 2, ',', '.') }}" readonly>

          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-check-circle"></i> Atualizar Venda
            </button>
            <a href="/compras" class="btn btn-danger">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
// Mapeia o estoque atual de todos os produtos (retorno do Controller)
  const produtosEstoque = <?php echo json_encode($produtos); ?>;

  function formatarReal(valor) {
    return 'R$ ' + valor.toFixed(2).replace('.', ',');
  }

  function atualizarTotais(container) {
    const select = container.querySelector('.produto-select');
    const produtoId = select.value;
    const qtdInput = container.querySelector('input[name*="[quantidade]"]');
    const precoInput = container.querySelector('input[name*="[preco_venda]"]');
    const subtotalInput = container.querySelector('input.subtotal');
    const estoqueInfo = container.querySelector('.estoque-info');
    const originalQtd = parseInt(qtdInput?.getAttribute('data-original-qtd')) || 0;

    const qtd = parseInt(qtdInput?.value) || 0;
    const preco = parseFloat((precoInput?.value || '0').replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
    const subtotal = qtd * preco;
    
    const produtoEmEstoque = produtosEstoque.find(p => p.id == produtoId);
    const estoqueAtual = produtoEmEstoque ? produtoEmEstoque.quantidade_estoque : 0;

// Estoque que estará disponível após o rollback da venda anterior + o estoque atual do BD
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
      
// Calcula o total geral de todos os itens
      let totalGeral = 0;
      document.querySelectorAll('.produto-item').forEach(i => {
        const itemQtd = parseInt(i.querySelector('input[name*="[quantidade]"]')?.value) || 0;
        const itemPreco = parseFloat((i.querySelector('input[name*="[preco_venda]"]')?.value || '0').replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
        totalGeral += itemQtd * itemPreco;
      });


      const totalInput = document.getElementById('preco_total');
      if (totalInput) {
        totalInput.value = formatarReal(totalGeral);
      }
    }

    // Inicializa listeners para todos os itens
    document.querySelectorAll('.produto-item').forEach(container => {
      const qtdInput = container.querySelector('input[name*="[quantidade]"]');
      const precoInput = container.querySelector('input[name*="[preco_venda]"]');
      const select = container.querySelector('.produto-select');
        
        // Atualiza estoque info quando o produto muda
        select.addEventListener('change', function() {
            // Atualiza o atributo data-original-estoque para o valor atual do BD + a quantidade vendida
            const itemOriginal = <?php echo json_encode($venda->itens); ?>;
            const itemAtual = itemOriginal.find(i => i.produto_id == this.value);
            const originalQtd = itemAtual ? itemAtual.quantidade : 0;
            qtdInput.setAttribute('data-original-qtd', originalQtd);

            const produtoEmEstoque = produtosEstoque.find(p => p.id == this.value);
            const estoqueAtual = produtoEmEstoque ? produtoEmEstoque.quantidade_estoque : 0;

            container.querySelector('.estoque-info').setAttribute('data-original-estoque', estoqueAtual + originalQtd);
            container.querySelector('input[name*="[preco_venda]"]').value = produtoEmEstoque ? formatarReal(produtoEmEstoque.preco_venda).replace('R$ ', '') : '';
            
            atualizarTotais(container);
        });

        qtdInput.addEventListener('input', () => atualizarTotais(container));
        precoInput.addEventListener('input', () => atualizarTotais(container));

        // Inicia o cálculo do total para o item atual
        atualizarTotais(container);
    });
  });
</script>
@endsection