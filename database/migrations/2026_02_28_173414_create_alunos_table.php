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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nome')->nullable(false);
            $table->string('documento_unico', 11)->unique()->nullable(false);
            $table->string('email', 100)->unique()->nullable(false);
            $table->date('data_nascimento')->nullable(false);

            // campos que deixei opcionais, pode ocorrer de não possui todos os dados de início
            $table->tinyInteger('ativo')
                ->default(0)
                ->comment("0: inativo, 1: ativo");
            $table->string('telefone', 15)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('logradouro', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('uf', 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
