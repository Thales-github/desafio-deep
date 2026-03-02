<?php
// app/Http/Controllers/AlunoDisciplinaWebController.php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class AlunoDisciplinaWebController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function listar()
    {
        $matriculas = $this->api->get('/alunos-disciplinas/listar');
        return view('aluno-disciplina.index', compact('matriculas'));
    }

    public function cadastrar()
    {
        $alunos = $this->api->get('/alunos/listar');
        $disciplinas = $this->api->get('/disciplinas/listar');
        return view('aluno-disciplina.form', compact('alunos', 'disciplinas'));
    }

    public function salvar(Request $request)
    {
        $response = $this->api->post('/alunos-disciplinas/cadastrar', $request->all());

        if (isset($response['id'])) {
            return redirect()->route('alunos-disciplinas.listar')
                ->with('success', 'Matrícula realizada com sucesso!');
        }

        return back()->withErrors(['error' => 'Erro ao realizar matrícula'])->withInput();
    }

    public function detalhar($id)
    {
        $matricula = $this->api->get("/alunos-disciplinas/detalhar/{$id}");
        return view('aluno-disciplina.show', compact('matricula'));
    }

    public function editar($id)
    {
        $matricula = $this->api->get("/alunos-disciplinas/detalhar/{$id}");
        $alunos = $this->api->get('/alunos/listar');
        $disciplinas = $this->api->get('/disciplinas/listar');
        return view('aluno-disciplina.form', compact('matricula', 'alunos', 'disciplinas'));
    }

    public function atualizar(Request $request, $id)
    {
        $response = $this->api->put("/alunos-disciplinas/atualizar/{$id}", $request->all());

        return redirect()->route('alunos-disciplinas.listar')
            ->with('success', 'Matrícula atualizada com sucesso!');
    }

    public function apagar($id)
    {
        $this->api->delete("/alunos-disciplinas/apagar/{$id}");

        return redirect()->route('alunos-disciplinas.listar')
            ->with('success', 'Matrícula excluída com sucesso!');
    }
}
