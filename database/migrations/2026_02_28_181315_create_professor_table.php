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
        Schema::create('professor', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->string('documento_unico', 100)->nullable(false)->unique();
            $table->date('data_nascimento')->nullable(false);
            
            // campos que deixei opcionais
            $table->string('telefone', 15)->nullable();
            $table->tinyInteger('nivel_formacao')
                ->default(0)
                ->comment("0: graduação, 1: pós-graduação, 2: mestrado, 3: doutorado");
            $table->tinyInteger('ativo')
                ->default(0)
                ->comment("0: inativo, 1: ativo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor');
    }
};
