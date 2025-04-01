# Sistema de Loja - Eletiva II

## Integrantes
- Isabella Thomazini
- Isabelle Cabriotti

## Descrição
Este é um sistema de gerenciamento para uma loja, desenvolvido para a disciplina Eletiva II. O sistema foi criado utilizando PHP e Laravel, e tem como objetivo facilitar o controle de produtos, clientes, serviços e funcionários, além de permitir a realização de orçamentos, consertos e compras, bem como a emissão de relatórios de estoque.

## Tecnologias Utilizadas
- **Linguagem:** PHP
- **Framework:** Laravel
- **Banco de Dados:** MySQL
- **Outras Tecnologias:** HTML, CSS, JavaScript

## Funcionalidades
### Funções Básicas
- **Gerenciar Produtos**: Incluir, excluir, alterar e pesquisar produtos.
- **Gerenciar Clientes**: Incluir, excluir, alterar e pesquisar clientes.
- **Gerenciar Serviços**: Incluir, excluir, alterar e pesquisar serviços.
- **Gerenciar Funcionários**: Incluir, excluir, alterar e pesquisar funcionários.

### Funções Fundamentais
- **Realizar Orçamento**: Criar e registrar orçamentos de conserto, incluindo valores e aprovação do cliente.
- **Realizar Conserto**: Gerenciar a fila de consertos, garantindo que apenas orçamentos aprovados e pagos avancem.
- **Realizar Compra**: Registrar compras de peças tanto para conserto quanto para venda no varejo.

### Funções de Saída
- **Emitir Relatório de Estoque**: Gerar um relatório detalhado dos produtos em estoque, suas quantidades e valores.

## Como Executar o Projeto
1. Clone este repositório:
   ```sh
   git clone https://github.com/seu-repositorio.git
   ```
2. Instale as dependências do Laravel:
   ```sh
   composer install
   ```
3. Configure o arquivo **.env** com as credenciais do banco de dados.
4. Gere a chave da aplicação:
   ```sh
   php artisan key:generate
   ```
5. Execute as migrações do banco de dados:
   ```sh
   php artisan migrate
   ```
6. Inicie o servidor local:
   ```sh
   php artisan serve
   ```
7. Acesse o sistema via navegador em `http://localhost:8000`.

## Contato
Para mais informações, entre em contato com os desenvolvedores.

---
Este projeto faz parte da disciplina Eletiva II, do curso de ADS da Fatec de Presidente Prudente.