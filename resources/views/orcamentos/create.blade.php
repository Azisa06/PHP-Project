@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Orçamento</h1>

    <form action="{{ route('orcamentos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="servico_id" class="form-label">Serviço</label>
            <select name="servico_id" id="servico_id" class="form-control" required>
                <option value="">Selecione um serviço</option>
                @foreach($servicos as $servico)
                    <option value="{{ $servico->id }}">{{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="valor_total" class="form-label">Valor Total</label>
            <input type="text" name="valor_total" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
