<?php
namespace App\Controllers\Site;

use App\Controllers\BaseController;
use App\Libraries\Twig\TwigRenderer;

class Home extends BaseController
{
    public function index()
    {
        $renderer = new TwigRenderer();

        return $renderer->render('home', [
            'titulo' => 'Página Inicial',
            'usuario' => ['nome' => 'Rafael']
        ]);
    }

    public function moduloHome()
    {
        $renderer = new TwigRenderer();

        return $renderer->render('modulo/home', [
            'titulo' => 'Home do Módulo'
        ]);
    }
}
