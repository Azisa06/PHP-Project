<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="icon" href="{{ asset('img/logoshock.png') }}" type="image/png">
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/login.css">
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card login-card shadow">
      <div class="login-logo-title">
        <img src="/img/logoshock.png" alt="Logo">
        <h2 class="mb-0">Login</h2>
      </div>

      @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $e)
            <p>{{ $e }}</p>
          @endforeach
        </div>
      @endif

      <form action="/login" method="post">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input name="password" type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
        </div>
        <div class="d-flex justify-content-between gap-2 mb-3">
          <button type="submit" class="btn btn-success login-btn">Entrar</button>
          <a href="/cadastro" class="btn btn-secondary login-btn">
            Cadastro
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>