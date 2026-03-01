<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alunos as AlunosModel;
use Illuminate\Http\JsonResponse;
use App\Validacoes\Validacoes;

class Alunos extends Controller
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

    // Personalizando as mensagens de erro para campos obrigatórios
    private function vetorMensagemCamposInválidos(): array
    {
        return [
            // Documento único
            'documento_unico.required' => 'CPF/CNPJ é obrigatório.',
            'documento_unico.unique' => 'Documento inválido.',// Segurança não pode revelar que já existe
            'documento_unico.string' => 'Documento inválido.',

            // Email
            'email.required' => 'E-mail é obrigatório.',
            'email.unique' => 'Email inválido.',// Segurança não pode revelar que já existe
            'email.email' => 'Formato de e-mail inválido.',

            // Nome
            'nome.required' => 'Nome completo é obrigatório.',
            'nome.max' => 'Nome deve ter no máximo :max caracteres.',

            // Data nascimento
            'data_nascimento.required' => 'Data de nascimento é obrigatória.',
            'data_nascimento.before' => 'Você deve ter pelo menos 16 anos para se cadastrar.',

            // CEP
            'cep.size' => 'CEP deve ter 8 dígitos.',

            // UF
            'uf.size' => 'UF deve ter 2 caracteres.'
        ];
    }

    public function cadastrar(Request $request): JsonResponse
    {
        $validacoes = new Validacoes();
        $alunosModel = new AlunosModel();

        try {
            $dadosValidos = $request->validate(
                $this->gerarVetorValidacaoDeAluno(),
                $this->vetorMensagemCamposInválidos()
            );

            $aluno = $alunosModel->cadastrar($dadosValidos);

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
        $AlunosModel = new alunosModel();

        try {

            $aluno = $AlunosModel->detalhar($id);

            $regras = $this->gerarVetorValidacaoDeAluno(true);

            $dadosValidados = $request->validate($regras, $this->vetorMensagemCamposInválidos());

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
