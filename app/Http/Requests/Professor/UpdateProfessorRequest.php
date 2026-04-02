<?php

namespace App\Http\Requests\Professor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfessorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $documentoUnico = $this->input('documento_unico');
        $telefone = $this->input('telefone');

        $documentoUnicoNumerico = $documentoUnico === null ? null : preg_replace('/\D+/', '', (string) $documentoUnico);
        $telefoneNumerico = $telefone === null ? null : preg_replace('/\D+/', '', (string) $telefone);

        $this->merge([
            'documento_unico' => $documentoUnicoNumerico === '' ? null : $documentoUnicoNumerico,
            'telefone' => $telefoneNumerico === '' ? null : $telefoneNumerico,
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nome' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('professores', 'email')->ignore($id),
            ],
            'documento_unico' => [
                'required',
                'digits:11',
                Rule::unique('professores', 'documento_unico')->ignore($id),
            ],
            'data_nascimento' => 'required|date|before:today',
            'telefone' => 'nullable|digits_between:10,11',
            'nivel_formacao' => 'integer|in:0,1,2,3',
            'ativo' => 'integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'documento_unico.required' => 'CPF é obrigatório.',
            'documento_unico.unique' => 'CPF inválido.',
            'documento_unico.digits' => 'CPF deve ter 11 dígitos.',
            'email.required' => 'email é obrigatório.',
            'email.unique' => 'E-mail já cadastrado.',
            'email.email' => 'email inválido.',
            'email.max' => 'email deve ter no máximo :max caracteres.',
            'nome.required' => 'nome é obrigatório.',
            'nome.string' => 'nome inválido.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',
            'data_nascimento.required' => 'data_nascimento é obrigatória.',
            'data_nascimento.date' => 'data_nascimento inválida.',
            'data_nascimento.before' => 'Você deve ter pelo menos 16 anos para se cadastrar.',
            'telefone.digits_between' => 'telefone inválido.',
            'nivel_formacao.integer' => 'nivel_formacao inválido.',
            'nivel_formacao.in' => 'nivel_formacao inválido.',
            'ativo.integer' => 'ativo inválido.',
            'ativo.in' => 'ativo inválido.',
        ];
    }
}
