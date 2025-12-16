<?php

namespace App\Controllers\Api;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class UsuarioController extends BaseController
{
    /**
     * Cria um novo usuário a partir de um JSON.
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

        // A lógica de 'criado_por' via session foi removida para manter a API stateless.
        // Se a autoria for necessária, deve ser enviada no corpo do JSON ou
        // identificada por um mecanismo de autenticação de API (ex: token JWT).

        $userModel = new UsuarioModel();

        try {
            // 3. Tentar inserir os dados
            if ($userModel->insert($data) === false) {
                // Se a inserção falhar, retorna os erros de validação do modelo
                return $this->respondValidationErrors($userModel->errors());
            }

            // 4. Retornar sucesso com os dados do usuário criado
            $newUserId = $userModel->getInsertID();
            $user = $userModel->find($newUserId);

            return $this->respondSuccess($user, 'Usuário criado com sucesso!', ResponseInterface::HTTP_CREATED);

        } catch (\Exception $e) {
            // 5. Tratar exceções inesperadas
            $errorMessage = (ENVIRONMENT === 'development')
                ? 'Ocorreu um erro inesperado: ' . $e->getMessage()
                : 'Ocorreu um erro interno no servidor.';
            
            log_message('error', '[API] Erro ao criar usuário: ' . $e->getMessage());

            return $this->respondError($errorMessage, ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
