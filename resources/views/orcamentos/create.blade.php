<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Orçamento</title>
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
              <i class="bi bi-file-earmark-plus"></i> Criar Orçamento
            </h1>
            <form method="POST" action="/orcamentos">
              @csrf

              <div class="mb-3">
                <label for="servico_id" class="form-label">Serviço</label>
                <select name="servico_id" id="servico_id" class="form-select" required>
                  <option value="">Selecione um serviço</option>
                  @foreach($servicos as $servico)
                    <option value="{{ $servico->id }}">
                      {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" required></textarea>
              </div>

              <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="text" name="preco" class="form-control" required>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-check-circle"></i> Cadastrar
                </button>
                <a href="/orcamentos" class="btn btn-danger">
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