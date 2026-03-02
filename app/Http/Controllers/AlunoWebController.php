<?php
// app/Http/Controllers/AlunoWebController.php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

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

            if (isset($response['id']) || isset($response['success'])) {
                return redirect()->route('alunos.index')
                    ->with('success', 'Aluno cadastrado com sucesso!');
            }

            return back()->withErrors(['error' => 'Erro ao cadastrar aluno'])->withInput();
        } catch (\Exception $e) {
            
            return back()->withErrors(['error' => 'Erro ao cadastrar aluno'])->withInput();
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

    public function update(Request $request, $id)
    {
        try {
            $response = $this->api->updateAluno($id, $request->all());

            return redirect()->route('alunos.index')
                ->with('success', 'Aluno atualizado com sucesso!');
        } catch (\Exception $e) {
            
            return back()->withErrors(['error' => 'Erro ao atualizar aluno'])->withInput();
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
