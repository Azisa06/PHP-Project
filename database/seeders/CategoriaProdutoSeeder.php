<?php

namespace Database\Seeders;

use App\Models\CategoriaProduto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaProduto::create(["nome" => 'Ferramentas']);
        CategoriaProduto::create(['nome' => 'Componentes Eletrônicos']);
        CategoriaProduto::create(['nome' => 'Dispositivos e Acessórios']);
        CategoriaProduto::create(['nome' => 'Informática e Periféricos']);
        CategoriaProduto::create(['nome' => 'Eletrônicos gerais']);
        CategoriaProduto::create(['nome' => 'Outros']);
    }
}
