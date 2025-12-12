<?php

namespace App\Controllers;

use App\Services\FileUploadService;

class Upload extends BaseController
{
    public function index()
    {
        return view('upload_form');
    }

    public function do_upload()
    {
        $uploadService = new FileUploadService();

        // Exemplo de upload de avatar
        $result = $uploadService->upload('usuarios', 'foto', 'imagem', 'avatar');

        if ($result['success']) {
            // Salvar $result['file'] no banco de dados, etc.
            return "Upload de avatar bem-sucedido! Arquivo: " . $result['file'];
        } else {
            return "Falha no upload do avatar: " . $result['message'];
        }
    }
    
    public function do_upload_cert()
    {
        $uploadService = new FileUploadService();

        // Exemplo de upload de certificado
        $result = $uploadService->upload('usuarios', 'certificado', 'documento', 'certificado');

        if ($result['success']) {
            return "Upload de certificado bem-sucedido! Arquivo: " . $result['file'];
        } else {
            return "Falha no upload do certificado: " . $result['message'];
        }
    }

    public function download($module, $type, $subtype, $filename)
    {
        $uploadService = new FileUploadService();
        $relativePath = "{$module}/{$type}/{$subtype}/{$filename}";
        return $uploadService->getFile($relativePath);
    }
}
