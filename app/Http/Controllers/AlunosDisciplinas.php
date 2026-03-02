<?php

namespace App\Http\Controllers;

use App\Models\AlunosDisciplinas as AlunosDisciplinasModel;
use App\Validacoes\Validacoes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AlunosDisciplinas extends Controller
{

    private function gerarVetorValidacaoDeMatricula(bool $atualizar = false, ?int $id = null): array
    {
        $regras = [
            'aluno_id' => 'required|integer|exists:alunos,id',
            'disciplina_id' => 'required|integer|exists:disciplinas,id',
            'data_matricula' => 'nullable|date',
            'status' => 'nullable|integer|in:1,2,3,4',
            'nota_final' => 'nullable|numeric|min:0|max:10',
            'faltas' => 'nullable|integer|min:0'
        ];

        // Na criação, verificar se aluno já não está matriculado na disciplina
        if (!$atualizar) {
            $regras['aluno_id'] .= '|unique:alunos_disciplinas,aluno_id,NULL,id,disciplina_id,' . request('disciplina_id');
        }

        return $regras;
    }

    private function vetorMensagemCamposInvalidos(): array
    {
        return [
            // aluno_id
            'aluno_id.required' => 'ID do aluno é obrigatório.',
            'aluno_id.integer' => 'ID do aluno inválido.',
            'aluno_id.exists' => 'Aluno não encontrado.',
            'aluno_id.unique' => 'Aluno já matriculado nesta disciplina.',
            // disciplina_id
            'disciplina_id.required' => 'ID da disciplina é obrigatório.',
            'disciplina_id.integer' => 'ID da disciplina inválido.',
            'disciplina_id.exists' => 'Disciplina não encontrada.',
            // data_matricula
            'data_matricula.date' => 'Data de matrícula inválida.',
            // status
            'status.integer' => 'Status inválido.',
            'status.in' => 'Status deve ser: 1 (cursando), 2 (aprovado), 3 (reprovado) ou 4 (trancado).',
            // nota_final
            'nota_final.numeric' => 'Nota final deve ser um número.',
            'nota_final.min' => 'Nota final não pode ser menor que 0.',
            'nota_final.max' => 'Nota final não pode ser maior que 10.',
            // faltas
            'faltas.integer' => 'Faltas deve ser um número inteiro.',
            'faltas.min' => 'Faltas não pode ser negativa.'
        ];
    }

    public function cadastrar(Request $request): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosDisciplinasModel = new AlunosDisciplinasModel();

        try {
            $dadosValidos = $request->validate(
                $this->gerarVetorValidacaoDeMatricula(),
                $this->vetorMensagemCamposInvalidos()
            );

            // Define data de matrícula como hoje se não informada
            if (!isset($dadosValidos['data_matricula'])) {
                $dadosValidos['data_matricula'] = now()->toDateString();
            }

            $matricula = $alunosDisciplinasModel->cadastrar($dadosValidos);

            // Carrega relacionamentos para retornar dados completos
            $matricula->load(['aluno', 'disciplina']);

            return response()->json(
                $validacoes->gerarRetornoHttp(201, 'Matrícula realizada com sucesso', $matricula)
            );
        } catch (ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()])
            );
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao realizar matrícula', ['erros' => $e->getMessage()])
            );
        }
    }

    /**
     * LISTAR - GET /api/alunos-disciplinas/listar
     * Com possibilidade de filtros via query string
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            // Captura todos os possíveis filtros da query string
            $filtros = [
                'aluno_id' => $request->query('aluno_id'),
                'disciplina_id' => $request->query('disciplina_id'),
                'status' => $request->query('status'),
                'data_inicio' => $request->query('data_inicio'),
                'data_fim' => $request->query('data_fim'),
                'ordenacao' => $request->query('ordenacao', 'created_at'),
                'direcao' => $request->query('direcao', 'desc'),
                'por_pagina' => $request->query('por_pagina')
            ];

            // Remove filtros vazios para não atrapalhar a query
            $filtros = array_filter($filtros, function ($value) {
                return $value !== null && $value !== '';
            });

            $matriculas = $alunosDisciplinasModel->listar($filtros);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Matrículas listadas com sucesso', $matriculas)
            );
        } catch (\Exception $e) {

            return response()->json(
                $validacoes->gerarRetornoHttp(500, 'Erro ao listar matrículas: ' . $e->getMessage())
            );
        }
    }

    public function detalhar(int $id): JsonResponse
    {
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

    public function atualizar(Request $request, int $id): JsonResponse
    {
        try {
            $matricula = $alunosDisciplinasModel->detalhar($id);

            $regras = $this->gerarVetorValidacaoDeMatricula(true, $id);
            $dadosValidos = $request->validate($regras, $this->vetorMensagemCamposInvalidos());

            $matricula->atualizar($dadosValidos);
            $matricula->load(['aluno', 'disciplina']);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Matrícula atualizada com sucesso', $matricula)
            );
        } catch (ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()])
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
