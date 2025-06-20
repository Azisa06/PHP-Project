<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); //PRIMARY KEY AUTO_INCREMENT
            $table->string('nome', 100); //VARCHAR(100)
            $table->bigInteger('cpf');
            $table->string('endereco', 100);
            $table->bigInteger('celular');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            Schema::dropIfExists('clientes');
        });
    }
};
