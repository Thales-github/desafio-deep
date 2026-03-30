<?php

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

    public function index()
    {
        $matriculas = $this->api->getMatriculas();
        return view('alunos-disciplinas.index', ['matriculas' => is_array($matriculas) ? $matriculas : []]);
    }

    public function create()
    {
        return view('alunos-disciplinas.form', [
            'alunos' => $this->api->getAlunos(),
            'disciplinas' => $this->api->getDisciplinas(),
        ]);
    }

    public function store(Request $request)
    {
        $response = $this->api->createMatricula($request->all());

        if (isset($response['codigo']) && $response['codigo'] == 201) {
            return response()->json([
                'success' => true,
                'redirect' => route('alunos-disciplinas.index'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['mensagem'] ?? 'Erro ao cadastrar matricula',
            'errors' => $response['dados']['erros'] ?? [],
        ], $response['codigo'] ?? 400);
    }

    public function show($id)
    {
        $matricula = $this->api->getMatricula($id);
        return view('alunos-disciplinas.show', ['matricula' => $matricula]);
    }

    public function edit($id)
    {
        return view('alunos-disciplinas.form', [
            'matricula' => $this->api->getMatricula($id),
            'alunos' => $this->api->getAlunos(),
            'disciplinas' => $this->api->getDisciplinas(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = $this->api->updateMatricula($id, $request->all());

        if (isset($response['codigo']) && $response['codigo'] == 200) {
            return response()->json([
                'success' => true,
                'redirect' => route('alunos-disciplinas.index'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['mensagem'] ?? 'Erro ao atualizar matricula',
            'errors' => $response['dados']['erros'] ?? [],
        ], $response['codigo'] ?? 400);
    }

    public function destroy($id)
    {
        $this->api->deleteMatricula($id);
        return redirect()->route('alunos-disciplinas.index')->with('success', 'Matricula removida com sucesso!');
    }
}
