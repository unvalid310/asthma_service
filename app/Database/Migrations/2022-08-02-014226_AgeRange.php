<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgeRange extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'age' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('age_range');
    }

    public function down()
    {
        $this->forge->dropTable('age_range');
    }
}
