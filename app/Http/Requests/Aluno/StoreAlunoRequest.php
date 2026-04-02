<?php

namespace App\Http\Requests\Aluno;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normaliza CPF, telefone e CEP antes das regras (máscaras → só dígitos).
     * Vale para rotas HTTP e para requisições sintéticas (ex.: ApiService).
     */
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'nome' => 'required|string|max:255',
            'documento_unico' => 'required|digits:11|unique:alunos,documento_unico',
            'email' => 'required|email|unique:alunos,email',
            'data_nascimento' => 'required|date|before:today',
            'ativo' => 'required|integer|in:0,1',
            'telefone' => 'required|digits_between:10,11',
            'cep' => 'nullable|digits:8',
            'logradouro' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'uf' => 'nullable|string|size:2'
        ];

    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Documento único
            'documento_unico.required' => 'CPF é obrigatório.',
            'documento_unico.unique' => 'CPF inválido.', // por segurança não divulgar existência de CPF
            'documento_unico.digits' => 'CPF deve ter 11 dígitos.',

            // Email
            'email.required' => 'email é obrigatório.',
            'email.unique' => 'E-mail já cadastrado.',
            'email.email' => 'email inválido.',

            // Nome
            'nome.required' => 'nome é obrigatório.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',

            // Data nascimento
            'data_nascimento.required' => 'data_nascimento é obrigatória.',
            'data_nascimento.before' => 'Você deve ter pelo menos 16 anos para se cadastrar.',

            // CEP
            'cep.digits' => 'cep deve ter 8 dígitos.',

            // Telefone
            'telefone.required' => 'telefone é obrigatório.',
            'telefone.digits_between' => 'telefone inválido.',

            // Ativo
            'ativo.required' => 'status é obrigatório.',
            'ativo.in' => 'status inválido.',
            'ativo.integer' => 'status inválido.',

            // UF
            'uf.size' => 'uf deve ter 2 caracteres.'
        ];
    }
}
