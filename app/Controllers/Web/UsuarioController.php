<?php

namespace App\Controllers\Web;

use App\Libraries\Twig\TwigFactory;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $twig;
    protected $usuarioModel;

    public function __construct()
    {
        $this->twig = TwigFactory::get();
        $this->usuarioModel = new UsuarioModel();
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

        $user = $this->usuarioModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user', $user);
            return redirect()->to('/home');
        } else {
            return redirect()->back()->withInput()->with('error', 'Credenciais inválidas.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function index()
    {
        $users = $this->usuarioModel->findAll();

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
}
