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
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        $userModel = new UsuarioModel();

        try {
            if ($userModel->insert($data) === false) {
                return redirect()->back()->withInput()->with('errors', $userModel->errors());
            }
        } catch (\Exception $e) {
            log_message('error', 'Erro ao inserir usuário: ' . $e->getMessage());
            if (ENVIRONMENT === 'development') {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro inesperado ao salvar o usuário. Por favor, contate o suporte.');
        }

        return redirect()->to('/configuracao/usuarios');
    }
}
