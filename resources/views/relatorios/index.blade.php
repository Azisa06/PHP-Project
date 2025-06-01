<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatórios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body class="container mt-5">

    <div class="mb-4">
      <h1 class="mb-4">Relatórios</h1>
      <h2 class="h4 mb-3">Relatório de Estoque</h2>
    </div>

    <div class="mb-0">
      <a href="{{ route('relatorios.estoque') }}" class="btn btn-primary" role="button">
        <i class="bi bi-download"></i> Gerar relatório (PDF)
      </a>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <a href="@if(Auth::user()->role == 'ADM') /home-adm
                @elseif(Auth::user()->role == 'ATD') /home-atd
                @elseif(Auth::user()->role == 'TEC') /home-tec
                @else / @endif"
        class="btn btn-success">
        <i class="bi bi-arrow-left-circle"></i> Voltar
      </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>