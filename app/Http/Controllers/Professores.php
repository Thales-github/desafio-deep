<?php

namespace App\Http\Controllers;

use App\Http\Requests\Professor\ListarProfessoresRequest;
use App\Http\Requests\Professor\StoreProfessorRequest;
use App\Http\Requests\Professor\UpdateProfessorRequest;
use App\Models\Professores as ProfessoresModel;
use App\Validacoes\Validacoes;
use Illuminate\Http\JsonResponse;

class Professores extends Controller
{
    public function cadastrar(StoreProfessorRequest $request): JsonResponse
    {
        $validacoes = new Validacoes();
        $professoresModel = new ProfessoresModel();

        try {
            $professor = $professoresModel->cadastrar($request->validated());

            return response()->json($validacoes->gerarRetornoHttp(201, 'Professor cadastrado com sucesso', $professor));
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao cadastrar professor', ['erros' => $e->getMessage()])
            );
        }
    }

    public function atualizar(UpdateProfessorRequest $request, int $id): JsonResponse
    {
        $validacoes = new Validacoes();
        $professoresModel = new ProfessoresModel();

        try {
            $professor = $professoresModel->detalhar($id);
            $professor->atualizar($request->validated());

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Dados atualizados com sucesso', $professor)
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

    public function listar(ListarProfessoresRequest $request): JsonResponse
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
            $professoresModel->detalhar($id);
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
