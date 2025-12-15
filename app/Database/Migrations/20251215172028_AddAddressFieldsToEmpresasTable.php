<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAddressFieldsToEmpresasTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('empresas', [
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
                'null' => true,
            ],
            'logradouro' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'complemento' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'bairro' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'municipio' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'uf' => [
                'type' => 'VARCHAR',
                'constraint' => '2',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('empresas', [
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'municipio',
            'uf',
        ]);
    }
}
