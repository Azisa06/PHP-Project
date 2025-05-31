<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo Orçamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body class="container">
    <h1>Criar Orçamento</h1>

    <form method="POST" action="/orcamentos">
        @csrf

        <div class="mb-3">
            <label for="servico_id" class="form-label">Serviço</label>
            <select name="servico_id" id="servico_id" class="form-control" required>
                <option value="">Selecione um serviço</option>
                @foreach($servicos as $servico)
                    <option value="{{ $servico->id }}">{{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}</option>
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

    <button type="submit" class="btn btn-primary">Cadastrar</button>
    @if (session('sucesso'))
        <div class="alert alert-success">
            <p class="mensagem-sucesso">{{ session('sucesso') }}</p>
        </div>
    @endif
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
