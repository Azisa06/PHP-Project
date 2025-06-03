<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(CategoriaProdutoSeeder::class);
        $this->call(CategoriaServicoSeeder::class);
        $this->call(CategoriaFuncionarioSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StatusOrcamentoSeeder::class);
    }
}
