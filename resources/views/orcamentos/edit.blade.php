<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Orçamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h1 class="card-title text-center mb-4">
              <i class="bi bi-pencil-square"></i> Editar Orçamento
            </h1>
            <form method="POST" action="/orcamentos/{{ $orcamento->id }}">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" value="{{ $orcamento->nome }}" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required>{{ $orcamento->descricao }}</textarea>
              </div>

              <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="text" id="preco" name="preco" value="{{ $orcamento->preco }}" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="servico_id" class="form-label">Serviço:</label>
                <select id="servico_id" name="servico_id" class="form-select" required>
                  <option value="" disabled>Selecione...</option>
                  @foreach ($servicos as $s)
                    <option value="{{ $s->id }}" {{ $orcamento->servico_id == $s->id ? 'selected' : '' }}>
                      {{ $s->nome }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-check-circle"></i> Atualizar
                </button>
                <a href="/orcamentos" class="btn btn-danger">
                  <i class="bi bi-x-circle"></i> Cancelar
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>