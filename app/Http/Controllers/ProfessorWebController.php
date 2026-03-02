<?php
// app/Http/Controllers/ProfessorWebController.php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ProfessorWebController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function listar()
    {
        $professores = $this->api->get('/professores/listar');
        return view('professores.index', compact('professores'));
    }

    public function cadastrar()
    {
        return view('professores.form');
    }

    public function salvar(Request $request)
    {
        $response = $this->api->post('/professores/cadastrar', $request->all());

        if (isset($response['id'])) {
            return redirect()->route('professores.listar')
                ->with('success', 'Professor cadastrado com sucesso!');
        }

        return back()->withErrors(['error' => 'Erro ao cadastrar professor'])->withInput();
    }

    public function detalhar($id)
    {
        $professor = $this->api->get("/professores/detalhar/{$id}");
        return view('professores.show', compact('professor'));
    }

    public function editar($id)
    {
        $professor = $this->api->get("/professores/detalhar/{$id}");
        return view('professores.form', compact('professor'));
    }

    public function atualizar(Request $request, $id)
    {
        $response = $this->api->put("/professores/atualizar/{$id}", $request->all());

        return redirect()->route('professores.listar')
            ->with('success', 'Professor atualizado com sucesso!');
    }

    public function apagar($id)
    {
        $this->api->delete("/professores/apagar/{$id}");

        return redirect()->route('professores.listar')
            ->with('success', 'Professor excluído com sucesso!');
    }
}
