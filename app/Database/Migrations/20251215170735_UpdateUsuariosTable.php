<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsuariosTable extends Migration
{
    public function up()
    {
        // Renomear a coluna 'password' para 'senha'
        $this->forge->modifyColumn('usuarios', [
            'password' => [
                'name' => 'senha',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        // Adicionar as novas colunas
        $this->forge->addColumn('usuarios', [
            'pessoa_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true, // Permitir nulo por enquanto
            ],
            'login_tentativas' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0,
            ],
            'bloqueado_ate' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'primeiro_acesso' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'token_ativacao' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'token_esqueci_senha' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'token_expira_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'ultima_atividade' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'ativo' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'criado_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'atualizado_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deletado_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'criado_por' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
            ],
            'atualizado_por' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
            ],
            'deletado_por' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        // Remover a coluna 'nome'
        $this->forge->dropColumn('usuarios', 'nome');
    }

    public function down()
    {
        // Reverter as alterações
        $this->forge->addColumn('usuarios', [
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->dropColumn('usuarios', [
            'pessoa_id', 'login_tentativas', 'bloqueado_ate', 'primeiro_acesso',
            'token_ativacao', 'token_esqueci_senha', 'token_expira_em',
            'ultima_atividade', 'ativo', 'criado_em', 'atualizado_em',
            'deletado_em', 'criado_por', 'atualizado_por', 'deletado_por'
        ]);

        $this->forge->modifyColumn('usuarios', [
            'senha' => [
                'name' => 'password',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
    }
}
