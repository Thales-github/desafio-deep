<?php

namespace App\Services;

use App\Http\Controllers\Alunos;
use App\Http\Controllers\AlunosDisciplinas;
use App\Http\Controllers\Disciplinas;
use App\Http\Controllers\Professores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private function toArray($dados)
    {
        if (is_array($dados)) {
            return $dados;
        }

        if (is_object($dados)) {
            if (method_exists($dados, 'toArray')) {
                return $dados->toArray();
            }
            return (array) $dados;
        }

        return [];
    }

    // ALUNOS
    public function getAlunos()
    {
        try {
            $controller = new Alunos();
            $request = new Request();
            $response = $controller->listar($request);

            // ✅ CORREÇÃO: pegar o conteúdo JSON da resposta
            $conteudo = $response->getData(true); // true = array associativo

            // DEBUG (pode remover depois)
            // dd($conteudo);

            // Agora sim, verifica se tem 'dados'
            if (isset($conteudo['dados']) && is_array($conteudo['dados'])) {
                return $conteudo['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getAluno($id)
    {
        try {
            $controller = new Alunos();
            $request = new Request();
            $response = $controller->detalhar($id); // Chama o método detalhar da API

            $dados = $response->getData(true);

            // A API retorna { "codigo":200, "dados": {...} }
            if (isset($dados['dados']) && is_array($dados['dados'])) {
                return $dados['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function createAluno($dados)
    {

        try {

            $controller = new Alunos();
            $request = new Request();
            $request->merge($dados);

            $response = $controller->cadastrar($request);

            // Converte para array
            $conteudo = $response->getData(true);

            return $conteudo;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateAluno($id, $dados)
    {
        try {
            // \Log::info('1️⃣ updateAluno INICIADO', ['id' => $id, 'dados_recebidos' => $dados]);

            $controller = new Alunos();
            $request = new Request();
            $request->merge($dados);
            $request->headers->set('Content-Type', 'application/json');

            $response = $controller->atualizar($request, $id);

            $conteudo = $response->getData(true); // Pega o JSON como array

            // \Log::info('4️⃣ Conteúdo processado CORRETAMENTE', ['conteudo' => $conteudo]);

            return $conteudo; // Agora retorna o array correto com 'codigo', 'mensagem', 'dados'

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteAluno($id)
    {
        try {
            $controller = new Alunos();
            $response = $controller->apagar($id);
            return $this->toArray($response);
        } catch (\Exception $e) {

            return ['error' => $e->getMessage()];
        }
    }

    // PROFESSORES
    public function getProfessores()
    {
        try {
            $controller = new Professores();
            $request = new Request();
            $response = $controller->listar($request);
            $conteudo = $response->getData(true);

            if (isset($conteudo['dados']) && is_array($conteudo['dados'])) {
                return $conteudo['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getProfessor($id)
    {
        try {
            $controller = new Professores();
            $response = $controller->detalhar($id);
            $dados = $response->getData(true);

            if (isset($dados['dados']) && is_array($dados['dados'])) {
                return $dados['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function createProfessor($dados)
    {
        try {
            $controller = new Professores();
            $request = new Request();
            $request->merge($dados);
            $response = $controller->cadastrar($request);

            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateProfessor($id, $dados)
    {
        try {
            $controller = new Professores();
            $request = new Request();
            $request->merge($dados);
            $request->headers->set('Content-Type', 'application/json');
            $response = $controller->atualizar($request, $id);

            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteProfessor($id)
    {
        try {
            $controller = new Professores();
            $response = $controller->apagar($id);
            return $this->toArray($response);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // DISCIPLINAS
    public function getDisciplinas()
    {
        try {
            $controller = new Disciplinas();
            $request = new Request();
            $response = $controller->listar($request);
            $conteudo = $response->getData(true);

            if (isset($conteudo['dados']) && is_array($conteudo['dados'])) {
                return $conteudo['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getDisciplina($id)
    {
        try {
            $controller = new Disciplinas();
            $response = $controller->detalhar($id);
            $dados = $response->getData(true);

            if (isset($dados['dados']) && is_array($dados['dados'])) {
                return $dados['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function createDisciplina($dados)
    {
        try {
            $controller = new Disciplinas();
            $request = new Request();
            $request->merge($dados);
            $response = $controller->cadastrar($request);
            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateDisciplina($id, $dados)
    {
        try {
            $controller = new Disciplinas();
            $request = new Request();
            $request->merge($dados);
            $request->headers->set('Content-Type', 'application/json');
            $response = $controller->atualizar($request, $id);
            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteDisciplina($id)
    {
        try {
            $controller = new Disciplinas();
            $response = $controller->apagar($id);
            return $this->toArray($response);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // ALUNOS DISCIPLINAS (MATRICULAS)
    public function getMatriculas()
    {
        try {
            $controller = new AlunosDisciplinas();
            $request = new Request();
            $response = $controller->listar($request);
            $conteudo = $response->getData(true);

            if (isset($conteudo['dados']) && is_array($conteudo['dados'])) {
                return $conteudo['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getMatricula($id)
    {
        try {
            $controller = new AlunosDisciplinas();
            $response = $controller->detalhar($id);
            $dados = $response->getData(true);

            if (isset($dados['dados']) && is_array($dados['dados'])) {
                return $dados['dados'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function createMatricula($dados)
    {
        try {
            $controller = new AlunosDisciplinas();
            $request = new Request();
            $request->merge($dados);
            $response = $controller->cadastrar($request);
            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateMatricula($id, $dados)
    {
        try {
            $controller = new AlunosDisciplinas();
            $request = new Request();
            $request->merge($dados);
            $request->headers->set('Content-Type', 'application/json');
            $response = $controller->atualizar($request, $id);
            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteMatricula($id)
    {
        try {
            $controller = new AlunosDisciplinas();
            $response = $controller->apagar($id);
            return $this->toArray($response);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
