<?php

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

    public function index()
    {
        $disciplinas = $this->api->getDisciplinas();
        return view('disciplinas.index', ['disciplinas' => is_array($disciplinas) ? $disciplinas : []]);
    }

    public function create()
    {
        $professores = $this->api->getProfessores();
        return view('disciplinas.form', ['professores' => $professores]);
    }

    public function store(Request $request)
    {
        $response = $this->api->createDisciplina($request->all());

        if (isset($response['codigo']) && $response['codigo'] == 201) {
            return response()->json([
                'success' => true,
                'redirect' => route('disciplinas.index'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['mensagem'] ?? 'Erro ao cadastrar disciplina',
            'errors' => $response['dados']['erros'] ?? [],
        ], $response['codigo'] ?? 400);
    }

    public function show($id)
    {
        $disciplina = $this->api->getDisciplina($id);
        return view('disciplinas.show', ['disciplina' => $disciplina]);
    }

    public function edit($id)
    {
        $disciplina = $this->api->getDisciplina($id);
        $professores = $this->api->getProfessores();
        return view('disciplinas.form', ['disciplina' => $disciplina, 'professores' => $professores]);
    }

    public function update(Request $request, $id)
    {
        $response = $this->api->updateDisciplina($id, $request->all());

        if (isset($response['codigo']) && $response['codigo'] == 200) {
            return response()->json([
                'success' => true,
                'redirect' => route('disciplinas.index'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['mensagem'] ?? 'Erro ao atualizar disciplina',
            'errors' => $response['dados']['erros'] ?? [],
        ], $response['codigo'] ?? 400);
    }

    public function destroy($id)
    {
        $this->api->deleteDisciplina($id);
        return redirect()->route('disciplinas.index')->with('success', 'Disciplina excluida com sucesso!');
    }
}
