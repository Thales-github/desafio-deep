<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AlunoWebController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        try {
            $alunos = $this->api->getAlunos();


            // dd($alunos);
            // die();

            // Garantir que $alunos seja um array de arrays
            if (!is_array($alunos)) {
                $alunos = [];
            }

            // Se for um array de objetos, converter para array
            foreach ($alunos as $key => $aluno) {
                if (is_object($aluno)) {
                    $alunos[$key] = (array) $aluno;
                }
            }

            return view('alunos.index', ['alunos' => $alunos]);
        } catch (\Exception $e) {

            return view('alunos.index', ['alunos' => []])
                ->with('error', 'Erro ao carregar alunos. Tente novamente.');
        }
    }

    public function create()
    {
        return view('alunos.form');
    }

   public function store(Request $request)
{
    try {
        $response = $this->api->createAluno($request->all());

        if (!isset($response['codigo'])) {
            return response()->json([
                'success' => false,
                'message' => 'Resposta inválida da API'
            ], 500);
        }

        // Sucesso (código 201)
        if ($response['codigo'] == 201) {
            return response()->json([
                'success' => true,
                'message' => 'Aluno cadastrado com sucesso!',
                'redirect' => route('alunos.index')
            ]);
        }

        // Erro de validação (422)
        if ($response['codigo'] == 422) {
            $erros = $response['dados']['erros'] ?? [];
            
            return response()->json([
                'success' => false,
                'message' => $response['mensagem'] ?? 'Erro na validação',
                'errors' => $erros
            ], 422);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar aluno'
        ], 400);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar aluno: ' . $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        try {
            // \Log::info('5️⃣ update WEB iniciado', [
            //     'id' => $id,
            //     'dados_form' => $request->all()
            // ]);

            $response = $this->api->updateAluno($id, $request->all());

            // \Log::info('6️⃣ Resposta FINAL recebida no WebController', [
            //     'response' => $response
            // ]);

            // Sucesso (200)
            if (isset($response['codigo']) && $response['codigo'] == 200) {
                // \Log::info('7️⃣ ✅ Sucesso na atualização');
                return response()->json([
                    'success' => true,
                    'message' => 'Aluno atualizado com sucesso!',
                    'redirect' => route('alunos.index')
                ]);
            }

            // Erro de validação (422)
            if (isset($response['codigo']) && $response['codigo'] == 422) {
                // \Log::warning('8️⃣ ⚠️ Erro de validação', $response);
                return response()->json([
                    'success' => false,
                    'message' => $response['mensagem'] ?? 'Erro na validação',
                    'errors' => $response['dados']['erros'] ?? []
                ], 422);
            }

            // Outros erros
            // \Log::warning('9️⃣ ⚠️ Outro tipo de erro', $response);
            return response()->json([
                'success' => false,
                'message' => $response['mensagem'] ?? 'Erro ao atualizar aluno'
            ], $response['codigo'] ?? 400);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar aluno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $aluno = $this->api->getAluno($id);

            if (is_object($aluno)) {
                $aluno = (array) $aluno;
            }

            if (empty($aluno) || isset($aluno['error'])) {
                return redirect()->route('alunos.index')
                    ->with('error', 'Aluno não encontrado');
            }

            return view('alunos.show', ['aluno' => $aluno]);
        } catch (\Exception $e) {

            return redirect()->route('alunos.index')
                ->with('error', 'Erro ao carregar dados do aluno');
        }
    }

    public function edit($id)
    {
        try {
            $aluno = $this->api->getAluno($id);

            if (is_object($aluno)) {
                $aluno = (array) $aluno;
            }

            if (empty($aluno) || isset($aluno['error'])) {
                return redirect()->route('alunos.index')
                    ->with('error', 'Aluno não encontrado');
            }

            return view('alunos.form', ['aluno' => $aluno]);
        } catch (\Exception $e) {

            return redirect()->route('alunos.index')
                ->with('error', 'Erro ao carregar dados do aluno');
        }
    }

    public function destroy($id)
    {
        try {
            $this->api->deleteAluno($id);

            return redirect()->route('alunos.index')
                ->with('success', 'Aluno excluído com sucesso!');
        } catch (\Exception $e) {

            return redirect()->route('alunos.index')
                ->with('error', 'Erro ao excluir aluno');
        }
    }
}
