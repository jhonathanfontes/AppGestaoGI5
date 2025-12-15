<?php

namespace App\Models;

use CodeIgniter\Model;

class PessoaModel extends Model
{
    protected $table = 'pessoas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'empresa_id',
        'tipo',
        'nome',
        'cpf_cnpj',
        'email',
        'rg_ie',
        'data_nascimento',
        'criado_por',
        'atualizado_por',
        'deletado_por',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    // Soft Deletes
    protected $useSoftDeletes = true;

    // Validation
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[pessoas.email,id,{id}]',
        'cpf_cnpj' => 'required|is_unique[pessoas.cpf_cnpj,id,{id}]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Este email já está em uso.',
        ],
        'cpf_cnpj' => [
            'is_unique' => 'Este CPF/CNPJ já está em uso.',
        ],
    ];
}
