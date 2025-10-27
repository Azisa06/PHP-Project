<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Relatório de Consertos' }}</title>
     {{-- Estilos iguais aos outros relatórios --}}
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

    @if($consertos->isEmpty())
        <p>Nenhum conserto finalizado registrado para este período.</p>
    @else
        <table class="tabela">
            <thead>
                <tr>
                    <th>ID Orçamento</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Data Finalização</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consertos as $conserto)
                    <tr>
                        <td>{{ $conserto->id }}</td>
                        <td>{{ $conserto->cliente->nome ?? 'N/A' }}</td>
                        <td>{{ $conserto->servico->nome ?? 'N/A' }}</td>
                        <td>{{ $conserto->descricao ?? '-' }}</td>
                        <td class="text-right">R$ {{ number_format($conserto->preco, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($conserto->updated_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <div class="total">
            Total Geral dos Consertos no Período: R$ {{ number_format($totalGeralConsertos, 2, ',', '.') }}
        </div>
    @endif

    <div class="footer">
        Relatório gerado em {{ \Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i') }}
    </div>
</body>
</html>