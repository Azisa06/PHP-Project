@extends('layout')

@section('principal')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="mb-0">Compras</h1>
  <a class="btn btn-primary" href="{{ route('compras.create') }}">
    <i class="bi bi-file-earmark-plus"></i> Nova Compra
  </a>
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

<h2 class="h4 mb-3">Registro de Compras</h2>
<table class="table table-hover table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Data</th>
      <th>Produtos</th>
      <th>Quantidade</th>
      <th>Preço Unitário</th>
      <th>Preço Total</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($compras as $compra)
      <tr>
        <td>{{ $compra->id }}</td>
        <td>{{ \Carbon\Carbon::parse($compra->data)->format('d/m/Y') }}</td>

        {{-- Produtos --}}
        <td>
          <ul class="mb-0">
            @foreach ($compra->itens as $item)
              <li>{{ $item->produto->nome ?? 'Produto não encontrado' }}</li>
            @endforeach
          </ul>
        </td>

        {{-- Quantidades --}}
        <td>
          <ul class="mb-0">
            @foreach ($compra->itens as $item)
              <li>{{ $item->quantidade }}</li>
            @endforeach
          </ul>
        </td>

        {{-- Preço unitário --}}
        <td>
          <ul class="mb-0">
            @foreach ($compra->itens as $item)
              <li>
                R$ {{ number_format($item->preco_compra, 2, ',', '.') }}
              </li>
            @endforeach
          </ul>
        </td>

        {{-- Preço total --}}
        <td>
          R$
          {{
            number_format(
              $compra->itens->sum(function ($item) {
                return $item->quantidade * $item->preco_compra;
              }),
              2,
              ',',
              '.'
            )
          }}
        </td>

        {{-- Ações --}}
        <td>
          <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning btn-sm px-3">
              <i class="bi bi-pencil-square"></i> Editar
            </a>
            <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-info btn-sm px-3 text-white">
              <i class="bi bi-eye"></i> Consultar
            </a>
          </div>
        </td>
      </tr>
    @endforeach
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