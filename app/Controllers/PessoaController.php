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
        // Pega os dados da requisição (JSON)
        $data = $this->request->getJSON(true);

        // Adicionar o usuário logado como criador
        $data['criado_por'] = session('user.id');

        $pessoaModel = new PessoaModel();

        try {
            if ($pessoaModel->insert($data) === false) {
                $response = [
                    'status' => 'error',
                    'message' => 'Erro de validação',
                    'data' => $pessoaModel->errors(),
                    'code' => 422
                ];
                return $this->response->setJSON($response)->setStatusCode(422);
            }

            $newPessoaId = $pessoaModel->getInsertID();
            $pessoa = $pessoaModel->find($newPessoaId);

            $response = [
                'status' => 'success',
                'message' => 'Pessoa criada com sucesso!',
                'data' => $pessoa
            ];
            return $this->response->setJSON($response);

        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Ocorreu um erro inesperado',
                'data' => (ENVIRONMENT === 'development') ? $e->getMessage() : null,
                'code' => 500
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
