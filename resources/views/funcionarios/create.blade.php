<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h1 class="card-title text-center mb-4"><i class="bi bi-person-plus"></i> Cadastrar Funcionário</h1>
            <form method="post" action="/funcionarios">
              @csrf
              <div class="mb-3">
                <label for="nome" class="form-label">Informe o nome do funcionário:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="celular" class="form-label">Celular:</label>
                <input type="text" id="celular" name="celular" class="form-control" required maxlength="11" placeholder="99999999999">
              </div>
              <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" id="cpf" name="cpf" class="form-control" required maxlength="11" placeholder="00000000000">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="nome@email.com">
              </div>
              <div class="mb-3">
                <label for="categoria" class="form-label">Selecione a função:</label>
                <select id="categoria_id" name="categoria_id" class="form-select" required>
                  <option value="" disabled selected>Selecione...</option>
                  @foreach ($categorias as $c)
                    <option value="{{ $c->id }}">{{ $c->nome }}</option>
                  @endforeach
                </select>
              </div>
              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-check-circle"></i> Cadastrar
                </button>
                <a href="/funcionarios" class="btn btn-danger">
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