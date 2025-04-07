<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <h1>Consultar Clientes</h1>
    
    <form method="post" action="/clientes/{{ $cliente-> id }}"> <!--chave primária do produta-->
        @csrf
        @method('DELETE') <!--padrão quando é para update, fica no lugar do post-->             
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome:</label>
            <input type="text" id="nome" name="nome" value="{{ $cliente->nome }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="cpf" class="form-label">Informe o CPF:</label>
            <input type="number" id="cpf" name="cpf" value="{{ $cliente->cpf }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="endereco" class="form-label">Informe o endereço:</label>
            <input type="text" id="endereco" name="endereco" value="{{ $cliente->endereco }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="celular" class="form-label">Informe o celular:</label>
            <input type="number" id="celular" name="celular" value="{{ $cliente->celular }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="email" class="form-label">Informe o e-mail:</label>
            <input type="email" id="email" name="email" value="{{ $cliente->email }}" class="form-control" disabled>
        </div>
    <p>Deseja excluir o registro?</p>
    <button type="submit" class="btn btn-danger">Excluir</button>
    <a href="/produtos" class="btn btn-primary">Cancelar</a>
</form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>