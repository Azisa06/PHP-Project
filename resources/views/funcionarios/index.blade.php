<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Funcionários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="container">
    <h1>Funcionários<h1>

    <a class="btn btn-primary" href="/funcionarios/create">Novo Funcionário</a>
    @if (session('erro'))
        <div class="alert alert-danger fs-5">
            {{ session('erro') }}
        </div>
    @endif

    @if (session('sucesso'))
        <div class="alert alert-success fs-5">
            {{ session('sucesso') }}
        </div>
    @endif
    
    <h2>Registro de Funcionários</h2>
        <!--<a href="#" class="btn btn-success mb-3">Novo Registro</a> não sei o que este botão faz-->
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Funcionário</th>
                    <th>Celular</th>
                    <th>Função</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($funcionarios as $f)
                    <tr>
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->nome }}</td>
                        <td>{{ $f->celular }}</td>
                        <td>{{ $f->categoria->nome }}</td>
                        <td>
                            <a href="/funcionarios/{{ $f->id }}/edit" class="btn btn-warning">Editar</a>
                            <a href="/funcionarios/{{ $f->id }}" class="btn btn-info">Consultar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
                
</body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>