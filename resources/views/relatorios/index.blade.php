@extends('layout')

@section('principal')
<style>
  
</style>
<div class="container">
  <h1 class="mb-4">Relatórios</h1>
  <div class="row">

    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-box-seam fs-1 mb-3 text-estoque"></i>
          <h5 class="card-title mb-2">Estoque</h5>
          <p class="card-text text-center mb-4">Gere um PDF atualizado com o saldo atual, quantidades e preços de venda de estoque dos produtos</p>
          <a href="{{ route('relatorios.estoque') }}" class="btn btn-estoque mt-auto w-100" role="button">
            <i class="bi bi-download"></i> Gerar PDF
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-cash-stack fs-1 mb-3 text-vendas"></i>
          <h5 class="card-title mb-2">Vendas</h5>
          <p class="card-text text-center mb-4">Gere um PDF das vendas realizadas hoje ou no mês atual</p>
          <div class="mt-auto w-100 d-flex justify-content-around">
            <form action="{{ route('relatorios.vendas') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="dia">
              <button type="submit" class="btn btn-vendas">
                <i class="bi bi-calendar-day"></i> Diário
              </button>
            </form>
            <form action="{{ route('relatorios.vendas') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="semanal">
              <button type="submit" class="btn btn-vendas">
                <i class="bi bi-calendar-week"></i> Semanal
              </button>
            </form>
            <form action="{{ route('relatorios.vendas') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="mes">
              <button type="submit" class="btn btn-vendas">
                <i class="bi bi-calendar-month"></i> Mensal
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-tools fs-1 mb-3 text-consertos"></i>
          <h5 class="card-title mb-2">Consertos Finalizados</h5>
          <p class="card-text text-center mb-4">Gere um PDF dos consertos finalizados hoje ou no mês atual</p>
          <div class="mt-auto w-100 d-flex justify-content-around">
            <form action="{{ route('relatorios.consertos') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="dia">
              <button type="submit" class="btn btn-consertos">
                <i class="bi bi-calendar-day"></i> Diário
              </button>
            </form>
            <form action="{{ route('relatorios.consertos') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="semanal">
              <button type="submit" class="btn btn-consertos">
                <i class="bi bi-calendar-week"></i> Semanal
              </button>
            </form>
            <form action="{{ route('relatorios.consertos') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="mes">
              <button type="submit" class="btn btn-consertos">
                <i class="bi bi-calendar-month"></i> Mensal
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="bi bi-bar-chart-line fs-1 mb-3 text-financeiro"></i>
          <h5 class="card-title mb-2">Financeiro</h5>
          <p class="card-text text-center mb-4">Balanço de receitas (vendas/consertos) e despesas (compras) do período</p>
          <div class="mt-auto w-100 d-flex justify-content-around">
            <form action="{{ route('relatorios.financeiro') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="dia">
              <button type="submit" class="btn btn-financeiro">
                <i class="bi bi-calendar-day"></i> Diário
              </button>
            </form>
            <form action="{{ route('relatorios.financeiro') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="semanal">
              <button type="submit" class="btn btn-financeiro">
                <i class="bi bi-calendar-week"></i> Semanal
              </button>
            </form>
            <form action="{{ route('relatorios.financeiro') }}" method="GET" style="display: inline-block;">
              <input type="hidden" name="periodo" value="mes">
              <button type="submit" class="btn btn-financeiro">
                <i class="bi bi-calendar-month"></i> Mensal
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div> <div class="d-flex justify-content-end mt-4">
    <a href="@if(Auth::user()->role == 'ADM') /home-adm
             @elseif(Auth::user()->role == 'ATD') /home-atd
             @elseif(Auth::user()->role == 'TEC') /home-tec
             @else / @endif"
       class="btn btn-success">
      <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>
  </div>

</div>
@endsection