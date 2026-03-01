<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Disciplinas as DisciplinasModel;
use App\Validacoes\Validacoes;

class Disciplinas extends Controller
{
    private function gerarVetorValidacaoDeDisciplina(bool $atualizar = false, ?int $id = null): array
    {
        // AQUI SÓ TEM REGRAS, NÃO MENSAGENS!
        $validacoesDeDisciplina = [
            'nome' => 'required|string|max:100',  // REGRA, sem unique ainda
            'descricao' => 'nullable|string|max:500',
            'professor_id' => 'required|integer|exists:professores,id',
        ];

        // Adiciona unique separadamente
        if ($atualizar && $id) {
            $validacoesDeDisciplina['nome'] = "required|string|max:100|unique:disciplinas,nome,{$id}";
        } else {
            $validacoesDeDisciplina['nome'] = "required|string|max:100|unique:disciplinas,nome";
        }

        return $validacoesDeDisciplina;
    }

    private function vetorMensagemCamposInvalidos(): array
    {
        return [
            // nome
            'nome.required' => 'nome é obrigatório.',
            'nome.string' => 'nome inválido.',
            'nome.max' => 'nome deve ter no máximo :max caracteres.',
            'nome.unique' => 'Já existe uma disciplina com este nome.',  // <- Mensagem unique AQUI!

            // descricao
            'descricao.string' => 'descrição inválida.',
            'descricao.max' => 'descrição deve ter no máximo :max caracteres.',

            // professor_id
            'professor_id.required' => 'ID do professor é obrigatório.',
            'professor_id.integer' => 'ID do professor inválido.',
            'professor_id.exists' => 'ID do professor não encontrado.',
        ];
    }

    public function cadastrar(Request $request): JsonResponse
    {

        $validacoes = new Validacoes();
        $disciplinasModel = new DisciplinasModel();

        try {

            $dadosValidos = $request->validate(
                $this->gerarVetorValidacaoDeDisciplina(),
                $this->vetorMensagemCamposInvalidos()
            );

            $disciplina = $disciplinasModel->cadastrar($dadosValidos);

            return response()->json($validacoes->gerarRetornoHttp(201, 'Disciplina cadastrado com sucesso', $disciplina));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()]));
        } catch (\Exception $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(400, 'Erro ao cadastrar disciplina', ['erros' => $e->getMessage()])
            );
        }
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $validacoes = new Validacoes();
        $disciplinasModel = new DisciplinasModel();

        try {
            $disciplina = $disciplinasModel->detalhar($id);

            // PASSA O ID para ignorar o próprio registro na validação unique
            $regras = $this->gerarVetorValidacaoDeDisciplina(true, $id);

            $dadosValidados = $request->validate($regras, $this->vetorMensagemCamposInvalidos());

            $disciplina->atualizar($dadosValidados);

            return response()->json(
                $validacoes->gerarRetornoHttp(200, 'Dados atualizados com sucesso', $disciplina)
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                $validacoes->gerarRetornoHttp(422, 'Erro de validação', ['erros' => $e->errors()])
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

    public function listar(Request $request): JsonResponse
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

            $disciplina = $disciplinasModel->detalhar($id);

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
