<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectsModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'projectID';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $allowedFields    = [
        'orgID', 'deptID', 'clientID', 'name',
        'startDate', 'endDate', 'status', 'dateCreated', 'dateModified'
    ];

    protected $useTimestamps = false;
}
