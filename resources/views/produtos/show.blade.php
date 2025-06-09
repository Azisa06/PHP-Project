<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Produto</title>
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
              <i class="bi bi-eye"></i> Consultar Produto
            </h1>
            <form method="post" action="/produtos/{{ $produto->id }}">
              @csrf
              @method('DELETE')
              
              <div class="mb-3">
                <label for="nome" class="form-label">Informe o nome:</label>
                <input type="text" id="nome" name="nome" value="{{ $produto->nome }}" class="form-control" disabled>
              </div>
              <div class="mb-3">
                <label for="descricao" class="form-label">Informe a descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" disabled>{{ $produto->descricao }}</textarea>
              </div>
              <!-- manter mas associar à função de compra
              <div class="mb-3">
                <label for="preco" class="form-label">Informe o preço:</label>
                <input type="text" id="preco" name="preco" value="{{ $produto->preco }}" class="form-control" disabled>
              </div>
              <div class="mb-3">
                <label for="estoque" class="form-label">Informe o estoque:</label>
                <input type="text" id="estoque" name="estoque" value="{{ $produto->estoque }}" class="form-control" disabled>
              </div> -->
              <div class="mb-3">
                <label for="categoria" class="form-label">Selecione a categoria:</label>
                <select id="categoria_id" name="categoria_id" class="form-select" disabled>
                  @foreach ($categorias as $c)
                    <option value="{{ $c->id }}" {{ $produto->categoria_id == $c->id ? "selected" : "" }}>
                      {{ $c->nome }}
                    </option>
                  @endforeach
                </select>
              </div>
              <p class="text-center">Deseja excluir o registro?</p>
              <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-danger me-2">
                  <i class="bi bi-check-circle"></i> Excluir
                </button>
                <a href="/produtos" class="btn btn-primary">
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