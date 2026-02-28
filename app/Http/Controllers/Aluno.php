<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno as AlunoModel;
use Illuminate\Http\JsonResponse;
use App\Validacoes\Validacoes;

class Aluno extends Controller
{

    public function listar(Request $request) {}

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

    public function cadastrar(Request $request): JsonResponse
    {
        $validacoes = new Validacoes();

        try {
            $dadosValidos = $request->validate($this->gerarVetorValidacaoDeAluno());

            $aluno = AlunoModel::cadastrar($dadosValidos);

            return response()->json($validacoes->gerarRetornoHttp(201, 'Aluno cadastrado com sucesso', $aluno));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Erro de validação', 'erros' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json($validacoes->gerarRetornoHttp(400, 'Erro ao cadastrar aluno', ['erro' => $e->getMessage()]));
        }
    }

    public function atualizar(Request $request, int $id)
    {

        $validacoes = new Validacoes();

        try {

            $aluno = AlunoModel::detalhar($id);

            $regras = $this->gerarVetorValidacaoDeAluno(true);

            $dadosValidados = $request->validate($regras);

            $aluno->atualizar($dadosValidados);

            return response()->json($validacoes->gerarRetornoHttp(
                200,
                'Dados atualizados com sucesso',
                $aluno
            ));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    422,
                    'Erro de validação',
                    ['erros' => $e->errors()]
                )
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json($validacoes->gerarRetornoHttp(
                404,
                'Aluno não encontrado'
            ));
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao atualizar aluno')
            );
        }
    }
}
