<?php

namespace App\Http\Controllers;

use App\Http\Requests\Disciplina\ListarDisciplinasRequest;
use App\Http\Requests\Disciplina\StoreDisciplinaRequest;
use App\Http\Requests\Disciplina\UpdateDisciplinaRequest;
use App\Models\Disciplinas as DisciplinasModel;
use App\Validacoes\Validacoes;
use Illuminate\Http\JsonResponse;

class Disciplinas extends Controller
{
    public function cadastrar(StoreDisciplinaRequest $request): JsonResponse
    {
        $validacoes = new Validacoes();
        $disciplinasModel = new DisciplinasModel();

        try {
            $disciplina = $disciplinasModel->cadastrar($request->validated());

            return response()->json($validacoes->gerarRetornoHttp(201, 'Disciplina cadastrado com sucesso', $disciplina));
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao cadastrar disciplina', ['erros' => $e->getMessage()])
            );
        }
    }

    public function atualizar(UpdateDisciplinaRequest $request, int $id): JsonResponse
    {
        $validacoes = new Validacoes();
        $disciplinasModel = new DisciplinasModel();

        try {
            $disciplina = $disciplinasModel->detalhar($id);
            $disciplina->atualizar($request->validated());

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Dados atualizados com sucesso', $disciplina)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Disciplina não encontrada')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao atualizar disciplina')
            );
        }
    }

    public function listar(ListarDisciplinasRequest $request): JsonResponse
    {
        $disciplinasModel = new DisciplinasModel();
        $validacoes = new Validacoes();

        try {
            $disciplinas = $disciplinasModel->listar();

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $disciplinas)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao listar disciplinas')
            );
        }
    }

    public function apagar(int $id): JsonResponse
    {
        $disciplinasModel = new DisciplinasModel();
        $validacoes = new Validacoes();

        try {
            $disciplinasModel->detalhar($id);
            $disciplinasModel->apagar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Disciplina apagado com sucesso')
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Disciplina não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao apagar disciplina')
            );
        }
    }

    public function detalhar(int $id): JsonResponse
    {
        $disciplinasModel = new DisciplinasModel();
        $validacoes = new Validacoes();

        try {
            $disciplina = $disciplinasModel->detalhar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $disciplina)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Disciplina não encontrado')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao buscar disciplina')
            );
        }
    }
}
