<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DiabetesType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'diabetes_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('diabetes_type');
    }

    public function down()
    {
        $this->forge->dropTable('diabetes_type');
    }
}
