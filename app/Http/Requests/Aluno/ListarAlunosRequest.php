<?php

namespace App\Http\Requests\Aluno;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Requisição de listagem (sem campos de corpo); mantém o mesmo fluxo de FormRequest que as demais ações da API.
 */
class ListarAlunosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
