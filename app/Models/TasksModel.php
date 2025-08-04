<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'taskID';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $allowedFields    = [
        'orgID', 'projectID', 'sprintID', 'assigneeID', 'createdBy',
        'name', 'priority', 'type', 'status', 'dateCreated', 'dateModified','description'
    ];

    protected $useTimestamps = false;
}
