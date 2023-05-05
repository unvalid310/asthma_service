<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BloodSugarLimit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'age_range_id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'checking_type_id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('age_range_id', 'age_range', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('checking_type_id', 'checking_type', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('blood_sugar_limit');
    }

    public function down()
    {
        $this->forge->dropTable('blood_sugar_limit');
    }
}
