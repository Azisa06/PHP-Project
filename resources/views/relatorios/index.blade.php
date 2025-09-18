@extends('layout')

@section('principal')
<div class="container py-4">
  <h1 class="mb-4">Relatórios</h1>
  <div class="row">
    <!-- Relatório de Estoque -->
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-clipboard-data fs-1 mb-3 text-primary"></i>
          <h5 class="card-title mb-2">Estoque</h5>
          <p class="card-text text-center mb-4">Gere um PDF atualizado com o saldo atual, quantidades e preços de venda de estoque dos produtos</p>
          <a href="{{ route('relatorios.estoque') }}" class="btn btn-primary mt-auto w-100" role="button">
            <i class="bi bi-download"></i> Gerar PDF
          </a>
        </div>
      </div>
    </div>
    <!-- Exemplo de outro relatório futuro
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-person-lines-fill fs-1 mb-3 text-success"></i>
          <h5 class="card-title mb-2">Clientes</h5>
          <p class="card-text text-center mb-4">Gere um relatório com informações dos clientes cadastrados</p>
          <a href="#" class="btn btn-success disabled mt-auto w-100" role="button">
            <i class="bi bi-download"></i> Em breve
          </a>
        </div>
      </div>
    </div>
     Exemplo de outro relatório futuro
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-file-earmark-bar-graph fs-1 mb-3 text-warning"></i>
          <h5 class="card-title mb-2">Orçamentos</h5>
          <p class="card-text text-center mb-4">Relatório de orçamentos realizados e seus status</p>
          <a href="#" class="btn btn-warning disabled mt-auto w-100" role="button">
            <i class="bi bi-download"></i> Em breve
          </a>
        </div>
      </div>
    </div> -->
  </div>
</div>
@endsection