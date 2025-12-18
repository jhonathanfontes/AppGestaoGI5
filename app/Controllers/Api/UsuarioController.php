<?php

namespace App\Controllers\Api;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class UsuarioController extends BaseController
{
    /**
     * Cria um novo usuário a partir de um JSON.
     *
     * @return ResponseInterface
     */

    public function getAll()
    {
        try {
            $usuario = new UsuarioModel();
            $data = $usuario->findAll();
            return $this->respondSuccess($data, 'Busca de usuários realizada com sucesso.');
        } catch (\Exception $e) {
            return $this->respondError(
                'Ocorreu um erro ao buscar os usuários.',
                ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                null,
                $e
            );
        }
    }

    public function show($id = null)
    {
        try {
            $usuario = new UsuarioModel();
            $data = $usuario->find($id);
            return $this->respondSuccess($data, 'Busca de usuário realizada com sucesso.');
        } catch (\Exception $e) {
            return $this->respondError(
                'Ocorreu um erro ao buscar o usuário.',
                ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                null,
                $e
            );
        }
    }

}
