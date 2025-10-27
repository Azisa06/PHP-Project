<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Protocolo de Orçamento - {{ $orcamento->id ?? '' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .titulo {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .tabela {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tabela th, .tabela td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
            vertical-align: top;
        }

        .tabela th {
            background-color: #f0f0f0;
        }

        .footer {
            position: absolute;
            bottom: 30px;
            text-align: center;
            width: 100%;
            font-size: 10px;
            color: #555;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .col {
            width: 48%;
        }

        .assinatura {
            margin-top: 60px;
        }

        .assinatura .box {
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        .assinatura .box:first-child {
            margin-bottom: 50px;
        }

        .assinatura-line {
            border-top: 1px solid #000;
            margin-bottom: 5px;
        }

        .muted {
            color: #666;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="logo-container">
        <img src="{{ public_path('img/logoshock.png') }}" alt="Logo do sistema" style="height:60px;">
    </div>

    <div class="titulo">Orçamento</div>

    <div class="row">
        <div class="col"><strong>Orçamento:</strong> {{ $orcamento->protocolo ?? $orcamento->id }}</div>
        <div class="col"><strong>Data:</strong> {{ \Carbon\Carbon::parse($orcamento->created_at ?? now())->format('d/m/Y H:i') }}</div>
    </div>

    <table class="tabela">
        <thead>
            <tr>
                <th colspan="2">Dados do Cliente</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Nome:</strong> {{ optional($orcamento->cliente)->nome ?? 'Não informado' }}</td>
                <td><strong>Telefone:</strong> {{ optional($orcamento->cliente)->celular ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Documento (CPF/CNPJ):</strong> {{ optional($orcamento->cliente)->cpf ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="tabela">
        <thead>
            <tr>
                <th colspan="2">Informações do Orçamento</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Serviço:</strong> {{ optional($orcamento->servico)->nome ?? 'Não informado' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Descrição:</strong><br>{!! nl2br(e($orcamento->descricao_problema ?? $orcamento->descricao ?? 'Não informada')) !!}</td>
            </tr>
            <tr>
                <td><strong>Valor do Serviço:</strong> R$ {{ number_format($orcamento->preco ?? $orcamento->preco_estimado ?? 0, 2, ',', '.') }}</td>
                <td><strong>Status:</strong> {{ $orcamento->statusOrcamento->nome ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="assinatura">
        <div class="box">
            <div class="assinatura-line"></div>
            Assinatura do Cliente
        </div>
        <div class="box">
            <div class="assinatura-line"></div>
            Aparelho Recebido por: {{ optional($orcamento->usuario)->name ?? ($orcamento->responsavel ?? Auth::user()->name ?? '-') }}
        </div>
    </div>

    <div style="margin-top:30px; font-size:11px;">
        <strong>Termos e Condições do Orçamento:</strong>
            <ol style="padding-left: 20px; margin-top: 5px;">
            <li>
                O cliente autoriza a análise técnica do equipamento para fins de diagnóstico e emissão deste orçamento.
            </li>
            <li>
                Os valores e prazos informados são <strong>estimados</strong> e podem sofrer alterações após a conclusão do diagnóstico técnico. Qualquer alteração será comunicada e só será executada após prévia autorização do cliente.
            </li>
            <li>
                Em caso de <strong>não aprovação</strong> do orçamento, poderá ser cobrada uma taxa de análise/orçamento referente ao serviço de diagnóstico (consultar valor com o atendente).
            </li>
            <li>
                O serviço executado e as peças substituídas possuem garantia de <strong>90 (noventa) dias</strong>, a contar da data de retirada. A garantia cobre exclusivamente o defeito reparado e não se aplica a novos defeitos, problemas de software, danos por mau uso, quedas ou líquidos.
            </li>
            <li>
                É de <strong>inteira responsabilidade do cliente</strong> a realização de cópias de segurança (backup) de seus dados e arquivos. A empresa não se responsabiliza por eventual perda de dados durante o processo de análise ou reparo.
            </li>
            <li>
                O equipamento deverá ser retirado no prazo máximo de <strong>30 (trinta) dias</strong> após a comunicação de conclusão do serviço. Após este prazo, será cobrada uma taxa diária de armazenamento. Equipamentos não retirados no prazo de 90 (noventa) dias serão considerados abandonados e poderão ser descartados para cobrir os custos do serviço.
            </li>
        </ol>
    </div>

    <div class="footer">
        Protocolo gerado em {{ \Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i') }}
    </div>

</body>
</html>