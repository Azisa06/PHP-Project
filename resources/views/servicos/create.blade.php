@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-gear-fill"></i> Cadastrar Serviço
        </h1>
        <form method="post" action="/servicos">
          @csrf

          <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome do serviço:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="descricao" class="form-label">Informe a descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label for="preco" class="form-label">Informe o preço:</label>
            <input type="text" id="preco" name="preco" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="categoria_id" class="form-label">Selecione a categoria:</label>
            <select id="categoria_id" name="categoria_id" class="form-select" required>
              <option value="" disabled selected>Selecione...</option>
              @foreach ($categorias as $c)
                <option value="{{ $c->id }}">
                  {{ $c->nome }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-check-circle"></i> Cadastrar
            </button>
            <a href="/servicos" class="btn btn-danger">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>

          @if (session('sucesso'))
            <div class="alert alert-success mt-3 fs-5">
              <p class="mensagem-sucesso mb-0">{{ session('sucesso') }} Serviço cadastrado com sucesso!</p>
            </div>
          @endif

        </form>
      </div>
    </div>
  </div>
</div>
@endsection