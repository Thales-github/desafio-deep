<?php
// app/Services/ApiService.php

namespace App\Services;

use App\Http\Controllers\Alunos;
use App\Http\Controllers\Professores;
use App\Http\Controllers\Disciplinas;
use App\Http\Controllers\AlunosDisciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private function toArray($data)
    {
        if (is_array($data)) {
            return $data;
        }

        if (is_object($data)) {
            if (method_exists($data, 'toArray')) {
                return $data->toArray();
            }
            return (array) $data;
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

            $data = $this->toArray($response);

            // Se a resposta tiver uma chave 'data' com os alunos
            if (isset($data['data']) && is_array($data['data'])) {
                return $data['data'];
            }

            // Se for um array direto de alunos
            if (is_array($data)) {
                return $data;
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
            $response = $controller->detalhar($id);

            $data = $this->toArray($response);

            if (isset($data['data'])) {
                return $data['data'];
            }

            return $data;
        } catch (\Exception $e) {
            
            return ['error' => $e->getMessage()];
        }
    }

    public function createAluno($data)
    {
        try {
            $controller = new Alunos();
            $request = new Request($data);
            $response = $controller->cadastrar($request);
            return $this->toArray($response);
        } catch (\Exception $e) {
            
            return ['error' => $e->getMessage()];
        }
    }

    public function updateAluno($id, $data)
    {
        try {
            $controller = new Alunos();
            $request = new Request($data);
            $response = $controller->atualizar($request, $id);
            return $this->toArray($response);
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
}
