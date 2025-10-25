@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">
          <i class="bi bi-receipt"></i> Detalhes da Venda #{{ $venda->id }}
        </h1>

        <div class="mb-3">
          <h5>Data da Venda: {{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y') }}</h5>
        </div>

        <h5 class="mt-4">Produtos Vendidos</h5>

        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço Unitário</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($venda->itens as $item)
              <tr>
                <td>{{ $item->produto->nome ?? 'Produto não encontrado' }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>R$ {{ number_format($item->preco_venda, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="table-secondary">
              <th colspan="3" class="text-end">Preço Total:</th>
              <th>R$ {{ number_format($venda->preco_total, 2, ',', '.') }}</th>
            </tr>
          </tfoot>
        </table>

        <div class="d-flex justify-content-center mt-4">
          <a href="{{ route('vendas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Voltar
          </a>
        </div>

        {{-- Adicionar formulário de exclusão aqui, se necessário --}}

      </div>
    </div>
  </div>
</div>
@endsection