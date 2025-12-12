<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\FileUploadService;

class UploadController extends BaseController
{
    protected $u;

    public function __construct()
    {
        $this->u = new FileUploadService();
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
    public function upload()
    {
        $module  = $this->request->getPost('module') ?? 'default';
        $field   = $this->request->getPost('field') ?? 'file';
        $type    = $this->request->getPost('type') ?? 'imagem';
        $subtype = $this->request->getPost('subtype') ?? null;

        $result = $this->u->upload($module, $field, $type, $subtype);

        return $this->response->setJSON($result);
    }

    /**
     * GET /api/download?signed={url}
     * or /api/download/{token}
     */
    public function download()
    {
        $token = $this->request->getGet('signed') ?? $this->request->getVar('token');
        if (!$token) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'missing token']);
        }

        $res = $this->u->serveSignedUrl($token); // will send file or return structured error
        if (is_array($res)) {
            return $this->response->setStatusCode($res['code'] ?? 404)->setJSON($res);
        }
        // If serveSignedUrl floated response (stream), it already sent headers and exit; else return
        return $this->response;
    }
}
