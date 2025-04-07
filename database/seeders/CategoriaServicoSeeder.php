<?php

namespace Database\Seeders;

use App\Models\CategoriaServico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaServico::create(["nome" => 'Conserto de Microondas']);
        CategoriaServico::create(["nome" => 'Conserto de TVs']);
        CategoriaServico::create(["nome" => 'Consertos gerais']);
        CategoriaServico::create(["nome" => 'Serviços Técnicos']);
        CategoriaServico::create(["nome" => 'Manutenção']);
    }
}
