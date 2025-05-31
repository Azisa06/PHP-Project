<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <h1>Consultar Funcionário</h1>
    
    <form method="post" action="/funcionarios/{{ $funcionario-> id }}"> <!--chave primária do produta-->
        @csrf
        @method('DELETE') <!--padrão quando é para update, fica no lugar do post-->             
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome do funcionário:</label>
            <input type="text" id="nome" name="nome" value="{{ $funcionario->nome }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="celular" class="form-label">Celular:</label>
            <input type="text" id="celular" name="celular" value="{{ $funcionario->celular }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="{{ $funcionario->cpf }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
                    <input type="email" id="email" name="email" value="{{ $funcionario->email }}" class="form-control" disabled>
        </div>
    
        <div class="mb-3">
            <label for="categoria" class="form-label">Selecione a função:</label>
            <select id="categoria_id" name="categoria_id" class="form-select" disabled>
                @foreach ($categorias as $c)
                    <option value="{{ $c->id }}" {{ $funcionario->categoria_id == $c->id ? "selected" : "" }}> <!--operador ternário para a categoria já vir selecionada quando o id de uma categoria for igual a de um produto-->
                        {{ $c->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <p>Deseja excluir o registro?</p>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <a href="/funcionarios" class="btn btn-primary">Cancelar</a>
    </form>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>