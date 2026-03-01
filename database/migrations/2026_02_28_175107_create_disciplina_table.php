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
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nome', 100)->nullable(false)->unique();
            $table->string('descricao', 500)->nullable();
             // Chaves estrangeiras
            $table->foreignId('professor_id')
                ->constrained('professores');
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
