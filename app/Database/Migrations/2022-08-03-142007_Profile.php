<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profile extends Migration
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
            'gender' => [
                'type' => 'ENUM("Male","Female")',
                'null' => FALSE
            ],
            'date_of_birth' => [
                'type' => 'datetime',
                'null' => FALSE
            ],
            'weight' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'height' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'diabetes_type_id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'isStress' => [
                'type' => 'ENUM("Yess","No")',
                'null' => FALSE
            ],
            'isSmoke' => [
                'type' => 'ENUM("Yess","No")',
                'null' => FALSE
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
        $this->forge->addForeignKey('diabetes_type_id', 'diabetes_type', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('profile');
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}
