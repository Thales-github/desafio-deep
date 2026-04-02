<?php

namespace App\Services;

use App\Http\Controllers\Alunos;
use App\Http\Controllers\AlunosDisciplinas;
use App\Http\Controllers\Disciplinas;
use App\Http\Controllers\Professores;
use App\Http\Requests\Aluno\ListarAlunosRequest;
use App\Http\Requests\Aluno\StoreAlunoRequest;
use App\Http\Requests\Aluno\UpdateAlunoRequest;
use App\Http\Requests\Disciplina\ListarDisciplinasRequest;
use App\Http\Requests\Disciplina\StoreDisciplinaRequest;
use App\Http\Requests\Disciplina\UpdateDisciplinaRequest;
use App\Http\Requests\Matricula\ListarMatriculasRequest;
use App\Http\Requests\Matricula\StoreMatriculaRequest;
use App\Http\Requests\Matricula\UpdateMatriculaRequest;
use App\Http\Requests\Professor\ListarProfessoresRequest;
use App\Http\Requests\Professor\StoreProfessorRequest;
use App\Http\Requests\Professor\UpdateProfessorRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;

class ApiService
{
    /**
     * Request sintética com a mesma URI de routes/api.php + rota resolvida (ex.: Update*Request::route('id')).
     * Em GET, $query vira query string (validação de listagens com filtros).
     */
    private function createMatchedApiRequest(string $method, string $relativePath, array $payload = [], array $query = []): Request
    {
        $baseUrl = rtrim((string) config('app.url', 'http://127.0.0.1'), '/');
        $uri = $baseUrl.'/'.ltrim($relativePath, '/');
        $verb = strtoupper($method);

        $request = $verb === 'GET'
            ? Request::create($uri, 'GET', $query)
            : Request::create($uri, $verb, $payload);

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
            $base = $this->createMatchedApiRequest('GET', 'api/professores/listar');
            $formRequest = ListarProfessoresRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Professores();
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

    public function getProfessor($id)
    {
        try {
            $id = (int) $id;

            $controller = new Professores();
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

    public function createProfessor($dados)
    {
        try {
            $payload = $this->toArray($dados);
            $base = Request::create('/', 'POST', $payload);
            $formRequest = StoreProfessorRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Professores();
            $response = $controller->cadastrar($formRequest);

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

    public function updateProfessor($id, $dados)
    {
        try {
            $id = (int) $id;
            $payload = $this->toArray($dados);

            $base = $this->createMatchedApiRequest('PUT', "api/professores/atualizar/{$id}", $payload);
            $formRequest = UpdateProfessorRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Professores();
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

    public function deleteProfessor($id)
    {
        try {
            $controller = new Professores();
            $response = $controller->apagar((int) $id);

            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // DISCIPLINAS
    public function getDisciplinas()
    {
        try {
            $base = $this->createMatchedApiRequest('GET', 'api/disciplinas/listar');
            $formRequest = ListarDisciplinasRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Disciplinas();
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

    public function getDisciplina($id)
    {
        try {
            $id = (int) $id;

            $controller = new Disciplinas();
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

    public function createDisciplina($dados)
    {
        try {
            $payload = $this->toArray($dados);
            $base = Request::create('/', 'POST', $payload);
            $formRequest = StoreDisciplinaRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Disciplinas();
            $response = $controller->cadastrar($formRequest);

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

    public function updateDisciplina($id, $dados)
    {
        try {
            $id = (int) $id;
            $payload = $this->toArray($dados);

            $base = $this->createMatchedApiRequest('PUT', "api/disciplinas/atualizar/{$id}", $payload);
            $formRequest = UpdateDisciplinaRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new Disciplinas();
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

    public function deleteDisciplina($id)
    {
        try {
            $controller = new Disciplinas();
            $response = $controller->apagar((int) $id);

            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // ALUNOS DISCIPLINAS (MATRICULAS)
    public function getMatriculas(array $query = [])
    {
        try {
            $base = $this->createMatchedApiRequest('GET', 'api/alunos-disciplinas/listar', [], $query);
            $formRequest = ListarMatriculasRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new AlunosDisciplinas();
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

    public function getMatricula($id)
    {
        try {
            $id = (int) $id;

            $controller = new AlunosDisciplinas();
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

    public function createMatricula($dados)
    {
        try {
            $payload = $this->toArray($dados);
            $base = Request::create('/', 'POST', $payload);
            $formRequest = StoreMatriculaRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new AlunosDisciplinas();
            $response = $controller->cadastrar($formRequest);

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

    public function updateMatricula($id, $dados)
    {
        try {
            $id = (int) $id;
            $payload = $this->toArray($dados);

            $base = $this->createMatchedApiRequest('PUT', "api/alunos-disciplinas/atualizar/{$id}", $payload);
            $formRequest = UpdateMatriculaRequest::createFrom($base);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();

            $controller = new AlunosDisciplinas();
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

    public function deleteMatricula($id)
    {
        try {
            $controller = new AlunosDisciplinas();
            $response = $controller->apagar((int) $id);

            return $response->getData(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
