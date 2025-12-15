<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Twig\TwigFactory;
use App\Models\EmpresaModel;

class EmpresaController extends BaseController
{
    protected $twig;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
    }

    public function index()
    {
        $empresaModel = new EmpresaModel();
        $empresas = $empresaModel->findAll();

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

    public function create()
    {
        $data = [
            'razao_social' => $this->request->getPost('razao_social'),
            'nome_fantasia' => $this->request->getPost('nome_fantasia'),
            'cnpj' => $this->request->getPost('cnpj'),
            'inscricao_estadual' => $this->request->getPost('inscricao_estadual'),
            'inscricao_municipal' => $this->request->getPost('inscricao_municipal'),
            'email' => $this->request->getPost('email'),
            'telefone' => $this->request->getPost('telefone'),
            'site' => $this->request->getPost('site'),
            'logo_relatorio' => $this->request->getPost('logo_relatorio'),
            'plano_id' => $this->request->getPost('plano_id'),
            'data_expiracao' => $this->request->getPost('data_expiracao'),
            'ativo' => $this->request->getPost('ativo') === 'on' ? true : false, // Checkbox
            'cep' => $this->request->getPost('cep'),
            'logradouro' => $this->request->getPost('logradouro'),
            'numero' => $this->request->getPost('numero'),
            'complemento' => $this->request->getPost('complemento'),
            'bairro' => $this->request->getPost('bairro'),
            'municipio' => $this->request->getPost('municipio'),
            'uf' => $this->request->getPost('uf'),
        ];

        // Adicionar o usuário logado como criador
        $data['criado_por'] = session('user.id');

        $empresaModel = new EmpresaModel();

        if ($empresaModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $empresaModel->errors());
        }

        return redirect()->to('/empresas');
    }
}
