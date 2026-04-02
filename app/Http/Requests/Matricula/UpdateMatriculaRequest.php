<?php

namespace App\Http\Requests\Matricula;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatriculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'aluno_id' => 'required|integer|exists:alunos,id',
            'disciplina_id' => 'required|integer|exists:disciplinas,id',
            'data_matricula' => 'nullable|date',
            'status' => 'nullable|integer|in:1,2,3,4',
            'nota_final' => 'nullable|numeric|min:0|max:10',
            'faltas' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return (new StoreMatriculaRequest)->messages();
    }
}
