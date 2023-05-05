<?php

namespace App\Models;

use CodeIgniter\Model;

class EnvironmemtModel extends Model
{
    protected $DBGroup='default' ;
    protected $table='environment' ;
    protected $primaryKey='id' ;
    protected $useAutoIncrement=true;
    protected $insertID=0;
    protected $returnType='object';
    protected $useSoftDeletes=false;
    protected $protectFields=true;
    protected $allowedFields    = [
        'user_id',
        'temperature',
        'humidity',
        'co2',
    ];

    // Dates
    protected $useTimestamps=true;
    protected $dateFormat='datetime' ;
    protected $createdField='created_at' ;
    protected $updatedField='updated_at' ;
    protected $deletedField='deleted_at' ;
}
