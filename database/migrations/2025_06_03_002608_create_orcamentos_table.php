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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->foreignId('servico_id')->constrained('servicos');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('status_id')->constrained('status_orcamentos')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
