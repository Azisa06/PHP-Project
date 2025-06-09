<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h1 class="card-title text-center mb-4">
              <i class="bi bi-eye"></i> Consultar Cadastro
            </h1>
            <form method="post" action="/clientes/{{ $cliente->id }}">
              @csrf
              @method('DELETE')
              <div class="mb-3">
                  <label for="nome" class="form-label">Informe o nome:</label>
                  <input type="text" id="nome" name="nome" value="{{ $cliente->nome }}" class="form-control" disabled>
              </div>
              <div class="mb-3">
                  <label for="cpf" class="form-label">Informe o CPF:</label>
                  <input type="text" id="cpf" name="cpf" value="{{ $cliente->cpf }}" class="form-control" disabled>
              </div>
              <div class="mb-3">
                  <label for="endereco" class="form-label">Informe o endereço:</label>
                  <input type="text" id="endereco" name="endereco" value="{{ $cliente->endereco }}" class="form-control" disabled>
              </div>
              <div class="mb-3">
                  <label for="celular" class="form-label">Informe o celular:</label>
                  <input type="text" id="celular" name="celular" value="{{ $cliente->celular }}" class="form-control" disabled>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Informe o e-mail:</label>
                  <input type="email" id="email" name="email" value="{{ $cliente->email }}" class="form-control" disabled>
              </div>
              <p class="text-center">Deseja excluir o registro?</p>
              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-danger me-2">
                  <i class="bi bi-check-circle"></i> Excluir
                </button>
                <a href="/clientes" class="btn btn-primary">
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