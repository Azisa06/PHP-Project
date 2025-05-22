<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Loja Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .banner {
            width: 100%;
            height: 400px;
            background-size: cover;
            background-position: center;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Meu ecommerce</h1>

    <!--Essa página é a tela inicial que aparece antes de fazer login
        Sugestão: colocar informações sobre o sistema e o botão para a página de login-->

    <!-- Ideia de como seria apresentar todos os produtos cadastrados e suas respectivas imagens
    <div class="container mt-4">
        <h2 class="text-center">Nossos Produtos</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($produtos as $p)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{asset('storage/'.$p->foto)}}" class="card-img-top" alt="Produto 1">
                        <div class="card-body">
                            <h5 class="card-title">{{ $p->nome }}</h5>
                            <p class="card-text">{{ $p->descricao }}</p>
                            <a href="#" class="btn btn-primary">Comprar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> -->

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
