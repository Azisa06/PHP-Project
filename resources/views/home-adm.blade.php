@extends('layout')

@section('principal')
    <div class="row mt-4">
        <div class="col-md-7">
            <h2>Controle de Estoque de Produtos</h2>
        </div>
        <div class="col-md-5">
            <h2>Controle de Orçamento</h2>
        </div>
    </div>

    @if(isset($produtosEstoqueBaixo) && $produtosEstoqueBaixo->count())
        <div class="alert alert-warning mt-4 col-md-7">
            <strong>Atenção!</strong>
            <p>Os seguintes produtos estão com estoque baixo:</p>
            <ul>
                @foreach($produtosEstoqueBaixo as $produto)
                <li>
                    {{ $produto->nome }} — Quantidade em estoque: {{ $produto->estoque_atual }}
                </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>Gráfico de Estoque de Produtos</strong>
                </div>
                <div class="card-body">
                    <canvas id="graficoEstoque" width="300" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>Gráfico de Orçamentos</strong>
                </div>
                <div class="card-body">
                    <canvas id="graficoOrcamentos" width="300" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Estoque
        const ctxEstoque = document.getElementById('graficoEstoque').getContext('2d');
        const chartEstoque = new Chart(ctxEstoque, {
            type: 'bar',
            data: {
                labels: @json($produtos->pluck('produto.nome')),
                datasets: [{
                    label: 'Estoque',
                    data: @json($produtos->pluck('quantidade')),
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

        // Gráfico de Orçamentos
        const ctxOrcamentos = document.getElementById('graficoOrcamentos').getContext('2d');
        const chartOrcamentos = new Chart(ctxOrcamentos, {
            type: 'doughnut',
            data: {
                labels: ['Abertos', 'Finalizados'],
                datasets: [{
                    label: 'Orçamentos',
                    data: [{{ $orcamentosAbertos }}, {{ $orcamentosFinalizados }}],
                    backgroundColor: [
                        'rgba(28, 232, 106, 0.7)', 
                        'rgba(19, 85, 51, 0.7)'
                    ],
                    borderColor: [
                        'rgba(28, 232, 106, 0.7)', 
                        'rgba(19, 85, 51, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection