<?php

namespace App\Http\Requests\Matricula;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListarMatriculasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $colunasOrdenacao = ['created_at', 'updated_at', 'data_matricula', 'aluno_id', 'disciplina_id', 'id', 'status'];

        return [
            'aluno_id' => 'sometimes|nullable|integer|exists:alunos,id',
            'disciplina_id' => 'sometimes|nullable|integer|exists:disciplinas,id',
            'status' => 'sometimes|nullable|integer|in:1,2,3,4',
            'data_inicio' => 'sometimes|nullable|date',
            'data_fim' => 'sometimes|nullable|date',
            'ordenacao' => ['sometimes', 'nullable', 'string', Rule::in($colunasOrdenacao)],
            'direcao' => 'sometimes|nullable|string|in:asc,desc',
            'por_pagina' => 'sometimes|nullable|integer|min:1|max:200',
        ];
    }
}
