<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Shock</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar estilo dark -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="/img/logoshock.png" alt="Logo Shock" width="30" height="30" class="me-2 rounded-circle">
      Sistema Shock
    </a>

      <!-- Botão toggle para mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarConteudo" aria-controls="navbarConteudo" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Itens da navbar -->
      <div class="collapse navbar-collapse" id="navbarConteudo">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          @if (Auth::user()->role == "ADM")
            <li class="nav-item">
              <a class="nav-link" href="/clientes">Clientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/funcionarios">Funcionários</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/produtos">Produtos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/servicos">Serviços</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/orcamentos">Orçamentos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/relatorios">Relatórios</a>
            </li>
          @endif
          @if (Auth::user()->role == "ATD")
            <li class="nav-item">
              <a class="nav-link" href="/clientes">Clientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/produtos">Produtos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/servicos">Serviços</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/orcamentos">Orçamentos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/relatorios">Relatórios</a>
            </li>
          @endif
          @if (Auth::user()->role == "TEC")
          <li class="nav-item">
              <a class="nav-link" href="/servicos">Serviços</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/orcamentos">Orçamentos</a>
            </li>
          @endif
        </ul>
        <span class="navbar-text text-white me-3">
          Olá, {{ Auth::user()->name }}
        </span>
        <div class="d-flex gap-2 align-items-center">
          <a href="/users/{{ Auth::user()->id }}/edit" class="btn btn-success">Alterar meus dados</a>
          <form method="POST" action="/logout" class="m-0">
              @csrf
              <button type="submit" class="btn btn-danger">Sair</button>
          </form>
        </div>
    </div>
  </nav>
  <main class="container">
    @yield('principal')
  </main>
  
  <!-- Bootstrap JS Bundle (com Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
