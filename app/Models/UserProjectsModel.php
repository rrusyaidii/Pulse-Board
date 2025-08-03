<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProjectsModel extends Model
{
    protected $table            = 'userprojects';
    protected $primaryKey       = ['userID', 'projectID']; // Composite PK

    protected $returnType       = 'array';
    protected $allowedFields    = ['userID', 'projectID', 'role'];

    public $useAutoIncrement = false;
    protected $useTimestamps = false;
}
