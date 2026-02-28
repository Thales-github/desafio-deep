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
        Schema::create('disciplina', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nome', 100)->nullable(false)->unique();
            
            $table->foreignId('disciplina_id')
                ->constrained('disciplinas')
                ->onDelete('cascade'); // Se disciplina for deletada, matrículas também são
            $table->string('descricao', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplina');
    }
};
