@extends('layout')
@section('principal')
  {{-- Atalhos rápidos --}}
    <div class="mb-4 d-flex gap-3" style="margin-top: 30px;">
        <a href="{{ route('clientes.create') }}" class="btn btn-info">Novo Cadastro de Cliente</a>
        <a href="{{ route('clientes.index') }}" class="btn btn-info">Buscar Cliente</a>
    </div>

    {{-- Serviços/Orçamentos pendentes de confirmação --}}
    <h3>Serviços/Orçamentos Pendentes de Confirmação</h3>
    @if(isset($pendentes) && count($pendentes) > 0)
        <div class="table-responsive">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pendentes as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->cliente->nome ?? 'N/A' }}</td>
                        <td>{{ ucfirst($item->tipo) }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('servicos.show', $item->id) }}" class="btn btn-sm btn-info">Ver Detalhes</a>
                            {{-- Adicione aqui outras ações, como confirmar ou cancelar --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Não há serviços ou orçamentos pendentes de confirmação.</p>
    @endif

    {{-- Últimos clientes cadastrados --}}
    <h3 class="mb-3 mt-5">Últimos Clientes Cadastrados</h3>
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
                        <td>{{ $cliente->telefone }}</td>
                        <td>{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sn btn-success">Ver</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Não há clientes cadastrados recentemente.</p>
    @endif
@endsection