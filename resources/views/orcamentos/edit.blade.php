@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-pencil-square"></i> Editar Orçamento
        </h1>
        <form method="POST" action="/orcamentos/{{ $orcamento->id }}">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente:</label>
            <select id="cliente_id" name="cliente_id" class="form-select" required>
              <option value="" disabled>Selecione...</option>
              @foreach ($clientes as $c)
                <option value="{{ $c->id }}" {{ $orcamento->cliente_id == $c->id ? 'selected' : '' }}>
                  {{ $c->nome }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="data" class="form-label">Data:</label>
            <input type="date" id="data" name="data" value="{{ $orcamento->data }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="servico_id" class="form-label">Serviço:</label>
            <select id="servico_id" name="servico_id" class="form-select" required>
              <option value="" disabled>Selecione...</option>
              @foreach ($servicos as $s)
                <option value="{{ $s->id }}" {{ $orcamento->servico_id == $s->id ? 'selected' : '' }}>
                  {{ $s->nome }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" required>{{ $orcamento->descricao }}</textarea>
          </div>

          <div class="mb-3">
            <label for="preco" class="form-label">Preço:</label>
            <input type="text" id="preco" name="preco" value="{{ $orcamento->preco }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="status_id" class="form-label">Status:</label>
            <select id="status_id" name="status_id" class="form-select" required>
              <option value="" disabled>Selecione...</option>
              @foreach ($status as $st)
                <option value="{{ $st->id }}" {{ $orcamento->status_id == $st->id ? 'selected' : '' }}>
                  {{ $st->nome }} - {{ $st->descricao }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-check-circle"></i> Atualizar
            </button>
            <a href="/orcamentos" class="btn btn-danger">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection