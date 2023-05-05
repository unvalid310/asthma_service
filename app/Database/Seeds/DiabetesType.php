<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiabetesType extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'diabetes_type' => 'Pradiabetes',
            ],
            [
                'id' => 2,
                'diabetes_type' => 'Diabetes Type 1',
            ],
            [
                'id' => 3,
                'diabetes_type' => 'Diabetes Type 2',
            ],
        ];
        $this->db->table('diabetes_type')->insertBatch($data);
    }
}
