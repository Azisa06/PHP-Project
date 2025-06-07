<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes da Compra</title>
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
              <i class="bi bi-receipt"></i> Detalhes da Compra
            </h1>

            <div class="mb-3">
              <strong>Data da Compra:</strong>
              <p>{{ \Carbon\Carbon::parse($compra->data)->format('d/m/Y') }}</p>
            </div>

            <h5 class="mt-4">Produtos Comprados</h5>

            <table class="table table-bordered">
              <thead class="table-light">
                <tr>
                  <th>Produto</th>
                  <th>Quantidade</th>
                  <th>Preço Unitário</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($compra->produtos as $produto)
                  <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->pivot->quantidade }}</td>
                    <td>R$ {{ number_format($produto->pivot->preco, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($produto->pivot->preco * $produto->pivot->quantidade, 2, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr class="table-secondary">
                  <th colspan="3" class="text-end">Preço Total:</th>
                  <th>R$ {{ number_format($compra->preco_total, 2, ',', '.') }}</th>
                </tr>
              </tfoot>
            </table>

            <div class="d-flex justify-content-center mt-4">
              <a href="/compras" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Voltar
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
