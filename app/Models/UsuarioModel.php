<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'password'];

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'password' => 'required',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Este email já está em uso. Por favor, escolha outro.',
        ],
    ];

    protected $beforeInsert = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
