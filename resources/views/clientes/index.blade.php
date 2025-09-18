@extends('layout')

@section('principal')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="mb-0">Clientes</h1>
  <a class="btn btn-primary" href="{{ route('clientes.create') }}">
    <i class="bi bi-person-plus"></i> Cadastrar Cliente
  </a>
</div>

@if (session('erro'))
  <div class="alert alert-danger">
    {{ session('erro') }}
  </div>
@endif

@if (session('sucesso'))
  <div class="alert alert-success">
    {{ session('sucesso') }}
  </div>
@endif

<h2 class="h4 mb-3">Registro de Clientes</h2>
<table class="table table-hover table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Nome do Cliente</th>
      <th>Celular</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($clientes as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->nome }}</td>
        <td>{{ $c->celular }}</td>
        <td>
          <div class="d-flex justify-content-center gap-2">
            <a href="/clientes/{{ $c->id }}/edit" class="btn btn-warning btn-sm px-3">
              <i class="bi bi-pencil-square"></i> Editar
            </a>
            <a href="/clientes/{{ $c->id }}" class="btn btn-info btn-sm px-3 text-white">
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