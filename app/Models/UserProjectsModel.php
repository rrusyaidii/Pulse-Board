<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProjectsModel extends Model
{
    protected $table            = 'userprojects';

    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['userID', 'projectID', 'role'];
    protected $useTimestamps    = false;

    public function insert($data = null, bool $returnID = true)
    {
        return $this->builder()->insert($data);
    }
}
