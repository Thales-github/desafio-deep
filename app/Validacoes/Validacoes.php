<?php

namespace App\Validacoes;

class Validacoes
{

    // cria um vetor padronizado para retorno da api
    public function gerarRetornoHttp(int $codigoHttp, string $mensagem, mixed $dados = []): array
    {
        return [
            'codigo' => $codigoHttp,
            'mensagem' => $mensagem,
            'dados' => $dados
        ];
    }
}
