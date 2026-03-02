<?php
// app/Http/Controllers/DisciplinaWebController.php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class DisciplinaWebController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function listar()
    {
        $disciplinas = $this->api->get('/disciplinas/listar');
        return view('disciplinas.index', compact('disciplinas'));
    }

    public function cadastrar()
    {
        // Buscar professores para o select
        $professores = $this->api->get('/professores/listar');
        return view('disciplinas.form', compact('professores'));
    }

    public function salvar(Request $request)
    {
        $response = $this->api->post('/disciplinas/cadastrar', $request->all());

        if (isset($response['id'])) {
            return redirect()->route('disciplinas.listar')
                ->with('success', 'Disciplina cadastrada com sucesso!');
        }

        return back()->withErrors(['error' => 'Erro ao cadastrar disciplina'])->withInput();
    }

    public function detalhar($id)
    {
        $disciplina = $this->api->get("/disciplinas/detalhar/{$id}");
        return view('disciplinas.show', compact('disciplina'));
    }

    public function editar($id)
    {
        $disciplina = $this->api->get("/disciplinas/detalhar/{$id}");
        $professores = $this->api->get('/professores/listar');
        return view('disciplinas.form', compact('disciplina', 'professores'));
    }

    public function atualizar(Request $request, $id)
    {
        $response = $this->api->put("/disciplinas/atualizar/{$id}", $request->all());

        return redirect()->route('disciplinas.listar')
            ->with('success', 'Disciplina atualizada com sucesso!');
    }

    public function apagar($id)
    {
        $this->api->delete("/disciplinas/apagar/{$id}");

        return redirect()->route('disciplinas.listar')
            ->with('success', 'Disciplina excluída com sucesso!');
    }
}
