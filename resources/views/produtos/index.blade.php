<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="mb-0">Produtos</h1>
      <a class="btn btn-primary" href="{{ route('produtos.create') }}">
        <i class="bi bi-box-seam"></i> Cadastrar Produto
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

    <h2 class="h4 mb-3">Registro de Produtos</h2>
    <table class="table table-hover table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nome do Produto</th>
          <th>Nome da Categoria</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($produtos as $p)
          <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->nome }}</td>
            <td>{{ $p->categoria->nome }}</td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                <a href="/produtos/{{ $p->id }}/edit" class="btn btn-warning btn-sm px-3">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a href="/produtos/{{ $p->id }}" class="btn btn-info btn-sm px-3 text-white">
                  <i class="bi bi-eye"></i> Consultar
                </a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
      <a href="@if(Auth::user()->role == 'ADM') /home-adm
                @elseif(Auth::user()->role == 'ATD') /home-atd
                @elseif(Auth::user()->role == 'TEC') /home-tec
                @else / @endif"
        class="btn btn-success">
        <i class="bi bi-arrow-left-circle"></i> Voltar
      </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>