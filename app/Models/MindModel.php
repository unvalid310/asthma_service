<?php

namespace App\Models;

use CodeIgniter\Model;

class MindModel extends Model
{
    protected $DBGroup='default' ;
    protected $table='mind' ;
    protected $primaryKey='id' ;
    protected $useAutoIncrement=true;
    protected $insertID=0;
    protected $returnType='object';
    protected $useSoftDeletes=false;
    protected $protectFields=true;
    protected $allowedFields    = [
        'user_id',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
        'q6',
        'q7',
        'q8',
        'q9',
        'q10',
    ];

    // Dates
    protected $useTimestamps=true;
    protected $dateFormat='datetime' ;
    protected $createdField='created_at' ;
    protected $updatedField='updated_at' ;
    protected $deletedField='deleted_at' ;
}
