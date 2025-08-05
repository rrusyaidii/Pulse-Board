<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'deptID';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $allowedFields = ['orgID', 'name', 'status', 'dateCreated', 'dateModified'];

    protected $useTimestamps = false;
}
