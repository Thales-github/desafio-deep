<?php
// app/Services/ApiService.php

namespace App\Services;

use App\Http\Controllers\Alunos;
use Illuminate\Http\Request;

class ApiService
{
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
            $controller = new Alunos();
            $request = new Request();
            $response = $controller->listar($request);

            // ✅ CORREÇÃO: pegar o conteúdo JSON da resposta
            $conteudo = $response->getData(true); // true = array associativo

            // DEBUG (pode remover depois)
            // dd($conteudo);

            // Agora sim, verifica se tem 'dados'
            if (isset($conteudo['dados']) && is_array($conteudo['dados'])) {
                return $conteudo['dados'];
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
            $request = new Request();
            $response = $controller->detalhar($id); // Chama o método detalhar da API

            $dados = $response->getData(true);

            // A API retorna { "codigo":200, "dados": {...} }
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
            $controller = new Alunos();
            $request = new Request($dados);
            $response = $controller->cadastrar($request);
            return $this->toArray($response);
        } catch (\Exception $e) {

            return ['error' => $e->getMessage()];
        }
    }

    public function updateAluno($id, $dados)
    {

        try {
            
            $controller = new Alunos();

            $request = new Request();
            $request->merge($dados); // Adiciona os dados ao request

            $request->headers->set('Content-Type', 'application/json');
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
