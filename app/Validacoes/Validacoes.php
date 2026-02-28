<?php

namespace App\Validacoes;

class Validacoes
{

    public function gerarRetornoHttp(int $codigoHttp,string $mensagem, array $dados = []): array
    {
        return [
            'codigo' => $codigoHttp,
            'mensagem' => 'Aluno cadastrado com sucesso',
            'dados' => $dados
        ];
    }
}
