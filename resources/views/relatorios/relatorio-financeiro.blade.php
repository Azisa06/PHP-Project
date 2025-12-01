<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Relatório Financeiro' }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; margin: 20px; 
        }
        .logo-container { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .titulo { 
            text-align: center; 
            font-size: 16px; 
            font-weight: bold; 
            margin-bottom: 5px; 
        }
        .subtitulo-periodo { 
            text-align: center; 
            font-size: 12px; 
            margin-bottom: 20px; 
            color: #333; 
        }
        .tabela { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .tabela th, .tabela td { 
            border: 1px solid #ccc; 
            padding: 6px 8px; 
            text-align: left; 
        }
        .tabela th { 
            background-color: #f0f0f0; 
            font-weight: bold; 
        }
        .footer { 
            position: fixed; 
            bottom: 20px; 
            text-align: center; 
            width: 100%; 
            font-size: 9px; 
            color: #555; 
            left: 0; 
        }
        .text-right { 
            text-align: right; 
        }
        .text-bold { 
            font-weight: bold; 
        }
        
        .resumo { 
            border: 1px solid #aaa; 
            background-color: #f9f9f9; 
            padding: 15px; 
            margin-bottom: 25px; 
        }
        .resumo-titulo {
             font-size: 14px; 
             font-weight: bold; 
             margin-bottom: 10px; 
             border-bottom: 1px solid #ccc; 
             padding-bottom: 5px; 
            }
        .resumo-linha { 
            display: block; 
            font-size: 13px; 
            margin-bottom: 5px; 
        }
        .resumo-valor { 
            float: right; 
            font-weight: bold; 
        }
        .receita { 
            color: #28a745; 
        }
        .despesa { 
            color: #dc3545; 
        }
        .balanco-positivo { 
            color: #0056b3; 
            font-size: 14px !important; 
        }
        .balanco-negativo { 
            color: #dc3545; 
            font-size: 14px !important; 
        }

        .section-titulo { 
            font-size: 13px; 
            font-weight: bold; 
            margin-top: 20px; 
            margin-bottom: 5px; 
        }
        .total-categoria { 
            text-align: right; 
            font-weight: bold; 
            font-size: 12px; 
            margin-top: 5px; 
            padding: 5px; 
            background-color: #f5f5f5; 
        }
        .no-data { 
            text-align: center; 
            padding: 10px; 
            color: #777; 
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="{{ public_path('img/logoshock.png') }}" alt="Logo" style="height:50px;">
    </div>
    <div class="titulo">{{ $titulo }}</div>
    <div class="subtitulo-periodo">
        Período:
        @if($periodo === 'dia')
            {{ $dataReferencia->format('d/m/Y') }}
        
        @elseif($periodo === 'mes')
            {{ $dataReferencia->format('m/Y') }}

        @elseif($periodo === 'semanal' && isset($inicioSemana) && isset($fimSemana))
            {{ $inicioSemana->format('d/m/Y') }} até {{ $fimSemana->format('d/m/Y') }}
        
        @endif
    </div>

    <div class="resumo">
        <div class="resumo-titulo">Resumo do Período</div>
        <div class="resumo-linha">
            Total de Receitas: 
            <span class="resumo-valor receita">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</span>
        </div>
        <div class="resumo-linha">
            Total de Despesas: 
            <span class="resumo-valor despesa">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</span>
        </div>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">
        <div class="resumo-linha">
            <strong>Balanço (Lucro/Prejuízo):</strong>
            <span class="resumo-valor {{ $balanco >= 0 ? 'balanco-positivo' : 'balanco-negativo' }}">
                R$ {{ number_format($balanco, 2, ',', '.') }}
            </span>
        </div>
    </div>

    <div class="section-titulo">Detalhamento das Receitas</div>
    
    <span class="text-bold">Vendas de Produtos</span>
    @if($vendas->isEmpty())
        <div class="no-data">Nenhuma venda no período.</div>
    @else
        <table class="tabela">
            <thead>
                <tr>
                    <th>ID Venda</th>
                    <th>Data</th>
                    <th class="text-right">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                <tr>
                    <td>{{ $venda->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y') }}</td>
                    <td class="text-right">R$ {{ number_format($venda->preco_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="total-categoria">Subtotal Vendas: R$ {{ number_format($totalReceitasVendas, 2, ',', '.') }}</div>

    <span class="text-bold" style="margin-top: 15px; display:inline-block;">Consertos Finalizados</span>
    @if($consertos->isEmpty())
         <div class="no-data">Nenhum conserto finalizado no período.</div>
    @else
        <table class="tabela">
            <thead>
                <tr>
                    <th>ID Orçamento</th>
                    <th>Cliente</th>
                    <th>Data Finalização</th>
                    <th class="text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consertos as $conserto)
                <tr>
                    <td>{{ $conserto->id }}</td>
                    <td>{{ $conserto->cliente->nome ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($conserto->updated_at)->format('d/m/Y H:i') }}</td>
                    <td class="text-right">R$ {{ number_format($conserto->preco, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="total-categoria">Subtotal Consertos: R$ {{ number_format($totalReceitasConsertos, 2, ',', '.') }}</div>


    <div class="section-titulo" style="margin-top: 25px;">Detalhamento das Despesas</div>

    <span class="text-bold">Compras de Estoque</span>
    @if($compras->isEmpty())
        <div class="no-data">Nenhuma compra no período.</div>
    @else
        <table class="tabela">
             <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Data</th>
                    <th class="text-right">Valor Total</th>
                </tr>
            </thead>
             <tbody>
                @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($compra->data_compra)->format('d/m/Y') }}</td>
                    <td class="text-right">R$ {{ number_format($compra->total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="total-categoria">Subtotal Compras: R$ {{ number_format($totalDespesasCompras, 2, ',', '.') }}</div>


    <div class="footer">
        Relatório gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>