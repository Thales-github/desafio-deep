<?php

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

    public function index()
    {
        try {
            $professores = $this->api->getProfessores();

            if (!is_array($professores)) {
                $professores = [];
            }

            foreach ($professores as $key => $professor) {
                if (is_object($professor)) {
                    $professores[$key] = (array) $professor;
                }
            }

            return view('professores.index', ['professores' => $professores]);
        } catch (\Exception $e) {
            return view('professores.index', ['professores' => []])
                ->with('error', 'Erro ao carregar professores. Tente novamente.');
        }
    }

    public function create()
    {
        return view('professores.form');
    }

    public function store(Request $request)
    {
        try {
            $response = $this->api->createProfessor($request->all());

            if (isset($response['codigo']) && $response['codigo'] == 201) {
                return response()->json([
                    'success' => true,
                    'message' => 'Professor cadastrado com sucesso!',
                    'redirect' => route('professores.index'),
                ]);
            }

            if (isset($response['codigo']) && $response['codigo'] == 422) {
                return response()->json([
                    'success' => false,
                    'message' => $response['mensagem'] ?? 'Erro na validação',
                    'errors' => $response['dados']['erros'] ?? [],
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => $response['mensagem'] ?? 'Erro ao cadastrar professor',
            ], $response['codigo'] ?? 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar professor: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $professor = $this->api->getProfessor($id);

            if (is_object($professor)) {
                $professor = (array) $professor;
            }

            if (empty($professor) || isset($professor['error'])) {
                return redirect()->route('professores.index')
                    ->with('error', 'Professor não encontrado');
            }

            return view('professores.show', ['professor' => $professor]);
        } catch (\Exception $e) {
            return redirect()->route('professores.index')
                ->with('error', 'Erro ao carregar dados do professor');
        }
    }

    public function edit($id)
    {
        try {
            $professor = $this->api->getProfessor($id);

            if (is_object($professor)) {
                $professor = (array) $professor;
            }

            if (empty($professor) || isset($professor['error'])) {
                return redirect()->route('professores.index')
                    ->with('error', 'Professor não encontrado');
            }

            return view('professores.form', ['professor' => $professor]);
        } catch (\Exception $e) {
            return redirect()->route('professores.index')
                ->with('error', 'Erro ao carregar dados do professor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->api->updateProfessor($id, $request->all());

            if (isset($response['codigo']) && $response['codigo'] == 200) {
                return response()->json([
                    'success' => true,
                    'message' => 'Professor atualizado com sucesso!',
                    'redirect' => route('professores.index'),
                ]);
            }

            if (isset($response['codigo']) && $response['codigo'] == 422) {
                return response()->json([
                    'success' => false,
                    'message' => $response['mensagem'] ?? 'Erro na validação',
                    'errors' => $response['dados']['erros'] ?? [],
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => $response['mensagem'] ?? 'Erro ao atualizar professor',
            ], $response['codigo'] ?? 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar professor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->api->deleteProfessor($id);

            return redirect()->route('professores.index')
                ->with('success', 'Professor excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('professores.index')
                ->with('error', 'Erro ao excluir professor');
        }
    }
}
