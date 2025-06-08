<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="mb-0">Compras</h1>
      <a class="btn btn-primary" href="{{ route('compras.create') }}">
        <i class="bi bi-file-earmark-plus"></i> Nova Compra
      </a>
    </div>

    @if (session('erro'))
      <div class="alert alert-danger fs-5">
        {{ session('erro') }}
      </div>
    @endif

    @if (session('sucesso'))
      <div class="alert alert-success fs-5">
        {{ session('sucesso') }}
      </div>
    @endif

    <h2 class="h4 mb-3">Registro de Compras</h2>
    <table class="table table-hover table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Data</th>
          <th>Produtos</th>
          <th>Preço Total</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($compras as $compra)
          <tr>
            <td>{{ $compra->id }}</td>
            <td>{{ \Carbon\Carbon::parse($compra->data)->format('d/m/Y') }}</td>
            <td>
              <ul class="mb-0">
                @foreach ($compra->itens as $item)
                  <li>
                    {{ $item->produto->nome ?? 'Produto não encontrado' }}
                    (Qtd: {{ $item->quantidade }},
                    R$ {{ number_format($item->preco_unitario, 2, ',', '.') }})
                  </li>
                @endforeach
              </ul>
            </td>
            <td>
              R$ {{ number_format($compra->total, 2, ',', '.') }}
            </td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning btn-sm px-3">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-info btn-sm px-3 text-white">
                  <i class="bi bi-eye"></i> Consultar
                </a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
      <a href="/produtos" class="btn btn-success">
        <i class="bi bi-arrow-left-circle"></i> Voltar
      </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
