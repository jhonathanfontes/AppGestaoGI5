<?php

namespace App\Controllers\Web;

use App\Libraries\Twig\TwigFactory;
use App\Models\EmpresaModel;

class EmpresaController extends BaseController
{
    protected $twig;
    protected $empresaModel;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
        $this->empresaModel = new EmpresaModel();
    }

    public function index()
    {
        $empresas = $this->empresaModel->findAll();

        return $this->twig->render('empresa/index.html.twig', [
            'titulo' => 'Listagem de Empresas',
            'empresas' => $empresas,
        ]);
    }

    public function new()
    {
        return $this->twig->render('empresa/new.html.twig', [
            'titulo' => 'Nova Empresa',
        ]);
    }
}
