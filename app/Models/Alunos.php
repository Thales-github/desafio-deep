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

    public function setNomeAttribute($nome)
    {
        $this->attributes['nome'] = $nome ? mb_convert_case(trim($nome), MB_CASE_UPPER, 'UTF-8') : null;
    }

    public function setDocumentoUnicoAttribute($documentoUnico)
    {
        $this->attributes['documento_unico'] = $documentoUnico ? strtoupper(preg_replace('/[^0-9]/', '', $documentoUnico)) : null;
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = $email ? mb_convert_case(trim($email), MB_CASE_UPPER, 'UTF-8') : null;
    }

    public function setCepAttribute($cep)
    {
        $this->attributes['cep'] = $cep ? preg_replace('/[^0-9]/', '', $cep) : null;
    }

    public function setTelefoneAttribute($telefone)
    {
        $this->attributes['telefone'] = $telefone ? preg_replace('/[^0-9]/', '', $telefone) : null;
    }

    public function setLogradouroAttribute($logradouro)
    {
        $this->attributes['logradouro'] = $logradouro ? mb_convert_case(trim($logradouro), MB_CASE_UPPER, 'UTF-8') : null;
    }

    public function setBairroAttribute($bairro)
    {
        $this->attributes['bairro'] = $bairro ? mb_convert_case(trim($bairro), MB_CASE_UPPER, 'UTF-8') : null;
    }

    public function setUfAttribute($uf)
    {
        $this->attributes['uf'] = $uf ? strtoupper(trim($uf)) : null;
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
            'documento_unico',
            'email',
            'ativo',
            'telefone',
            'uf',
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
