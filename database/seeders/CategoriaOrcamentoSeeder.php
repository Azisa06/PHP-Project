<?php

namespace Database\Seeders;

use App\Models\CategoriaOrcamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaOrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaOrcamento::create(["nome" => 'Categoria3']);
        CategoriaOrcamento::create(["nome" => 'Categoria4']);
    }
}
