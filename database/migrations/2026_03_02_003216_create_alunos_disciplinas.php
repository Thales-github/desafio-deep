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
        Schema::create('alunos_disciplinas', function (Blueprint $table) {

            // Chave primária
            $table->id();

            // Chaves estrangeiras
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade');

            $table->foreignId('disciplina_id')
                ->constrained('disciplinas')
                ->onDelete('cascade');

            $table->date('data_matricula')->nullable();
            $table->tinyInteger('status')
                ->default(1)
                ->comment('1:cursando, 2:aprovado, 3:reprovado, 4:trancado');

            $table->decimal('nota_final', 3, 1)->nullable();
            $table->integer('faltas')->nullable();

            $table->timestamps();

            // Índices compostos para buscas eficientes
            $table->index(['aluno_id', 'disciplina_id']);
            $table->index('status');

            // Garantir que um aluno não seja matriculado duas vezes na mesma disciplina
            $table->unique(['aluno_id', 'disciplina_id'], 'alunos_disciplinas_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos_disciplinas');
    }
};
