<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Twig\TwigFactory;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $twig;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
    }

    public function login()
    {
        return $this->twig->render('login.html.twig', [
            'titulo' => 'Página Inicial',
            'error' => session('error')
        ]);
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UsuarioModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user', $user);
            return redirect()->to('/');
        } else {
            return redirect()->back()->withInput()->with('error', 'Credenciais inválidas.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function index()
    {
        $userModel = new UsuarioModel();
        $users = $userModel->findAll();

        return $this->twig->render('usuario/index.html.twig', [
            'titulo' => 'Listagem de Usuários',
            'users' => $users
        ]);
    }

    public function new()
    {
        return $this->twig->render('usuario/new.html.twig', [
            'titulo' => 'Novo Usuário'
        ]);
    }

    public function create()
    {
        // Pega os dados da requisição (JSON)
        $data = $this->request->getJSON(true);
        
        // Renomeia 'password' para 'senha' para consistência com o novo schema
        if(isset($data['password'])) {
            $data['senha'] = $data['password'];
            unset($data['password']);
        }

        // Adicionar o usuário logado como criador
        $data['criado_por'] = session('user.id');

        $userModel = new UsuarioModel();

        try {
            if ($userModel->insert($data) === false) {
                $response = [
                    'status' => 'error',
                    'message' => 'Erro de validação',
                    'data' => $userModel->errors(),
                    'code' => 422
                ];
                return $this->response->setJSON($response)->setStatusCode(422);
            }

            $newUserId = $userModel->getInsertID();
            $user = $userModel->find($newUserId);

            $response = [
                'status' => 'success',
                'message' => 'Usuário criado com sucesso!',
                'data' => $user
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
