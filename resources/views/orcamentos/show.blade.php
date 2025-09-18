@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-eye"></i> Consultar Orçamento
        </h1>
        <form method="post" action="/orcamentos/{{ $orcamento->id }}">
          @csrf
          @method('DELETE')

          <div class="mb-3">
            <label class="form-label">Cliente:</label>
            <input type="text" class="form-control" value="{{ $orcamento->cliente->nome ?? 'N/A' }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Data:</label>
            <input type="date" class="form-control" value="{{ $orcamento->data }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Descrição:</label>
            <textarea class="form-control" rows="4" disabled>{{ $orcamento->descricao }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Preço:</label>
            <input type="text" class="form-control" value="R$ {{ number_format($orcamento->preco, 2, ',', '.') }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Serviço:</label>
            <input type="text" class="form-control" value="{{ $orcamento->servico->nome ?? 'N/A' }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Status:</label>
            <input type="text" class="form-control" value="{{ $orcamento->statusOrcamento->nome ?? 'N/A' }}" disabled>
          </div>

          <p class="text-center">Deseja excluir o registro?</p>
          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-danger me-2">
              <i class="bi bi-check-circle"></i> Excluir
            </button>
            <a href="/orcamentos" class="btn btn-primary">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection