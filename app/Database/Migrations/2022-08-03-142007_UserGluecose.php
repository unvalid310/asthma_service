<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGluecose extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'checking_date' => [
                'type' => 'datetime',
                'null' => FALSE,
            ],
            'checking_type' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'checking_time' => [
                'type' => 'time',
                'null' => FALSE,
            ],
            'sugar_level' => [
                'type' => 'INT',
                'constraimt' => 1,
                'null' => FALSE
            ],
            'sleep_duration' => [
                'type' => 'INT',
                'constraimt' => 1,
                'null' => FALSE
            ],
            'sport_type_id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sport_type_id', 'sport_type', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_gluecose');
    }

    public function down()
    {
        $this->forge->dropTable('user_gluecose');
    }
}
