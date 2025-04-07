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
        CategoriaServico::create(["nome" => 'Categoria3']);
        CategoriaServico::create(["nome" => 'Categoria4']);
    }
}
