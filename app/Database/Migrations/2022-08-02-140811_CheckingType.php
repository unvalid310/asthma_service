<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CheckingType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'checking_type' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('checking_type');
    }

    public function down()
    {
        $this->forge->dropTable('checking_type');
    }
}
