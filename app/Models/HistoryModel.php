<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $DBGroup='default' ;
    protected $table='history' ;
    protected $primaryKey='id' ;
    protected $useAutoIncrement=true;
    protected $insertID=0;
    protected $returnType='object';
    protected $useSoftDeletes=false;
    protected $protectFields=true;
    protected $allowedFields=[
      'user_id',
      'date',
      'body',
      'envi',
      'mind'
    ];

    // Dates
    protected $useTimestamps=true;
    protected $dateFormat='datetime' ;
    protected $createdField='created_at' ;
    protected $updatedField='updated_at' ;
    protected $deletedField='deleted_at' ;

    // Validation
    protected $validationRules=[];
    protected $validationMessages=[];
    protected $skipValidation=false;
    protected $cleanValidationRules=true;
}
