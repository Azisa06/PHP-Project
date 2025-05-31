@extends('layout')

@section('principal')
    <h1>Bem vindo administrador: {{ Auth::user()->name }}</h1>
    <h2>Estoque de Produtos</h2>

    {{-- Alerta de estoque baixo --}}
    @if(isset($produtosEstoqueBaixo) && $produtosEstoqueBaixo->count())
        <div class="alert alert-warning mt-4">
        <strong>Atenção!</strong>
        <p>Os seguintes produtos estão com estoque baixo:</p>
        <ul>
            @foreach($produtosEstoqueBaixo as $produto)
            <li>
                {{ $produto->nome }} — Quantidade em estoque: {{ $produto->estoque }}
            </li>
            @endforeach
        </ul>
        </div>
    @endif

    <canvas id="graficoEstoque" width="300" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const ctx = document.getElementById('graficoEstoque').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($produtos->pluck('nome')),
                datasets: [{
                    label: 'Estoque',
                    data: @json($produtos->pluck('estoque')),
                    backgroundColor: 'rgba(75, 192, 106, 0.7)',
                    borderColor: 'rgb(75, 192, 137)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return parseInt(value);
                        }
                    }
                    }
                }
            }
        });
    </script>
    <h2>Controle de orçamentos</h2>
@endsection