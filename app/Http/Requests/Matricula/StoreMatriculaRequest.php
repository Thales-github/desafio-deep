<?php

namespace App\Http\Requests\Matricula;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMatriculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'disciplina_id' => 'required|integer|exists:disciplinas,id',
            'aluno_id' => [
                'required',
                'integer',
                'exists:alunos,id',
                Rule::unique('alunos_disciplinas', 'aluno_id')->where(
                    fn ($q) => $q->where('disciplina_id', $this->input('disciplina_id'))
                ),
            ],
            'data_matricula' => 'nullable|date',
            'status' => 'nullable|integer|in:1,2,3,4',
            'nota_final' => 'nullable|numeric|min:0|max:10',
            'faltas' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'aluno_id.required' => 'ID do aluno é obrigatório.',
            'aluno_id.integer' => 'ID do aluno inválido.',
            'aluno_id.exists' => 'Aluno não encontrado.',
            'aluno_id.unique' => 'Aluno já matriculado nesta disciplina.',
            'disciplina_id.required' => 'ID da disciplina é obrigatório.',
            'disciplina_id.integer' => 'ID da disciplina inválido.',
            'disciplina_id.exists' => 'Disciplina não encontrada.',
            'data_matricula.date' => 'Data de matrícula inválida.',
            'status.integer' => 'Status inválido.',
            'status.in' => 'Status deve ser: 1 (cursando), 2 (aprovado), 3 (reprovado) ou 4 (trancado).',
            'nota_final.numeric' => 'Nota final deve ser um número.',
            'nota_final.min' => 'Nota final não pode ser menor que 0.',
            'nota_final.max' => 'Nota final não pode ser maior que 10.',
            'faltas.integer' => 'Faltas deve ser um número inteiro.',
            'faltas.min' => 'Faltas não pode ser negativa.',
        ];
    }
}
