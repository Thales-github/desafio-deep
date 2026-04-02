<?php

namespace App\Services;

use App\Http\Controllers\Alunos;
use App\Http\Controllers\AlunosDisciplinas;
use App\Http\Controllers\Disciplinas;
use App\Http\Controllers\Professores;
use App\Http\Requests\Aluno\ListarAlunosRequest;
use App\Http\Requests\Aluno\StoreAlunoRequest;
use App\Http\Requests\Aluno\UpdateAlunoRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;

class ApiService
{
    /**
     * Request sintética com a mesma URI de routes/api.php + rota resolvida (necessário para UpdateAlunoRequest::route('id')).
     */
    private function createMatchedApiRequest(string $method, string $relativePath, array $payload = []): Request
    {
        $baseUrl = rtrim((string) config('app.url', 'http://127.0.0.1'), '/');
        $uri = $baseUrl.'/'.ltrim($relativePath, '/');
        $request = Request::create($uri, strtoupper($method), $payload);
        $request->setRouteResolver(static function () use ($request): Route {
            return app(Router::class)->getRoutes()->match($request);
        });

        return $request;
    }

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
            $base = $this->createMatchedApiRequest('GET', 'api/alunos/listar');
            $formRequest = ListarAlunosRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Alunos();
            $response = $controller->listar($formRequest);
            $conteudo = $response->getData(true);

            if (isset($conteudo['dados']) && is_array($conteudo['dados'])) {
                return $conteudo['dados'];
            }

            return [];
        } catch (ValidationException $e) {
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getAluno($id)
    {
        try {
            $id = (int) $id;

            $controller = new Alunos();
            $response = $controller->detalhar($id);
            $dados = $response->getData(true);

            if (($dados['codigo'] ?? null) === 404) {
                return [];
            }

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
            $payload = $this->toArray($dados);

            // Requisição sintética + FormRequest: mesmas regras que a rota HTTP
            $baseRequest = Request::create('/', 'POST', $payload);
            $formRequest = StoreAlunoRequest::createFrom($baseRequest);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Alunos();
            $response = $controller->cadastrar($formRequest);

            return $response->getData(true);
        } catch (ValidationException $e) {
            return [
                'codigo' => 422,
                'mensagem' => 'Dados inválidos.',
                'dados' => ['erros' => $e->errors()],
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateAluno($id, $dados)
    {
        try {
            $id = (int) $id;
            $payload = $this->toArray($dados);

            $base = $this->createMatchedApiRequest('PUT', "api/alunos/atualizar/{$id}", $payload);
            $formRequest = UpdateAlunoRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Alunos();
            $response = $controller->atualizar($formRequest, $id);

            return $response->getData(true);
        } catch (ValidationException $e) {
            return [
                'codigo' => 422,
                'mensagem' => 'Erro de validação',
                'dados' => ['erros' => $e->errors()],
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteAluno($id)
    {
        try {
            $id = (int) $id;

            $controller = new Alunos();
            $response = $controller->apagar($id);

            return $response->getData(true);
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
