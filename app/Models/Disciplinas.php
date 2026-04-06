<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disciplinas extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'professor_id',
    ];

    public function setNomeAttribute($nome)
    {
        $this->attributes['nome'] = $nome ? mb_convert_case(trim($nome), MB_CASE_UPPER, 'UTF-8') : '';
    }

    public function setDescricaoAttribute($descricao)
    {
        $this->attributes['descricao'] = $descricao ? mb_convert_case(trim($descricao), MB_CASE_UPPER, 'UTF-8') : '';
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professores::class, 'professor_id');
    }

    public function cadastrar(array $dados): self
    {
        return self::create($dados);
    }

    public function listar()
    {
        return $this->with('professor')->get([
            'id',
            'nome',
            'descricao',
            'professor_id',
        ]);
    }

    public function detalhar(int $id): self
    {
        return self::with('professor')->findOrFail($id);
    }

    public function atualizar(array $dados): bool
    {
        return $this->update($dados);
    }

    public function apagar(int $id): bool
    {
        $aluno = $this->findOrFail($id);

        return $aluno->delete();
    }
}
