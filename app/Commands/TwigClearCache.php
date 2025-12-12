<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TwigClearCache extends BaseCommand
{
    protected $group = 'twig';
    protected $name  = 'twig:clear';
    protected $description = 'Limpa cache gerado pelo Twig em writable/cache/twig';

    public function run(array $params = [])
    {
        $cachePath = WRITEPATH . 'cache/twig';

        if (!is_dir($cachePath)) {
            CLI::write("Pasta de cache não existe: {$cachePath}", 'yellow');
            mkdir($cachePath, 0775, true);
            CLI::write("Pasta de cache criada: {$cachePath}", 'green');
            return;
        }

        $this->deleteDir($cachePath);
        mkdir($cachePath, 0775, true);
        CLI::write("Cache Twig limpo e recriado: {$cachePath}", 'green');
    }

    private function deleteDir(string $dir): bool
    {
        if (!is_dir($dir)) return true;
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }
        return rmdir($dir);
    }
}
