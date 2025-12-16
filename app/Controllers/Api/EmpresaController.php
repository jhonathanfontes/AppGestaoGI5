<?php

namespace App\Controllers\Api;

use App\Models\EmpresaModel;
use CodeIgniter\HTTP\ResponseInterface;

class EmpresaController extends BaseController
{
    /**
     * Cria uma nova empresa a partir de um JSON.
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

        $empresaModel = new EmpresaModel();

        try {
            // 3. Tentar inserir os dados
            if ($empresaModel->insert($data) === false) {
                // Se a inserção falhar, retorna os erros de validação do modelo
                return $this->respondValidationErrors($empresaModel->errors());
            }

            // 4. Retornar sucesso com os dados da empresa criada
            $newEmpresaId = $empresaModel->getInsertID();
            $empresa = $empresaModel->find($newEmpresaId);

            return $this->respondSuccess($empresa, 'Empresa criada com sucesso!', ResponseInterface::HTTP_CREATED);

        } catch (\Exception $e) {
            // 5. Tratar exceções inesperadas
            $errorMessage = (ENVIRONMENT === 'development')
                ? 'Ocorreu um erro inesperado: ' . $e->getMessage()
                : 'Ocorreu um erro interno no servidor.';
            
            log_message('error', '[API] Erro ao criar empresa: ' . $e->getMessage());

            return $this->respondError($errorMessage, ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
