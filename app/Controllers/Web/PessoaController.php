<?php

namespace App\Controllers\Web;

use App\Libraries\Twig\TwigFactory;
use App\Models\PessoaModel;

class PessoaController extends BaseController
{
    protected $twig;
    protected $pessoaModel;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
        $this->pessoaModel = new PessoaModel();
    }

    public function index()
    {
        $pessoas = $this->pessoaModel->findAll();

        return $this->twig->render('pessoa/index.html.twig', [
            'titulo' => 'Listagem de Pessoas',
            'pessoas' => $pessoas,
        ]);
    }

    public function new()
    {
        return $this->twig->render('pessoa/new.html.twig', [
            'titulo' => 'Nova Pessoa',
        ]);
    }
}
