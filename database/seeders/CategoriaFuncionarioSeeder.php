<?php

namespace Database\Seeders;

use App\Models\CategoriaFuncionario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaFuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaFuncionario::create(["nome" => 'Administrador']);
        CategoriaFuncionario::create(["nome" => 'Atendente']);
        CategoriaFuncionario::create(["nome" => 'técnico']);
        CategoriaFuncionario::create(["nome" => 'Geral']);
    }
}
