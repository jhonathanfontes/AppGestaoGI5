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
        // Pega os dados da requisição (JSON)
        $data = $this->request->getJSON(true);

        // Adicionar o usuário logado como criador
        $data['criado_por'] = session('user.id');

        $empresaModel = new EmpresaModel();

        try {
            if ($empresaModel->insert($data) === false) {
                $response = [
                    'status' => 'error',
                    'message' => 'Erro de validação',
                    'data' => $empresaModel->errors(),
                    'code' => 422
                ];
                return $this->response->setJSON($response)->setStatusCode(422);
            }

            $newEmpresaId = $empresaModel->getInsertID();
            $empresa = $empresaModel->find($newEmpresaId);

            $response = [
                'status' => 'success',
                'message' => 'Empresa criada com sucesso!',
                'data' => $empresa
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
