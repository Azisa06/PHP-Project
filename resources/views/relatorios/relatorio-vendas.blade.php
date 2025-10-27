<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Relatório de Vendas' }}</title>
    {{-- Estilos iguais ao relatório de estoque --}}
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; 
            margin: 20px; 
        }
        .logo-container { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .titulo { 
            text-align: center; 
            font-size: 16px; 
            font-weight: bold; 
            margin-bottom: 15px; 
        }
        .tabela { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        .tabela th, .tabela td { 
            border: 1px solid #ccc; 
            padding: 5px 8px; 
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
        .total { 
            font-weight: bold; 
            font-size: 13px; 
            text-align: right; 
            margin-top: 10px; 
        }
        .subtitulo { 
            font-size: 12px; 
            margin-bottom: 10px; 
        }
        .text-right { 
            text-align: right; 
        }
        .produto-lista { 
            list-style: none; 
            padding-left: 0; 
            margin: 0; 
        }
        .produto-lista li { 
            margin-bottom: 2px; 
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="{{ public_path('img/logoshock.png') }}" alt="Logo do sistema" style="height:50px;">
    </div>
    <div class="titulo">{{ $titulo }}</div>
    <div class="subtitulo">
        Período:
        @if($periodo === 'dia')
            {{ $dataReferencia->format('d/m/Y') }}
        
        @elseif($periodo === 'mes')
            {{ $dataReferencia->format('m/Y') }}

        @elseif($periodo === 'semanal' && isset($inicioSemana) && isset($fimSemana))
            {{ $inicioSemana->format('d/m/Y') }} até {{ $fimSemana->format('d/m/Y') }}
        
        @endif
    </div>

    @if($vendas->isEmpty())
        <p>Nenhuma venda registrada para este período.</p>
    @else
        <table class="tabela">
            <thead>
                <tr>
                    <th>ID Venda</th>
                    <th>Data</th>
                    <th>Produtos</th>
                    <th>Qtd</th>
                    <th>Preço Unit.</th>
                    <th>Subtotal Item</th>
                    <th>Total Venda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                    @php $primeiroItem = true; @endphp
                    @foreach($venda->itens as $item)
                        <tr>
                            @if($primeiroItem)
                                <td rowspan="{{ $venda->itens->count() }}">{{ $venda->id }}</td>
                                <td rowspan="{{ $venda->itens->count() }}">{{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y') }}</td>
                            @endif
                            <td>{{ $item->produto->nome ?? 'N/A' }}</td>
                            <td>{{ $item->quantidade }}</td>
                            <td class="text-right">R$ {{ number_format($item->preco_venda, 2, ',', '.') }}</td>
                            <td class="text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                            @if($primeiroItem)
                                <td class="text-right" rowspan="{{ $venda->itens->count() }}">
                                    <b>R$ {{ number_format($venda->preco_total, 2, ',', '.') }}</b>
                                </td>
                                @php $primeiroItem = false; @endphp
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="total">
            Total Geral das Vendas no Período: R$ {{ number_format($totalGeralVendas, 2, ',', '.') }}
        </div>
    @endif

    <div class="footer">
        Relatório gerado em {{ \Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i') }}
    </div>
</body>
</html>