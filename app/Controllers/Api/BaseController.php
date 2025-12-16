<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class BaseController extends ResourceController
{
    /**
     * Retorna uma resposta JSON de sucesso.
     *
     * @param mixed|null $data
     * @param string $message
     * @param int $code
     * @return ResponseInterface
     */
    protected function respondSuccess($data = null, string $message = 'Operação realizada com sucesso.', int $code = 200): ResponseInterface
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ];

        return $this->respond($response, $code);
    }

    /**
     * Retorna uma resposta JSON de erro.
     *
     * @param string|array $message Mensagem de erro ou array de mensagens.
     * @param int $code Código de status HTTP.
     * @param mixed|null $data Dados adicionais, se houver.
     * @return ResponseInterface
     */
    protected function respondError($message, int $code = 400, $data = null): ResponseInterface
    {
        $response = [
            'success' => false,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ];

        return $this->respond($response, $code);
    }

    /**
     * Retorna uma resposta para 'Não encontrado'.
     *
     * @param string $message
     * @return ResponseInterface
     */
    protected function respondNotFound(string $message = 'Recurso não encontrado.'): ResponseInterface
    {
        return $this->respondError($message, ResponseInterface::HTTP_NOT_FOUND);
    }

    /**
     * Retorna uma resposta para 'Não autorizado'.
     *
     * @param string $message
     * @return ResponseInterface
     */
    protected function respondUnauthorized(string $message = 'Não autorizado.'): ResponseInterface
    {
        return $this->respondError($message, ResponseInterface::HTTP_UNAUTHORIZED);
    }

    /**
     * Retorna uma resposta para 'Acesso proibido'.
     *
     * @param string $message
     * @return ResponseInterface
     */
    protected function respondForbidden(string $message = 'Acesso proibido.'): ResponseInterface
    {
        return $this->respondError($message, ResponseInterface::HTTP_FORBIDDEN);
    }

    /**
     * Retorna uma resposta para erro de validação.
     *
     * @param array $errors
     * @param string $message
     * @return ResponseInterface
     */
    protected function respondValidationErrors(array $errors, string $message = 'Erro de validação.'): ResponseInterface
    {
        return $this->respondError($message, ResponseInterface::HTTP_BAD_REQUEST, ['errors' => $errors]);
    }
}
