@extends('layout')

@section('principal')
    <div class="mt-5">
    <h2>Fila de Orçamentos Aprovados</h2>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>Orçamentos Aguardando Início do Serviço</strong>
                </div>
                <div class="card-body">
                    @if (!isset($orcamentosAprovados) || $orcamentosAprovados->isEmpty())
                        <div class="alert alert-warning mb-0">
                            Nenhum orçamento aprovado aguardando início do serviço.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle shadow-sm">
                                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Serviço</th>
                                        <th>Data Aprovação</th>
                                        <th>Descrição</th>
                                        <th class="text-center">Ações</th>
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
                                            <td class="text-center">
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="5">
                                                    <button class="btn btn-sm btn-success mb-1" type="submit" onclick="return confirm('Iniciar conserto para este orçamento?')">
                                                        <i class="bi bi-gear"></i> Iniciar Conserto
                                                    </button>
                                                </form>
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="8">
                                                    <button class="btn btn-sm btn-danger mb-1" type="submit" onclick="return confirm('Cancelar este orçamento? O orçamento será cancelado, necessitando de novo orçamento.')">
                                                        <i class="bi bi-x-circle"></i> Cancelar Orçamento
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="mt-5">
        <h2>Fila de Orçamentos em Conserto</h2>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>Orçamentos em Serviço</strong>
                </div>
                <div class="card-body">
                    {{-- Use $orcamentosEmConserto for this queue --}}
                    @if (!isset($orcamentosEmConserto) || $orcamentosEmConserto->isEmpty())
                        <div class="alert alert-warning mb-0">
                            Nenhum orçamento em conserto no momento.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle shadow-sm">
                                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Serviço</th>
                                        <th>Data Início</th>
                                        <th>Descrição</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orcamentosEmConserto as $orcamento)
                                        <tr>
                                            <td>{{ $orcamento->id }}</td>
                                            <td>{{ $orcamento->cliente->nome ?? 'N/A' }}</td>
                                            <td>{{ $orcamento->servico->nome ?? 'N/A' }}</td>
                                            <td>{{ $orcamento->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $orcamento->descricao }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="6">
                                                    <button class="btn btn-sm btn-success mb-1" type="submit" onclick="return confirm('Finalizar conserto deste orçamento?')">
                                                        <i class="bi bi-check-circle"></i> Finalizar
                                                    </button>
                                                </form>
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="4">
                                                    <button class="btn btn-sm btn-warning mb-1" type="submit" onclick="return confirm('Cancelar este conserto? O orçamento voltará para a fila de aprovados.')">
                                                        <i class="bi bi-x-circle"></i> Cancelar Conserto
                                                    </button>
                                                </form>
                                                <form action="{{ route('orcamentos.status', $orcamento->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="8">
                                                    <button class="btn btn-sm btn-danger mb-1" type="submit" onclick="return confirm('Cancelar este orçamento? O orçamento será cancelado, necessitando de novo orçamento.')">
                                                        <i class="bi bi-x-circle"></i> Cancelar Orçamento
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection