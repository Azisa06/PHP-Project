<?php

namespace Database\Seeders;

use App\Models\StatusOrcamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusOrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusOrcamento::create(['id' => '1', 'nome' => 'Aguardando Análise', 'descricao' => 'Produto entregue, aguardando testes.']);
        StatusOrcamento::create(['id' => '2', 'nome' => 'Orçamento Pronto', 'descricao' => 'Orçamento finalizado e disponível.']);
        StatusOrcamento::create(['id' => '3', 'nome' => 'Aguardando Aprovação do Cliente', 'descricao' => 'Esperando aprovação do cliente.']);
        StatusOrcamento::create(['id' => '4', 'nome' => 'Aprovado / Aguardando Peças', 'descricao' => 'Orçamento aprovado / aguardando peças.']);
        StatusOrcamento::create(['id' => '5', 'nome' => 'Em Conserto', 'descricao' => 'Produto está sendo consertado.']);
        StatusOrcamento::create(['id' => '6', 'nome' => 'Conserto Finalizado', 'descricao' => 'Conserto finalizado, aguardando retirada.']);
        StatusOrcamento::create(['id' => '7', 'nome' => 'Orçamento Recusado', 'descricao' => 'Cliente recusou o orçamento.']);
        StatusOrcamento::create(['id' => '8', 'nome' => 'Cancelado', 'descricao' => 'Conserto foi cancelado.']);
    }
}
