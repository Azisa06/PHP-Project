<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h1 class="card-title text-center mb-4">
              <i class="bi bi-box-seam"></i> Cadastrar Produto
            </h1>
            <form method="post" action="/produtos">
              @csrf

              <div class="mb-3">
                <label for="nome" class="form-label">Informe o nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="descricao" class="form-label">Informe a descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
              </div>

              <div class="mb-3">
                <label for="categoria_id" class="form-label">Selecione a categoria:</label>
                <select id="categoria_id" name="categoria_id" class="form-select" required>
                  <option value="" disabled selected>Selecione...</option>
                  @foreach ($categorias as $c)
                    <option value="{{ $c->id }}">
                      {{ $c->nome }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-check-circle"></i> Cadastrar
                </button>
                <a href="/produtos" class="btn btn-danger">
                  <i class="bi bi-x-circle"></i> Cancelar
                </a>
              </div>

              @if (session('sucesso'))
                <div class="alert alert-success mt-3">
                  <p class="mensagem-sucesso mb-0">{{ session('sucesso') }}</p>
                </div>
              @endif

            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>