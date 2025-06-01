<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Orçamento</title>
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
              <i class="bi bi-eye"></i> Consultar Orçamento
            </h1>
            <form method="post" action="/orcamentos/{{ $orcamento->id }}">
              @csrf
              @method('DELETE')

              <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control" value="{{ $orcamento->nome }}" disabled>
              </div>

              <div class="mb-3">
                <label class="form-label">Descrição:</label>
                <textarea class="form-control" rows="4" disabled>{{ $orcamento->descricao }}</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Preço:</label>
                <input type="text" class="form-control" value="R$ {{ number_format($orcamento->preco, 2, ',', '.') }}" disabled>
              </div>

              <div class="mb-3">
                <label class="form-label">Serviço:</label>
                <input type="text" class="form-control" value="{{ $orcamento->servico->nome ?? 'N/A' }}" disabled>
              </div>

              <p class="text-center">Deseja excluir o registro?</p>
              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-danger me-2">
                  <i class="bi bi-check-circle"></i> Excluir
                </button>
                <a href="/orcamentos" class="btn btn-primary">
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