@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-file-earmark-plus"></i> Criar Orçamento
        </h1>
        <form method="POST" action="/orcamentos">
          @csrf

          <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
              <option value="">Selecione um cliente</option>
              @foreach($clientes as $c)
                <option value="{{ $c->id }}">
                  {{ $c->nome }} - CPF {{ ($c->cpf) }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="data" class="form-label">Data</label>
            <input type="date" name="data" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="servico_id" class="form-label">Serviço</label>
            <select name="servico_id" id="servico_id" class="form-select" required>
              <option value="">Selecione um serviço</option>
              @foreach($servicos as $s)
                <option value="{{ $s->id }}">
                  {{ $s->nome }} - R$ {{ number_format($s->preco, 2, ',', '.') }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="text" name="preco" class="form-control" required>
          </div>

          <!--<div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select name="status_id" id="status_id" class="form-select" required>
              <option value="">Selecione um status</option>
              @foreach($status as $st)
                <option value="{{ $st->id }}">
                  {{ $st->nome }}
                </option>
              @endforeach
            </select>
          </div>-->

          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-check-circle"></i> Cadastrar
            </button>
            <a href="/orcamentos" class="btn btn-danger">
              <i class="bi bi-x-circle"></i> Cancelar
            </a>
          </div>

          @if (session('sucesso'))
            <div class="alert alert-success mt-3">
              <p class="mensagem-sucesso mb-0">{{ session('sucesso') }}</p>
            </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>
@endsection