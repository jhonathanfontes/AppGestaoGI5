<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUploadsQueueTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'relative_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '512',
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'payload' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'pending',
            ],
            'attempts' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'processed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('uploads_queue');
    }

    public function down()
    {
        $this->forge->dropTable('uploads_queue');
    }
}
