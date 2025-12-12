<?php

namespace App\Controllers\Tools;

use App\Controllers\BaseController;

class Assets extends BaseController
{
    public function build()
    {
        // Segurança: só permitir em development
        if (ENVIRONMENT !== 'development') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Build disponível apenas em ambiente DEVELOPMENT.'
            ])->setStatusCode(403);
        }

        // Caminho para o PHP
        $php = PHP_BINARY;
        $spark = ROOTPATH . 'spark';

        // Comando que vamos chamar
        $cmd = "{$php} {$spark} assets:build-full";

        // Executar comando
        exec($cmd, $output, $return);

        if ($return !== 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'output' => $output,
                'message' => 'Falha ao executar build de assets.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Build de assets executado com sucesso!',
            'output' => $output
        ]);
    }
}
