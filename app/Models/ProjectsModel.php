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
        'startDate', 'endDate', 'status', 'dateCreated', 'dateModified','description'
    ];

    public function getProjectsWithJoins($userID, $role)
{
    $builder = $this->select('
                projects.*, 
                clients.name as clientName, 
                department.name as deptName, 
                organization.name as orgName
            ')
        ->join('clients', 'clients.clientID = projects.clientID', 'left')
        ->join('department', 'department.deptID = projects.deptID', 'left')
        ->join('organization', 'organization.orgID = projects.orgID', 'left');

    // If not admin, restrict by user ID
    if ($role !== 'admin') {
        $builder->join('userprojects', 'userprojects.projectID = projects.projectID')
                ->where('userprojects.userID', $userID);
    }

    return $builder->findAll();
}



    protected $useTimestamps = false;
}
