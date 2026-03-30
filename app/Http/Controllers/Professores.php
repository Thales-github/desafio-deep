<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validacoes\Validacoes;
use Illuminate\Http\JsonResponse;
use App\Models\Professores as ProfessoresModel;

class Professores extends Controller
{
    private function normalizarEntradaProfessor(Request $request): void
    {
        $documentoUnico = $request->input('documento_unico');
        $telefone = $request->input('telefone');

        $documentoUnicoNumerico = $documentoUnico === null ? null : preg_replace('/\D+/', '', (string) $documentoUnico);
        $telefoneNumerico = $telefone === null ? null : preg_replace('/\D+/', '', (string) $telefone);

        $request->merge([
            'documento_unico' => $documentoUnicoNumerico === '' ? null : $documentoUnicoNumerico,
            'telefone' => $telefoneNumerico === '' ? null : $telefoneNumerico,
        ]);
    }

    private function gerarVetorValidacaoDeProfessor(bool $atualizar = false): array
    {

        $validacoesDeProfessor = [
            'nome' => 'required|string|max:100',
            'email' => 'required|email|unique:professores,email|max:100',
            'documento_unico' => 'required|digits:11|unique:professores,documento_unico',
            'data_nascimento' => 'required|date|before:today',
            'telefone' => 'nullable|digits_between:10,11',
            'nivel_formacao' => 'integer|in:0,1,2,3',
            'ativo' => 'integer|in:0,1'
        ];

        if ($atualizar) {
            $validacoesDeProfessor['documento_unico'] = 'required|digits:11|unique:professores,documento_unico,' . request()->route('id');
            $validacoesDeProfessor['email'] = 'required|email|unique:professores,email,' . request()->route('id');
        }

        return $validacoesDeProfessor;
    }

    // Personalizando as mensagens de erro para campos obrigatórios
    private function vetorMensagemCamposInvalidos(): array
    {

        return [
            // documento único
            'documento_unico.required' => 'CPF é obrigatório.',
            'documento_unico.unique' => 'CPF inválido.', // por segurança não divulgar existência de CPF
            'documento_unico.digits' => 'CPF deve ter 11 dígitos.',
            // email
            'email.required' => 'email é obrigatório.',
            'email.unique' => 'E-mail já cadastrado.',
            'email.email' => 'email inválido.',
            'email.max' => 'email deve ter no máximo :max caracteres.',
            // nome
            'nome.required' => 'nome é obrigatório.',
            'nome.string' => 'nome inválido.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',
            // data nascimento
            'data_nascimento.required' => 'data_nascimento é obrigatória.',
            'data_nascimento.date' => 'data_nascimento inválida.',
            'data_nascimento.before' => 'Você deve ter pelo menos 16 anos para se cadastrar.',
            // telefone
            'telefone.digits_between' => 'telefone inválido.',
            // nivel_formacao
            'nivel_formacao.integer' => 'nivel_formacao inválido.',
            'nivel_formacao.in' => 'nivel_formacao inválido.', // Segurança: não revela valores
            'nivel_formacao.min' => 'nivel_formacao inválido.',
            'nivel_formacao.max' => 'nivel_formacao inválido.',
            // ativo
            'ativo.integer' => 'ativo inválido.',
            'ativo.in' => 'ativo inválido.', // Segurança: não revela valores
            'ativo.boolean' => 'ativo inválido.',
        ];
    }

    public function cadastrar(Request $request): JsonResponse
    {

        $validacoes = new Validacoes();
        $professoresModel = new ProfessoresModel();

        try {
            $this->normalizarEntradaProfessor($request);

            $dadosValidos = $request->validate(
                $this->gerarVetorValidacaoDeProfessor(),
                $this->vetorMensagemCamposInvalidos()
            );

            $professor = $professoresModel->cadastrar($dadosValidos);

            return response()->json($validacoes->gerarRetornoHttp(201, 'Professor cadastrado com sucesso', $professor));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()]));
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao cadastrar professor', ['erros' => $e->getMessage()])
            );
        }
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {

        $validacoes = new Validacoes();
        $professoresModel = new ProfessoresModel();

        try {
            $this->normalizarEntradaProfessor($request);

            $professor = $professoresModel->detalhar($id);

            $regras = $this->gerarVetorValidacaoDeProfessor(true);

            $dadosValidados = $request->validate($regras, $this->vetorMensagemCamposInvalidos());

            $professor->atualizar($dadosValidados);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Dados atualizados com sucesso', $professor)
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()])
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Professor não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao atualizar professor')
            );
        }
    }

    public function listar(Request $request): JsonResponse
    {

        $professoresModel = new ProfessoresModel();
        $validacoes = new Validacoes();

        try {

            $professors = $professoresModel->listar();

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $professors)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao listar professors')
            );
        }
    }

    public function apagar(int $id): JsonResponse
    {

        $professoresModel = new ProfessoresModel();
        $validacoes = new Validacoes();

        try {

            $professor = $professoresModel->detalhar($id);

            $professoresModel->apagar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Professor apagado com sucesso')
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Professor não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao apagar professor')
            );
        }
    }

    public function detalhar(int $id): JsonResponse
    {

        $professoresModel = new ProfessoresModel();
        $validacoes = new Validacoes();

        try {

            $professor = $professoresModel->detalhar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $professor)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Professor não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao buscar professor')
            );
        }
    }
}
