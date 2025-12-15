<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'email',
        'telefone',
        'site',
        'logo_relatorio',
        'plano_id',
        'data_expiracao',
        'ativo',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'municipio',
        'uf',
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
        'razao_social' => 'required|min_length[3]|max_length[255]',
        'nome_fantasia' => 'required|min_length[3]|max_length[255]',
        'cnpj' => 'required|is_unique[empresas.cnpj,id,{id}]',
        'email' => 'required|valid_email|is_unique[empresas.email,id,{id}]',
        'telefone' => 'permit_empty|max_length[20]',
        'site' => 'permit_empty|valid_url',
        'cep' => 'permit_empty|max_length[9]',
        'logradouro' => 'permit_empty|max_length[255]',
        'numero' => 'permit_empty|max_length[10]',
        'bairro' => 'permit_empty|max_length[100]',
        'municipio' => 'permit_empty|max_length[100]',
        'uf' => 'permit_empty|max_length[2]',
    ];

    protected $validationMessages = [
        'cnpj' => [
            'is_unique' => 'Este CNPJ já está em uso.',
        ],
        'email' => [
            'is_unique' => 'Este email já está em uso.',
        ],
    ];
}
