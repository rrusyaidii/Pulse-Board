<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationModel extends Model
{
    protected $table = 'organization';
    protected $primaryKey = 'orgID';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $allowedFields = ['name', 'address', 'status', 'dateCreated', 'dateModified'];

    protected $useTimestamps = false;
}
