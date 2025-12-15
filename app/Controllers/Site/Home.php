<?php
namespace App\Controllers\Site;

use App\Controllers\BaseController;
use App\Libraries\Twig\TwigFactory;

class Home extends BaseController
{
    protected $twig;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
    }

    public function index()
    {
        return $this->twig->render('home.html.twig', [
            'titulo' => 'Página Inicial',
            'usuario' => session('user')
        ]);
    }
}
