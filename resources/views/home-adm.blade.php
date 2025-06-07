@extends('layout')

@section('principal')
    <h2>Controle de Estoque de Produtos</h2>

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
    <canvas id="graficoOrcamentos" width="300" height="300"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('graficoOrcamentos').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Abertos', 'Finalizados'],
                datasets: [{
                    label: 'Orçamentos',
                    data: [{{ $orcamentosAbertos }}, {{ $orcamentosFinalizados }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', 
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', 
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
    </script>
@endsection