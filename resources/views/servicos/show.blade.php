@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-eye"></i> Consultar Serviço
        </h1>
        <form method="post" action="/servicos/{{ $servico->id }}">
          @csrf
          @method('DELETE')
          <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome do serviço:</label>
            <input type="text" id="nome" name="nome" value="{{ $servico->nome }}" class="form-control" disabled>
          </div>
          <div class="mb-3">
            <label for="descricao" class="form-label">Informe a descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" disabled>{{ $servico->descricao }}</textarea>
          </div>
          <div class="mb-3">
            <label for="preco" class="form-label">Informe o preço:</label>
            <input type="text" id="preco" name="preco" value="{{ $servico->preco }}" class="form-control" disabled>
          </div>
          <div class="mb-3">
            <label for="categoria" class="form-label">Selecione a categoria:</label>
            <select id="categoria_id" name="categoria_id" class="form-select" disabled>
              @foreach ($categorias as $c)
                <option value="{{ $c->id }}" {{ $servico->categoria_id == $c->id ? "selected" : "" }}>
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
            <a href="/servicos" class="btn btn-primary">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection