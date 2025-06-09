<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-10">
        <div class="card shadow">
          <div class="card-body">
            <h1 class="card-title text-center mb-4">
              <i class="bi bi-cart-plus"></i> Criar Compra
            </h1>

            <form method="POST" action="/compras">
              @csrf

              <div class="mb-3">
                <label for="data" class="form-label">Data da Compra</label>
                <input type="date" name="data" class="form-control" required>
              </div>

              <h5 class="mt-4">Produtos</h5>
              <div id="produtos-lista">
                <div class="produto-item row g-2 mb-2">
                  <div class="col-md-4">
                    <select name="produtos[0][produto_id]" class="form-select produto-select" required>
                      <option value="">Selecione um produto</option>
                      @foreach($produtos as $p)
                        <option value="{{ $p->id }}">{{ $p->nome }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <input type="number" name="produtos[0][quantidade]" class="form-control quantidade" min="1" placeholder="Qtd" required>
                  </div>
                  <div class="col-md-2">
                    <input type="text" name="produtos[0][preco_compra]" class="form-control preco" placeholder="Preço de Compra" required>
                  </div>
                  <div class="col-md-2">
                    <input type="text" class="form-control subtotal" placeholder="Subtotal" readonly>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remover">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>
              </div>

              <button type="button" id="adicionar-produto" class="btn btn-secondary mt-2">
                <i class="bi bi-plus-circle"></i> Adicionar Produto
              </button>

              <div class="mt-4 text-end">
                <h5>Total: R$ <span id="total">0,00</span></h5>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-check-circle"></i> Cadastrar
                </button>
                <a href="{{ route('compras.index') }}" class="btn btn-danger">
                  <i class="bi bi-x-circle"></i> Cancelar
                </a>
              </div>

              @if (session('sucesso'))
                <div class="alert alert-success mt-3">
                  {{ session('sucesso') }}
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
      let contador = 1;

      function atualizarTotais() {
        let total = 0;

        document.querySelectorAll('.produto-item').forEach(item => {
          const precoInput = item.querySelector('.preco');
          const qtdInput = item.querySelector('.quantidade');
          const subtotalInput = item.querySelector('.subtotal');

          const preco = parseFloat(precoInput.value.replace(',', '.')) || 0;
          const qtd = parseInt(qtdInput.value) || 0;
          const subtotal = preco * qtd;

          if (!isNaN(subtotal)) {
            subtotalInput.value = subtotal.toFixed(2).replace('.', ',');
            total += subtotal;
          }
        });

        document.getElementById('total').innerText = total.toFixed(2).replace('.', ',');
      }

      document.getElementById('adicionar-produto').addEventListener('click', function() {
        const modelo = document.querySelector('.produto-item');
        const novo = modelo.cloneNode(true);

        novo.querySelectorAll('input').forEach(input => input.value = '');
        novo.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

        novo.querySelectorAll('select, input').forEach(el => {
          const name = el.getAttribute('name');
          if (name) {
            el.setAttribute('name', name.replace(/\[\d+\]/, `[${contador}]`));
          }
        });

        document.getElementById('produtos-lista').appendChild(novo);
        contador++;
      });

      document.addEventListener('input', function(e) {
        if (
          e.target.classList.contains('quantidade') ||
          e.target.classList.contains('preco')
        ) {
          atualizarTotais();
        }
      });

      document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remover')) {
          const item = e.target.closest('.produto-item');
          if (document.querySelectorAll('.produto-item').length > 1) {
            item.remove();
            atualizarTotais();
          }
        }
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
