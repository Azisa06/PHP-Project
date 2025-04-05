<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <h1>Consultar Serviço</h1>
    
    <form method="post" action="/servicos/{{ $servico-> id }}"> <!--chave primária do serviço-->
        @csrf
        @method('DELETE') <!--padrão quando é para update, fica no lugar do post-->             
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome do serviço:</label>
            <input type="text" id="nome" name="nome" value="{{ $servico->nome }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="descricao" class="form-label">Informe a descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" disabled>
                {{ $servico->descricao }} 
            </textarea>
        </div>
    
        <div class="mb-3">
            <label for="preco" class="form-label">Informe o preço:</label>
            <input type="text" id="preco" name="preco" value="{{ $servico->preco }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="tempo" class="form-label">Informe o tempo de realização:</label>
            <input type="text" id="tempo" name="tempo" value="{{ $servico->tempo }}" class="form-control" disabled>
        </div>
    
    <p>Deseja excluir o registro?</p>
    <button type="submit" class="btn btn-danger">Excluir</button>
    <a href="/servicos" class="btn btn-primary">Cancelar</a>
</form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>