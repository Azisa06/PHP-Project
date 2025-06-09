<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Estoque</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    </head>
    <body class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Estoque</h1>
        </div>

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

        <h2 class="h4 mb-3">Registro de Estoque</h2>
        <table class="table table-hover table-striped align-middle">
        <thead class="table-light">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Tipo</th>
                    <th>Preço de Venda (R$)</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estoques as $estoque)
                    <tr>
                        <td>{{ $estoque->produto->nome ?? 'Produto não encontrado' }}</td>
                        <td>{{ $estoque->quantidade }}</td>
                        <td>{{ ucfirst($estoque->tipo) }}</td>
                        <td>R$ {{ number_format($estoque->preco_venda, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($estoque->data)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Nenhuma movimentação de estoque encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <a href="/produtos" class="btn btn-success">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
