<?php
namespace App\Traits;

use App\Services\FileUploadService;

trait UploadableTrait
{
    /**
     * Faz upload usando FileUploadService.
     *
     * @param string $module
     * @param string $fieldName
     * @param string $type
     * @param string|null $subtype
     * @return array
     */
    public function uploadFile(string $module, string $fieldName, string $type = 'imagem', ?string $subtype = null): array
    {
        $svc = new FileUploadService();
        return $svc->upload($module, $fieldName, $type, $subtype);
    }

    /**
     * Gera URL assinada para download.
     *
     * @param string $relativePath
     * @param int $ttl segundos
     * @return string
     */
    public function signedUrl(string $relativePath, int $ttl = 3600): string
    {
        $svc = new FileUploadService();
        return $svc->generateSignedUrl($relativePath, $ttl);
    }
}
