<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alunos as AlunosModel;
use Illuminate\Http\JsonResponse;
use App\Validacoes\Validacoes;

class Alunos extends Controller
{

    private function gerarVetorValidacaoDeAluno(bool $atualizar = false): array
    {

        $validacoesDeAluno = [
            'nome' => 'required|string|max:255',
            'documento_unico' => 'required|string|unique:alunos,documento_unico',
            'email' => 'required|email|unique:alunos,email',
            'data_nascimento' => 'required|date|before:today',
            'cep' => 'nullable|string|size:8',
            'logradouro' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'uf' => 'nullable|string|size:2'
        ];

        if ($atualizar) {
            $validacoesDeAluno['documento_unico'] = 'required|string|unique:alunos,documento_unico,' . request()->route('id');
            $validacoesDeAluno['email'] = 'required|email|unique:alunos,email,' . request()->route('id');
        }

        return $validacoesDeAluno;
    }

    // Personalizando as mensagens de erro para campos obrigatórios
    private function vetorMensagemCamposInvalidos(): array
    {
        return [
            // Documento único
            'documento_unico.required' => 'documento_unico é obrigatório.',
            'documento_unico.unique' => 'documento_unico inválido.', // Segurança não pode revelar que já existe
            'documento_unico.string' => 'documento_unico inválido.',

            // Email
            'email.required' => 'email é obrigatório.',
            'email.unique' => 'email inválido.', // Segurança não pode revelar que já existe
            'email.email' => 'email inválido.',

            // Nome
            'nome.required' => 'nome é obrigatório.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',

            // Data nascimento
            'data_nascimento.required' => 'data_nascimento é obrigatória.',
            'data_nascimento.before' => 'Você deve ter pelo menos 16 anos para se cadastrar.',

            // CEP
            'cep.size' => 'cep deve ter 8 dígitos.',

            // UF
            'uf.size' => 'uf deve ter 2 caracteres.'
        ];
    }

    public function cadastrar(Request $request): JsonResponse
    {

        $validacoes = new Validacoes();
        $alunosModel = new AlunosModel();

        try {

            $dadosValidos = $request->validate(
                $this->gerarVetorValidacaoDeAluno(),
                $this->vetorMensagemCamposInvalidos()
            );

            $aluno = $alunosModel->cadastrar($dadosValidos);

            return response()->json($validacoes->gerarRetornoHttp(201, 'Aluno cadastrado com sucesso', $aluno));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()]));
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao cadastrar aluno', ['erros' => $e->getMessage()])
            );
        }
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {

        $validacoes = new Validacoes();
        $AlunosModel = new alunosModel();

        try {

            $aluno = $AlunosModel->detalhar($id);

            $regras = $this->gerarVetorValidacaoDeAluno(true);

            $dadosValidados = $request->validate($regras, $this->vetorMensagemCamposInvalidos());

            $aluno->atualizar($dadosValidados);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Dados atualizados com sucesso', $aluno)
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()])
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Aluno não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao atualizar aluno')
            );
        }
    }

    public function listar(Request $request): JsonResponse
    {

        $alunosModel = new AlunosModel();
        $validacoes = new Validacoes();

        try {

            $alunos = $alunosModel->listar();

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $alunos)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao listar alunos')
            );
        }
    }

    public function apagar(int $id): JsonResponse
    {

        $alunosModel = new AlunosModel();
        $validacoes = new Validacoes();

        try {

            $aluno = $alunosModel->detalhar($id);

            $alunosModel->apagar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Aluno apagado com sucesso')
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Aluno não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao apagar aluno')
            );
        }
    }

    public function detalhar(int $id): JsonResponse
    {

        $alunosModel = new AlunosModel();
        $validacoes = new Validacoes();

        try {

            $aluno = $alunosModel->detalhar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $aluno)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Aluno não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao buscar aluno')
            );
        }
    }
}
