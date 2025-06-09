@extends('layout')
@section('principal')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
      <h2 class="text-center mb-4">Alterar Dados</h2>

      @if (session('erro'))
        <p class="text-danger">{{ session('erro') }}</p>
      @endif

      {{-- ALTERAÇÕES AQUI: action e @method('PUT') --}}
      <form action="/users/{{ Auth::user()->id }}" method="POST">
        @csrf
        @method('PUT') {{-- Adicione esta linha para simular um método PUT --}}
        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input value="{{ Auth::user()->name }}" name="name" type="text" class="form-control" id="name" placeholder="Digite seu nome" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input value="{{ Auth::user()->email }}" name="email" type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
        </div>
        <div class="mb-3">
          <label for="current_password" class="form-label">Informe a senha anterior</label>
          <input name="current_password" type="password" class="form-control" id="current_password" placeholder="Digite sua senha atual" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Informe a nova senha (opcional)</label>
          <input name="password" type="password" class="form-control" id="password" placeholder="Digite a nova senha (se quiser alterar)">
          <div class="form-text">Deixe em branco se não quiser alterar a senha.</div>
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirme a nova senha</label>
          <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirme a nova senha">
        </div>
        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary me-2">
                <i class="bi bi-check-circle"></i> Salvar Alterações
            </button>
             {{-- O botão "Cancelar" foi ajustado para voltar para a home, pois "/users" não é uma rota de listagem de usuário logado --}}
            <a href="{{ url('/login') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </div>
      </form>
    </div>
  </div>
@endsection