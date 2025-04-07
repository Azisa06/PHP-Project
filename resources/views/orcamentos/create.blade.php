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
    <h1>Novo Orçamento</h1>
    
    <form method="post" action="/orcamentos">
        @csrf
                        
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="descricao" class="form-label">Informe e descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""></textarea>
        </div>
    
        <div class="mb-3">
            <label for="preco" class="form-label">Informe o preço:</label>
            <input type="text" id="preco" name="preco" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="categoria" class="form-label">Selecione a categoria:</label>
            <select id="categoria_id" name="categoria_id" class="form-select" required="">
                @foreach ($categorias as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->nome }}
                    </option>
                @endforeach
            </select>
        </div>
    
    <button type="submit" class="btn btn-primary">Cadastrar</button>
    @if (session('sucesso'))
        <div class="alert alert-success fs-5">
            <p class="mensagem-sucesso">{{ session('sucesso') }} Orçamento cadastrado com sucesso!</p>
        </div>
    @endif
</form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>