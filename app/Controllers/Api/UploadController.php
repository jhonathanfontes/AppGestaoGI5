<?php

namespace App\Controllers\Api;

use App\Services\FileUploadService;
use CodeIgniter\HTTP\ResponseInterface;

class UploadController extends BaseController
{
    protected FileUploadService $fileUploadService;

    public function __construct()
    {
        parent::__construct();
        $this->fileUploadService = new FileUploadService();
    }

    /**
     * POST /api/upload
     * Body form-data:
     * - module (string)
     * - field (string) (form field name)
     * - type (imagem|documento)
     * - subtype (optional)
     * - file[] (file)
     */
    public function upload(): ResponseInterface
    {
        $module  = $this->request->getPost('module') ?? 'default';
        $field   = $this->request->getPost('field') ?? 'file';
        $type    = $this->request->getPost('type') ?? 'imagem';
        $subtype = $this->request->getPost('subtype') ?? null;

        $result = $this->fileUploadService->upload($module, $field, $type, $subtype);

        if ($result['success']) {
            return $this->respondSuccess($result['data'], $result['message'] ?? 'Upload realizado com sucesso.');
        }

        return $this->respondError($result['message'] ?? 'Falha no upload.', $result['code'] ?? 400, $result['errors'] ?? null);
    }

    /**
     * GET /api/download?signed={url}
     * or /api/download/{token}
     */
    public function download(): ResponseInterface
    {
        $token = $this->request->getGet('signed') ?? $this->request->getVar('token');
        if (!$token) {
            return $this->respondError('Token de download ausente.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $response = $this->fileUploadService->serveSignedUrl($token); // will send file or return structured error

        // If it's an array, it's an error from the service
        if (is_array($response)) {
            return $this->respondError(
                $response['message'] ?? 'Não foi possível fazer o download.',
                $response['code'] ?? ResponseInterface::HTTP_NOT_FOUND
            );
        }

        // If serveSignedUrl floated response (stream), it already sent headers and exited.
        // We return the response object, which might have been modified by the service.
        return $this->response;
    }
}
