<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}"> arrumar a mensagem de sucesso depois-->
  </head>
  <body class="container">
    <h1>Novo Serviço</h1>
    
    <form method="post" action="/produtos">
        @csrf
                        
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome do serviço:</label>
            <input type="text" id="nome" name="nome" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="descricao" class="form-label">Informe a descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""></textarea>
        </div>
    
        <div class="mb-3">
            <label for="preco" class="form-label">Informe o preço:</label>
            <input type="text" id="preco" name="preco" class="form-control" required="">
        </div>
    
        <div class="mb-3">
            <label for="tempo" class="form-label">Informe o tempo de realização:</label>
            <input type="text" id="tempo" name="tempo" class="form-control" required="">
        </div>
    
    <button type="submit" class="btn btn-primary">Enviar</button>
    @if (session('sucesso'))
        <div class="alert alert-success">
            <p class="mensagem-sucesso">{{ session('successo') }} Serviço adicionado com sucesso!</p>
        </div>
    @endif
</form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>