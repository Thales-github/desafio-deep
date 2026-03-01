<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professores extends Model
{
    protected $fillable = [
        "nome",
        "email",
        "documento_unico",
        "data_nascimento",
        "telefone",
        "nivel_formacao",
        "ativo",
    ];

    public function setNomeAttribute($nome): void
    {
        $this->attributes['nome'] = $nome ? mb_convert_case(trim($nome), MB_CASE_UPPER, 'UTF-8') : null;
    }

    public function setEmailAttribute($email): void
    {
        $this->attributes['email'] = $email ? mb_convert_case(trim($email), MB_CASE_UPPER, 'UTF-8') : null;
    }

    public function setDocumentoUnicoAttribute($documentoUnico): void
    {
        $this->attributes['documento_unico'] = $documentoUnico ? strtoupper(preg_replace('/[^0-9]/', '', $documentoUnico)) : null;
    }

    public function cadastrar(array $dados): self
    {
        return self::create($dados);
    }

    public function listar()
    {

        return $this->all([
            'id',
            'nome',
            'email',
            'telefone',
            'nivel_formacao',
            'ativo',
        ]);
    }

    public function detalhar(int $id): self
    {
        return self::findOrFail($id);
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
