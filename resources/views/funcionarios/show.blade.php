@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-eye"></i> Consultar Cadastro
        </h1>
        <form method="post" action="/funcionarios/{{ $funcionario->id }}">
          @csrf
          @method('DELETE')
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
                <option value="{{ $c->id }}" {{ $funcionario->categoria_id == $c->id ? "selected" : "" }}>
                  {{ $c->nome }}
                </option>
              @endforeach
            </select>
          </div>
          <p class="text-center">Deseja excluir o registro?</p>
          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-danger me-2">
              <i class="bi bi-check-circle"></i> Excluir
            </button>
            <a href="/funcionarios" class="btn btn-primary">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection