@extends('layout')

@section('principal')
<div class="d-flex justify-content-between align-items-start mb-4">
  <h1 class="mb-0">Vendas</h1>

  <div class="d-flex flex-column align-items-end">
    <a class="btn btn-success mb-2" href="{{ route('vendas.create') }}">
      <i class="bi bi-cash-stack"></i> Nova Venda
    </a>
  </div>
</div>

@if (session('erro'))
  <div class="alert alert-danger fs-5">{{ session('erro') }}</div>
@endif
@if (session('sucesso'))
  <div class="alert alert-success fs-5">{{ session('sucesso') }}</div>
@endif

<h2 class="h4 mb-3">Registro de Vendas</h2>

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
    @forelse ($vendas as $venda)
      <tr>
        <td>{{ $venda->id }}</td>
        <td>{{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y') }}</td>

        <td>
          <ul class="mb-0">
            @foreach ($venda->itens as $item)
              <li>{{ $item->produto->nome ?? 'Produto não encontrado' }}</li>
            @endforeach
          </ul>
        </td>

        <td>
          <ul class="mb-0">
            @foreach ($venda->itens as $item)
              <li>{{ $item->quantidade }}</li>
            @endforeach
          </ul>
        </td>

        <td>
          <ul class="mb-0">
            @foreach ($venda->itens as $item)
              <li>R$ {{ number_format($item->preco_venda, 2, ',', '.') }}</li>
            @endforeach
          </ul>
        </td>

        <td>
          R$ {{ number_format($venda->itens->sum(fn($it) => $it->quantidade * $it->preco_venda), 2, ',', '.') }}
        </td>

        <td class="text-center">
          <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('vendas.edit', $venda->id) }}" class="btn btn-warning btn-sm px-3">
              <i class="bi bi-pencil-square"></i> Editar
            </a>
            <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-info btn-sm px-3 text-white">
              <i class="bi bi-eye"></i> Consultar
            </a>

            <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST"
                  onsubmit="return confirm('Tem certeza que deseja excluir esta venda? O estoque será reposto.')"
                  class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm px-3">
                <i class="bi bi-trash"></i> Excluir
              </button>
            </form>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center">Nenhuma venda encontrada.</td>
      </tr>
    @endforelse
  </tbody>
</table>

<div class="d-flex justify-content-end mt-3">
  <a href="@if(Auth::user()->role == 'ADM') /home-adm @elseif(Auth::user()->role == 'ATD') /home-atd @elseif(Auth::user()->role == 'TEC') /home-tec @else / @endif"
     class="btn btn-success">
    <i class="bi bi-arrow-left-circle"></i> Voltar
  </a>
</div>
@endsection