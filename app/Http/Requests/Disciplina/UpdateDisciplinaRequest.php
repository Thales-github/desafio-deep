<?php

namespace App\Http\Requests\Disciplina;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDisciplinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('disciplinas', 'nome')->ignore($id),
            ],
            'descricao' => 'nullable|string|max:500',
            'professor_id' => 'required|integer|exists:professores,id',
        ];
    }

    public function messages(): array
    {
        return (new StoreDisciplinaRequest)->messages();
    }
}
