<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body class="container">
    <h1>Novo Funcionário</h1>
    
    <form method="post" action="/funcionarios">
        @csrf
                        
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome do funcionário:</label>
            <input type="text" id="nome" name="nome" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="celular" class="form-label">Celular:</label>
            <input type="text" id="celular" name="celular" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF:</label>
            <input type="text" id="cpf" name="cpf" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="categoria" class="form-label">Selecione a função:</label>
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
        <div class="alert alert-success">
            <p class="mensagem-sucesso">{{ session('sucesso') }}</p>
        </div>
    @endif
</form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>