<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Orçamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <h1>Consultar Orçamento</h1>
    
    <form method="post" action="/orcamentos/{{ $orcamento-> id }}"> <!--chave primária do produta-->
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

        <p>Deseja excluir o registro?</p>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <a href="/orcamentos" class="btn btn-primary">Cancelar</a>
    </form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
