@extends('layout')
@section('principal')

<h2>Fila de Orçamentos Aprovados (Aguardando Peças)</h2>

    @if ($orcamentosAprovados->isEmpty())
        <p>Nenhum orçamento aprovado no momento.</p>
    @else
        <table border="1" cellpadding="5">
            <thead>
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
    @endif

@endsection