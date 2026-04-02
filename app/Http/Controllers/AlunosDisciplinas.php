<?php

namespace App\Http\Controllers;

use App\Http\Requests\Matricula\ListarMatriculasRequest;
use App\Http\Requests\Matricula\StoreMatriculaRequest;
use App\Http\Requests\Matricula\UpdateMatriculaRequest;
use App\Models\AlunosDisciplinas as AlunosDisciplinasModel;
use App\Validacoes\Validacoes;
use Illuminate\Http\JsonResponse;

class AlunosDisciplinas extends Controller
{
    public function cadastrar(StoreMatriculaRequest $request): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $dadosValidos = $request->validated();

            if (! isset($dadosValidos['data_matricula'])) {
                $dadosValidos['data_matricula'] = now()->toDateString();
            }

            $matricula = $alunosDisciplinasModel->cadastrar($dadosValidos);
            $matricula->load(['aluno', 'disciplina']);

            return response()->json(
                $validacoes->gerarRetornoHttp(201, 'Matrícula realizada com sucesso', $matricula)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao realizar matrícula', ['erros' => $e->getMessage()])
            );
        }
    }

    public function listar(ListarMatriculasRequest $request): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $validated = $request->validated();

            $filtros = [
                'aluno_id' => $validated['aluno_id'] ?? null,
                'disciplina_id' => $validated['disciplina_id'] ?? null,
                'status' => $validated['status'] ?? null,
                'data_inicio' => $validated['data_inicio'] ?? null,
                'data_fim' => $validated['data_fim'] ?? null,
                'ordenacao' => $validated['ordenacao'] ?? 'created_at',
                'direcao' => $validated['direcao'] ?? 'desc',
                'por_pagina' => $validated['por_pagina'] ?? null,
            ];

            $filtros = array_filter($filtros, fn ($value) => $value !== null && $value !== '');

            $matriculas = $alunosDisciplinasModel->listar($filtros);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Matrículas listadas com sucesso', $matriculas)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao listar matrículas: '.$e->getMessage())
            );
        }
    }

    public function detalhar(int $id): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $matricula = $alunosDisciplinasModel->detalhar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $matricula)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Matrícula não encontrada')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao buscar matrícula')
            );
        }
    }

    public function atualizar(UpdateMatriculaRequest $request, int $id): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $matricula = $alunosDisciplinasModel->detalhar($id);
            $matricula->atualizar($request->validated());
            $matricula->load(['aluno', 'disciplina']);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Matrícula atualizada com sucesso', $matricula)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Matrícula não encontrada')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao atualizar matrícula')
            );
        }
    }

    public function apagar(int $id): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $alunosDisciplinasModel->apagar($id);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Matrícula removida com sucesso')
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(404, 'Matrícula não encontrada')
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao remover matrícula')
            );
        }
    }

    public function matriculasPorAluno(int $alunoId): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $matriculas = $alunosDisciplinasModel
                ->with('disciplina')
                ->where('aluno_id', $alunoId)
                ->get();

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $matriculas)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao buscar matrículas do aluno')
            );
        }
    }

    public function matriculasPorDisciplina(int $disciplinaId): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $matriculas = $alunosDisciplinasModel
                ->with('aluno')
                ->where('disciplina_id', $disciplinaId)
                ->get();

            return response()->json(
                $validacoes->gerarRetornoHttp(200, '', $matriculas)
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao buscar alunos da disciplina')
            );
        }
    }
}
