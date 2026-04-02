<?php

namespace App\Http\Requests\Aluno;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlunoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $documentoUnico = $this->input('documento_unico');
        $telefone = $this->input('telefone');
        $cep = $this->input('cep');

        $documentoUnicoNumerico = $documentoUnico === null ? null : preg_replace('/\D+/', '', (string) $documentoUnico);
        $telefoneNumerico = $telefone === null ? null : preg_replace('/\D+/', '', (string) $telefone);
        $cepNumerico = $cep === null ? null : preg_replace('/\D+/', '', (string) $cep);

        $this->merge([
            'documento_unico' => $documentoUnicoNumerico === '' ? null : $documentoUnicoNumerico,
            'telefone' => $telefoneNumerico === '' ? null : $telefoneNumerico,
            'cep' => $cepNumerico === '' ? null : $cepNumerico,
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nome' => 'required|string|max:255',
            'documento_unico' => [
                'required',
                'digits:11',
                Rule::unique('alunos', 'documento_unico')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('alunos', 'email')->ignore($id),
            ],
            'data_nascimento' => 'required|date|before:today',
            'ativo' => 'required|integer|in:0,1',
            'telefone' => 'required|digits_between:10,11',
            'cep' => 'nullable|digits:8',
            'logradouro' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'uf' => 'nullable|string|size:2',
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
            'nome.required' => 'nome é obrigatório.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',
            'data_nascimento.required' => 'data_nascimento é obrigatória.',
            'data_nascimento.before' => 'Você deve ter pelo menos 16 anos para se cadastrar.',
            'cep.digits' => 'cep deve ter 8 dígitos.',
            'telefone.required' => 'telefone é obrigatório.',
            'telefone.digits_between' => 'telefone inválido.',
            'ativo.required' => 'status é obrigatório.',
            'ativo.in' => 'status inválido.',
            'ativo.integer' => 'status inválido.',
            'uf.size' => 'uf deve ter 2 caracteres.',
        ];
    }
}
