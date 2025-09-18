@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-pencil-square"></i> Editar Compra
        </h1>

        <form method="POST" action="/compras/{{ $compra->id }}">
          @csrf
          @method('PUT')

          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="data" class="form-label"><h5>Data da Compra</h5></label>
            </div>
            <div class="col-auto">
              <input type="date" name="data" id="data" class="form-control" value="{{ $compra->data }}" required>
            </div>
          </div>

          <h4 class="mt-4">Produtos</h4>

          @foreach ($compra->itens as $index => $item)
            @php $produto = $item->produto; @endphp
            <h6>Produto {{ $index + 1 }}</h6>
            <div class="border rounded p-3 mb-3">
              <div class="row mb-2">
                <div class="col-md-4">
                  <label for="produto_{{ $index }}" class="form-label">Nome</label>
                  <select name="produtos[{{ $index }}][produto_id]" id="produto_{{ $index }}" class="form-select" required>
                    <option value="">Selecione um produto</option>
                    @foreach($produtos as $p)
                      <option value="{{ $p->id }}" {{ $produto->id == $p->id ? 'selected' : '' }}>
                        {{ $p->nome }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="quantidade_{{ $index }}" class="form-label">Quantidade</label>
                  <input type="number" name="produtos[{{ $index }}][quantidade]" id="quantidade_{{ $index }}" value="{{ $item->quantidade }}" class="form-control quantidade" required min="1">
                </div>
                <div class="col-md-4">
                  <label for="preco_{{ $index }}" class="form-label">Preço Unitário</label>
                  <input type="text" name="produtos[{{ $index }}][preco_compra]" id="preco_{{ $index }}" value="R$ {{ number_format($item->preco_compra, 2, ',', '.') }}" class="form-control preco" required>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-4">
                  <label class="form-label">Subtotal</label>
                  <input type="text" class="form-control subtotal" value="R$ {{ number_format($item->quantidade * $item->preco_compra, 2, ',', '.') }}" readonly>
                </div>
              </div>
            </div>
          @endforeach

          <label class="form-label"><h4>Total da compra:</h4></label>
          <input type="text" id="preco_total" class="form-control" value="R$ {{ number_format($compra->preco_total, 2, ',', '.') }}" readonly>

          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-check-circle"></i> Atualizar
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
    function formatarReal(valor) {
      return 'R$ ' + valor.toFixed(2).replace('.', ',');
    }

    function atualizarTotais() {
      let total = 0;

      document.querySelectorAll('.border.rounded').forEach(container => {
        const qtdInput = container.querySelector('input[name*="[quantidade]"]');
        const precoInput = container.querySelector('input[name*="[preco_compra]"]');
        const subtotalInput = container.querySelector('input.subtotal');

        const qtd = parseInt(qtdInput?.value) || 0;
        const preco = parseFloat((precoInput?.value || '0').replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
        const subtotal = qtd * preco;

        if (subtotalInput) {
          subtotalInput.value = formatarReal(subtotal);
        }

        total += subtotal;
      });

      const totalInput = document.getElementById('preco_total');
      if (totalInput) {
        totalInput.value = formatarReal(total);
      }
    }

    atualizarTotais();

    document.querySelectorAll('input[name*="[quantidade]"], input[name*="[preco_compra]"]').forEach(input => {
      input.addEventListener('input', atualizarTotais);
    });
  });
</script>
@endsection