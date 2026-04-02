<?php

namespace App\Http\Controllers;

use App\Http\Requests\Aluno\ListarAlunosRequest;
use App\Http\Requests\Aluno\StoreAlunoRequest as AlunoStoreAlunoRequest;
use App\Http\Requests\Aluno\UpdateAlunoRequest;
use App\Models\Alunos as AlunosModel;
use Illuminate\Http\JsonResponse;
use App\Validacoes\Validacoes;

class Alunos extends Controller
{
    public function cadastrar(AlunoStoreAlunoRequest $request): JsonResponse
    {

        $validacoes = new Validacoes();
        $alunosModel = new AlunosModel();
        
        try {
            
            $dadosValidados = $request->validated();

            $aluno = $alunosModel->cadastrar($dadosValidados);

            return response()->json(
                $validacoes->gerarRetornoHttp(
                    201,
                    'Aluno cadastrado com sucesso',
                    $aluno
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    400,
                    'Erro ao cadastrar aluno',
                    ['erros' => $e->getMessage()]
                )
            );
        }
    }

    public function atualizar(UpdateAlunoRequest $request, int $id): JsonResponse
    {

        $validacoes = new Validacoes();
        $AlunosModel = new AlunosModel();

        try {
            $aluno = $AlunosModel->detalhar($id);

            $dadosValidados = $request->validated();

            $aluno->atualizar($dadosValidados);

            return response()->json(
                $validacoes->gerarRetornoHttp(
                    200,
                    'Dados atualizados com sucesso',
                    $aluno
                )
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    422,
                    'Erro de validação',
                    ['erros' => $e->errors()]
                )
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    404,
                    'Aluno não encontrado'
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    500,
                    'Erro ao atualizar aluno'
                )
            );
        }
    }

    public function listar(ListarAlunosRequest $request): JsonResponse
    {

        $alunosModel = new AlunosModel();
        $validacoes = new Validacoes();

        try {

            $alunos = $alunosModel->listar();

            return response()->json(
                $validacoes->gerarRetornoHttp(
                    200,
                    '',
                    $alunos
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    500,
                    'Erro ao listar alunos'
                )
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
                $validacoes->gerarRetornoHttp(
                    200,
                    'Aluno apagado com sucesso'
                )
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    404,
                    'Aluno não encontrado'
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    500,
                    'Erro ao apagar aluno'
                )
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
                $validacoes->gerarRetornoHttp(
                    200,
                    '',
                    $aluno
                )
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    404,
                    'Aluno não encontrado'
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(
                    500,
                    'Erro ao buscar aluno'
                )
            );
        }
    }
}
