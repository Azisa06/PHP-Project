<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}"> arrumar a mensagem de sucesso depois-->
  </head>
  <body class="container">
    <h1>Novo Cliente</h1>
    
    <form method="post" action="/clientes">
        @csrf
                        
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="cpf" class="form-label">Informe o CPF:</label>
            <input type="number" id="cpf" name="cpf" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="endereco" class="form-label">Informe o endereço:</label>
            <input type="text" id="endereco" name="endereco" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="celular" class="form-label">Informe o celular:</label>
            <input type="number" id="celular" name="celular" class="form-control" required="">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Informe o e-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required="">
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