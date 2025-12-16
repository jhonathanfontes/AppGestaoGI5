<?php

namespace App\Controllers\Api;

use App\Models\PessoaModel;
use CodeIgniter\HTTP\ResponseInterface;

class PessoaController extends BaseController
{
    /**
     * Cria uma nova pessoa a partir de um JSON.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        // 1. Validar se o content-type é application/json
        if ($this->request->getHeaderLine('Content-Type') !== 'application/json') {
            return $this->respondError(
                'Content-Type inválido. Apenas application/json é aceito.',
                ResponseInterface::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }

        // 2. Obter e validar o JSON
        $data = $this->request->getJSON(true);
        if (empty($data)) {
            return $this->respondError('O corpo da requisição está vazio ou o JSON é inválido.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $pessoaModel = new PessoaModel();

        try {
            // 3. Tentar inserir os dados
            if ($pessoaModel->insert($data) === false) {
                // Se a inserção falhar, retorna os erros de validação do modelo
                return $this->respondValidationErrors($pessoaModel->errors());
            }

            // 4. Retornar sucesso com os dados da pessoa criada
            $newPessoaId = $pessoaModel->getInsertID();
            $pessoa = $pessoaModel->find($newPessoaId);

            return $this->respondSuccess($pessoa, 'Pessoa criada com sucesso!', ResponseInterface::HTTP_CREATED);

        } catch (\Exception $e) {
            // 5. Tratar exceções inesperadas
            $errorMessage = (ENVIRONMENT === 'development')
                ? 'Ocorreu um erro inesperado: ' . $e->getMessage()
                : 'Ocorreu um erro interno no servidor.';
            
            log_message('error', '[API] Erro ao criar pessoa: ' . $e->getMessage());

            return $this->respondError($errorMessage, ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
