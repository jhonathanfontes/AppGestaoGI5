<?php

namespace App\Controllers;

use App\Libraries\Twig\TwigRenderer;
use CodeIgniter\Controller;

class DevTools extends Controller
{
    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        // Segurança: apenas desenvolvimento
        if (ENVIRONMENT !== 'development') {
            echo "DevTools só estão disponíveis em DEVELOPMENT.";
            exit;
        }
    }

    public function index()
    {
        $renderer = new TwigRenderer();

        return $renderer->render('devtools/dashboard', [
            'titulo' => 'Página Inicial',
            'usuario' => ['nome' => 'Rafael']
        ]);
    }

    public function build()
    {
        $php = PHP_BINARY;
        $spark = ROOTPATH . 'spark';

        exec("{$php} {$spark} assets:build-full", $out);

        return $this->response->setJSON([
            'status' => 'success',
            'output' => $out
        ]);
    }

    public function clearCache()
    {
        $cache = WRITEPATH . 'cache/twig';

        if (is_dir($cache)) {
            helper('filesystem');
            delete_files($cache, true);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Cache Twig removido.'
        ]);
    }

    public function status()
    {
        $modules = [];
        $devPath = ROOTPATH . 'development/assets/';

        foreach (glob($devPath . '*', GLOB_ONLYDIR) as $folder) {
            $modules[] = basename($folder);
        }

        return $this->response->setJSON([
            'env' => ENVIRONMENT,
            'modules' => $modules
        ]);
    }
}
