<?php

namespace App\Http\Requests\Disciplina;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisciplinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:100|unique:disciplinas,nome',
            'descricao' => 'nullable|string|max:500',
            'professor_id' => 'required|integer|exists:professores,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'nome é obrigatório.',
            'nome.string' => 'nome inválido.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',
            'nome.unique' => 'Já existe uma disciplina com este nome.',
            'descricao.string' => 'descrição inválida.',
            'descricao.max' => 'descrição deve ter no máximo :max caracteres.',
            'professor_id.required' => 'ID do professor é obrigatório.',
            'professor_id.integer' => 'ID do professor inválido.',
            'professor_id.exists' => 'ID do professor não encontrado.',
        ];
    }
}
