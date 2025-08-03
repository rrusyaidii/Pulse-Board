<?php

namespace App\Models;

use CodeIgniter\Model;

class SprintModel extends Model
{
    protected $table            = 'sprint';
    protected $primaryKey       = 'sprintID';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $allowedFields    = [
        'projectID', 'name', 'status', 
        'startDate', 'endDate', 'dateCreated', 'dateModified'
    ];

    protected $useTimestamps = false;
}
