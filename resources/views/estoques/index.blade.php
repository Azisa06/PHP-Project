@extends('layout')

@section('principal')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="mb-0">Estoque</h1>
</div>

@if (session('erro'))
  <div class="alert alert-danger fs-5">
    {{ session('erro') }}
  </div>
@endif

@if (session('sucesso'))
  <div class="alert alert-success fs-5">
    {{ session('sucesso') }}
  </div>
@endif

<h2 class="h4 mb-3">Registro de Estoque</h2>
<table class="table table-hover table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>Produto</th>
      <th>Quantidade</th>
      <th>Tipo</th>
      <th>Preço de Venda (R$)</th>
      <th>Data</th>
    </tr>
  </thead>
  <tbody>
    @forelse($estoques as $estoque)
      <tr>
        <td>{{ $estoque->produto->nome ?? 'Produto não encontrado' }}</td>
        <td>{{ $estoque->quantidade }}</td>
        <td>{{ ucfirst($estoque->tipo) }}</td>
        <td>R$ {{ number_format($estoque->preco_venda, 2, ',', '.') }}</td>
        <td>{{ \Carbon\Carbon::parse($estoque->data)->format('d/m/Y') }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="5">Nenhuma movimentação de estoque encontrada.</td>
      </tr>
    @endforelse
  </tbody>
</table>
<div class="d-flex justify-content-end mt-3">
  <a href="@if(Auth::user()->role == 'ADM') /home-adm
            @elseif(Auth::user()->role == 'ATD') /home-atd
            @elseif(Auth::user()->role == 'TEC') /home-tec
            @else / @endif"
    class="btn btn-success">
    <i class="bi bi-arrow-left-circle"></i> Voltar
  </a>
</div>
@endsection