<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Alunos extends Model
{

    protected $fillable = [
        "nome",
        "documento_unico",
        "email",
        "data_nascimento",
        "ativo",
        "telefone",
        "cep",
        "logradouro",
        "bairro",
        "uf",
    ];

    /**
     * Cadastra um novo aluno
     */
    public function cadastrar(array $dados): self
    {
        return self::create($dados);
    }

    /**
     * Retorna aluno por ID ou lança exception
     */
    public function detalhar(int $id): self
    {
        return self::findOrFail($id);
    }

    /**
     * Atualiza dados do aluno
     */
    public function atualizar(array $dados): bool
    {
        return $this->update($dados);
    }
}
