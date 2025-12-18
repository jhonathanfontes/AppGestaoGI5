<?php

namespace App\Controllers\Api;

use App\Services\ResponseService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class BaseController extends ResourceController
{
    protected ResponseService $responseService;

    public function __construct()
    {
        $this->responseService = new ResponseService(response());
    }

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
        return $this->responseService->success($data, $message, $code);
    }

    /**
     * Retorna uma resposta JSON de erro.
     *
     * @param string|array $message Mensagem de erro ou array de mensagens.
     * @param int $code Código de status HTTP.
     * @param mixed|null $data Dados adicionais, se houver.
     * @param \Throwable|null $exception
     * @return ResponseInterface
     */
    protected function respondError($message, int $code = 400, $data = null, ?\Throwable $exception = null): ResponseInterface
    {
        return $this->responseService->error($message, $data, $code, $exception);
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
        return $this->responseService->validation($errors, $message);
    }
}
