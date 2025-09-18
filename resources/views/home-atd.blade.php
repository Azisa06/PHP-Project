@extends('layout')

@section('principal')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow mb-4 mt-5">
                <div class="card-header">
                    <strong>Orçamentos Pendentes de Aprovação</strong>
                </div>
                <div class="card-body">
                    @if(isset($orcamentosPendentes) && count($orcamentosPendentes) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle shadow-sm">
                                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Serviço</th>
                                        <th>Data</th>
                                        <th>Descrição</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orcamentosPendentes as $orcamento)
                                        <tr>
                                            <td>{{ $orcamento->id }}</td>
                                            <td>{{ $orcamento->cliente->nome ?? 'N/A' }}</td>
                                            <td>{{ $orcamento->servico->nome ?? 'N/A' }}</td>
                                            <td>{{ $orcamento->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $orcamento->descricao }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-sm btn-info text-white mb-1">
                                                    <i class="bi bi-eye"></i> Ver Detalhes
                                                </a>
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="4">
                                                    <button class="btn btn-sm btn-success mb-1" type="submit" onclick="return confirm('Aprovar este orçamento?')">
                                                        <i class="bi bi-check-circle"></i> Aprovar
                                                    </button>
                                                </form>
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="7">
                                                    <button class="btn btn-sm btn-danger mb-1" type="submit" onclick="return confirm('Rejeitar este orçamento?')">
                                                        <i class="bi bi-x-circle"></i> Rejeitar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            Nenhum orçamento pendente de aprovação.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>Últimos Clientes Cadastrados</strong>
                </div>
                <div class="card-body">
                    @if(isset($ultimosClientes) && count($ultimosClientes) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped mt-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Data Cadastro</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ultimosClientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nome }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->celular }}</td>
                                        <td>{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sn btn-info text-white">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0">Não há clientes cadastrados recentemente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection