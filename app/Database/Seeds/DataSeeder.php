<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('AgeRangeSeed');
        $this->call('CheckingType');
        $this->call('DiabetesType');
        $this->call('SportType');
    }
}
