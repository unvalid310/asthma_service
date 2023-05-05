<?php

namespace App\Models;

use CodeIgniter\Model;

class BodyModel extends Model
{
    protected $DBGroup          = 'default' ;
    protected $table            = 'body' ;
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'heart_rate',
        'spo2',
        'sleeping_quality',
    ];

    // Dates
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime' ;
    protected $createdField     = 'created_at' ;
    protected $updatedField     = 'updated_at' ;
    protected $deletedField     = 'deleted_at' ;
}
