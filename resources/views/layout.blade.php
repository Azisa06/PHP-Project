<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Shock</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar estilo dark -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" 
         href="@if(Auth::user()->role == 'ADM') /home-adm
               @elseif(Auth::user()->role == 'ATD') /home-atd
               @elseif(Auth::user()->role == 'TEC') /home-tec
               @else / @endif">
        <img src="/img/logoshock.png" alt="Logo Shock" width="30" height="30" class="me-2 rounded-circle">
        <span>Sistema Shock</span>
      </a>

      <!-- Botão toggle para mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarConteudo" aria-controls="navbarConteudo" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Itens da navbar -->
      <div class="collapse navbar-collapse" id="navbarConteudo">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          @if (Auth::user()->role == "ADM")
            <!-- ADM: Cadastro -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownCadastro" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Cadastro</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownCadastro">
                <li><a class="dropdown-item" href="/clientes">Clientes</a></li>
                <li><a class="dropdown-item" href="/funcionarios">Funcionários</a></li>
              </ul>
            </li>
            <!-- ADM: Produtos -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownProdutos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Produtos</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownProdutos">
                <li><a class="dropdown-item" href="/produtos">Produtos</a></li>
                <li><a class="dropdown-item" href="/estoques">Estoque</a></li>
                <li><a class="dropdown-item" href="/compras">Compras</a></li>
                <li><a class="dropdown-item" href="/vendas">Vendas</a></li>
              </ul>
            </li>
            <!-- ADM: Serviços -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownServicos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Serviços</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownServicos">
                <li><a class="dropdown-item" href="/servicos">Serviços</a></li>
                <li><a class="dropdown-item" href="/orcamentos">Orçamentos</a></li>
              </ul>
            </li>
            <!-- ADM: Relatórios -->
            <li class="nav-item">
              <a class="nav-link" href="/relatorios">Relatórios</a>
            </li>
          @elseif (Auth::user()->role == "ATD")
            <!-- ATD: Cadastro -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownCadastro" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Cadastro</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownCadastro">
                <li><a class="dropdown-item" href="/clientes">Clientes</a></li>
              </ul>
            </li>
            <!-- ATD: Produtos -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownProdutos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Produtos</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownProdutos">
                <li><a class="dropdown-item" href="/produtos">Produtos</a></li>
                <li><a class="dropdown-item" href="/estoques">Estoque</a></li>
                <li><a class="dropdown-item" href="/compras">Compras</a></li>
              </ul>
            </li>
            <!-- ATD: Serviços -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownServicos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Serviços</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownServicos">
                <li><a class="dropdown-item" href="/servicos">Serviços</a></li>
                <li><a class="dropdown-item" href="/orcamentos">Orçamentos</a></li>
              </ul>
            </li>
            <!-- ATD: Relatórios -->
            <li class="nav-item">
              <a class="nav-link" href="/relatorios">Relatórios</a>
            </li>
          @elseif (Auth::user()->role == "TEC")
            <!-- TEC: Serviços -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownServicos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">Serviços</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownServicos">
                <li><a class="dropdown-item" href="/servicos">Serviços</a></li>
                <li><a class="dropdown-item" href="/orcamentos">Orçamentos</a></li>
              </ul>
            </li>
          @endif
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-4 me-2"></i>
              <span class="d-none d-lg-block">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarUserDropdown">
              <li>
                <a class="dropdown-item" href="/users/{{ Auth::user()->id }}/edit">Alterar meus dados</a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="/logout" class="dropdown-item p-0">
                  @csrf
                  <button type="submit" class="btn btn-link text-decoration-none text-danger w-100 text-start p-2">Sair</button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Adicionei utilitário Bootstrap mt-4 para dar espaçamento entre a navbar e o conteúdo -->
  <main class="container mt-4">
    @yield('principal')
  </main>

  <!-- Bootstrap JS Bundle (com Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>