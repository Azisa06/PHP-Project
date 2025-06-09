<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body class="container">
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

              <div class="mb-3">
                <label for="data" class="form-label">Data da Compra</label>
                <input type="date" name="data" id="data" class="form-control" value="{{ $compra->data }}" required>
              </div>

              <h5 class="mt-4">Produtos</h5>

              @foreach ($compra->produtos as $index => $produto)
                <div class="border rounded p-3 mb-3">
                  <div class="row mb-2">
                    <div class="col-md-6">
                      <label for="produto_{{ $index }}" class="form-label">Produto</label>
                      <select name="produtos[{{ $index }}][produto_id]" id="produto_{{ $index }}" class="form-select" required>
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $p)
                          <option value="{{ $p->id }}" {{ $produto->id == $p->id ? 'selected' : '' }}>
                            {{ $p->nome }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="quantidade_{{ $index }}" class="form-label">Quantidade</label>
                      <input type="number" name="produtos[{{ $index }}][quantidade]" id="quantidade_{{ $index }}" value="{{ $produto->pivot->quantidade }}" class="form-control quantidade" required min="1">
                    </div>
                    <div class="col-md-3">
                      <label for="preco_{{ $index }}" class="form-label">Preço Unitário</label>
                      <input type="text" name="produtos[{{ $index }}][preco_compra]" id="preco_{{ $index }}" value="{{ number_format($produto->pivot->preco, 2, ',', '.') }}" class="form-control preco" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="form-label">Subtotal</label>
                      <input type="text" class="form-control" value="R$ {{ number_format($produto->pivot->quantidade * $produto->pivot->preco, 2, ',', '.') }}" readonly>
                    </div>
                  </div>
                </div>
              @endforeach

              <div class="mb-3">
                <label for="preco_total" class="form-label">Preço Total</label>
                <input type="text" id="preco_total" class="form-control" value="R$ {{ number_format($compra->preco_total, 2, ',', '.') }}" readonly>
              </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function formatarReal(valor) {
        return 'R$ ' + valor.toFixed(2).replace('.', ',');
      }

      function atualizarTotais() {
        let total = 0;

        document.querySelectorAll('.border.rounded').forEach(container => {
          const qtdInput = container.querySelector('input[name*="[quantidade]"]');
          const precoInput = container.querySelector('input[name*="[preco]"]');
          const subtotalInput = container.querySelector('input[readonly]');

          const qtd = parseInt(qtdInput.value) || 0;
          const preco = parseFloat(precoInput.value.replace(',', '.')) || 0;
          const subtotal = qtd * preco;

          subtotalInput.value = formatarReal(subtotal);
          total += subtotal;
        });

        const totalInput = document.getElementById('preco_total');
        if (totalInput) {
          totalInput.value = formatarReal(total);
        }
      }

      // Atualiza ao alterar quantidade ou preço
      document.querySelectorAll('input[name*="[quantidade]"], input[name*="[preco]"]').forEach(input => {
        input.addEventListener('input', atualizarTotais);
      });
    </script>

  </body>
</html>
