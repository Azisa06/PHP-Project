@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Orçamento</h1>
    
    <form method="POST" action="/orcamentos/{{ $orcamento->id }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" value="{{ $orcamento->nome }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" required>{{ $orcamento->descricao }}</textarea>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço:</label>
            <input type="text" id="preco" name="preco" value="{{ $orcamento->preco }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="servico_id" class="form-label">Serviço:</label>
            <select id="servico_id" name="servico_id" class="form-select" required>
                @foreach ($servicos as $s)
                    <option value="{{ $s->id }}" {{ $orcamento->servico_id == $s->id ? 'selected' : '' }}>
                        {{ $s->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
