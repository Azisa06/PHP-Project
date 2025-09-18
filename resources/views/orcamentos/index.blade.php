@extends('layout')

@section('principal')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="mb-0">Orçamentos</h1>
  <a class="btn btn-primary" href="{{ route('orcamentos.create') }}">
    <i class="bi bi-file-earmark-plus"></i> Cadastrar Orçamento
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

<h2 class="h4 mb-3">Registro de Orçamentos</h2>
<table class="table table-hover table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Cliente</th>
      <th>Preço</th>
      <th>Serviço</th>
      <th>Data</th>
      <th>Status</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orcamentos as $o)
      <tr>
        <td>{{ $o->id }}</td>
        <td>{{ $o->cliente->nome }}</td>
        <td>R$ {{ number_format($o->preco, 2, ',', '.') }}</td>
        <td>{{ $o->servico->nome }}</td>
        <td>{{ $o->data }}</td>
        <td>{{ $o->statusOrcamento->nome ?? 'N/A' }}</td>
        <td>
          <div class="d-flex justify-content-center gap-2">
            <a href="/orcamentos/{{ $o->id }}/edit" class="btn btn-warning btn-sm px-3">
              <i class="bi bi-pencil-square"></i> Editar
            </a>
            <a href="/orcamentos/{{ $o->id }}" class="btn btn-info btn-sm px-3 text-white">
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