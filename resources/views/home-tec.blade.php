@extends('layout')
@section('principal')

<h2 class="mb-4">Fila de Orçamentos Aprovados</h2>

@if ($orcamentosAprovados->isEmpty())
    <div class="alert alert-warning">
        Nenhum orçamento aprovado no momento.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orcamentosAprovados as $orcamento)
                    <tr>
                        <td>{{ $orcamento->id }}</td>
                        <td>{{ $orcamento->cliente->nome ?? 'N/A' }}</td>
                        <td>{{ $orcamento->servico->nome ?? 'N/A' }}</td>
                        <td>{{ $orcamento->created_at->format('d/m/Y') }}</td>
                        <td>{{ $orcamento->descricao }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection