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
}
