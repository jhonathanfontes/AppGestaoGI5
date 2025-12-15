<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Twig\TwigFactory;
use App\Models\PessoaModel;

class PessoaController extends BaseController
{
    protected $twig;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
    }

    public function index()
    {
        $pessoaModel = new PessoaModel();
        $pessoas = $pessoaModel->findAll();

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

    public function create()
    {
        $data = [
            'empresa_id' => $this->request->getPost('empresa_id'),
            'tipo' => $this->request->getPost('tipo'),
            'nome' => $this->request->getPost('nome'),
            'cpf_cnpj' => $this->request->getPost('cpf_cnpj'),
            'email' => $this->request->getPost('email'),
            'rg_ie' => $this->request->getPost('rg_ie'),
            'data_nascimento' => $this->request->getPost('data_nascimento'),
        ];

        // Adicionar o usuário logado como criador
        $data['criado_por'] = session('user.id');

        $pessoaModel = new PessoaModel();

        if ($pessoaModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $pessoaModel->errors());
        }

        return redirect()->to('/pessoas');
    }
}
