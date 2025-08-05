<?php

namespace App\Controllers\Project;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\OrganizationModel;
use App\Models\DepartmentModel;
use App\Models\ClientsModel;
use App\Models\UserProjectsModel;
use App\Models\TasksModel;

class Project extends BaseController
{
    public function index()
    {
        $model = new ProjectsModel();
        $userID = session()->get('userID');
        $role = session()->get('role');
        $taskStats = $this->getTaskStatsByProject();

        $projects = $model->getProjectsWithJoins($userID, $role);

        $data = [
            'title' => 'Project Overview',
            'breadcrumbs' => 'My Project',
            'projects' => $projects,
            'taskStats'   => $taskStats,

        ];

        return view('project/project_overview', $data);
    }

    public function archive()
    {
        $db     = \Config\Database::connect();
        $userID = session()->get('userID');
        $role   = session()->get('role');

        $builder = $db->table('projects')
            ->select('projects.*, clients.name AS clientName, department.name AS deptName')
            ->join('clients', 'clients.clientID = projects.clientID', 'left')
            ->join('department', 'department.deptID = projects.deptID', 'left')
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'left')
            ->where('projects.status', 'archived');

        if ($role !== 'admin') {
            $builder->where('userprojects.userID', $userID);
        }

        $projects = $builder->get()->getResultArray();

        $data = [
            'title'       => 'Archived Projects',
            'breadcrumbs' => 'Archived Projects',
            'projects'    => $projects,
        ];

        return view('project/archived', $data);
    }


    public function create()
    {
        $data = [
            'title' => 'Create Project',
            'breadcrumbs' => 'Create Project',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();

        $userModel = new \App\Models\UserModel(); 
        $data['users'] = $userModel->findAll();


        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();

        return view('project/create', $data);
    }

   public function createProject()
    {
        $model = new ProjectsModel();
        $userProjectModel = new UserProjectsModel();
        $now = date('Y-m-d H:i:s');

        $data = [
            'orgID'        => $this->request->getPost('orgID'),
            'deptID'       => $this->request->getPost('deptID'),
            'clientID'     => $this->request->getPost('clientID'),
            'name'         => $this->request->getPost('name'),
            'startDate'    => $this->request->getPost('startDate'),
            'endDate'      => $this->request->getPost('endDate'),
            'status'       => $this->request->getPost('status'),
            'description'  => $this->request->getPost('description'),
            'contractValue' => $this->request->getPost('contractValue'),
            'cost' => $this->request->getPost('cost'),
            'dateCreated'  => $now,
            'dateModified' => $now,
        ];

        $model->insert($data);

        $projectID = $model->getInsertID();

        $userIDs = $this->request->getPost('userID'); 
        $roles   = $this->request->getPost('roles');  

        if (!empty($userIDs)) {
            foreach ($userIDs as $i => $userID) {
        $userProjectModel->insert([
            'projectID' => $projectID,
            'userID'    => $userID,
            'role'      => $roles[$i] ?? 'developer',
        ]);
    }

        }

        return redirect()->to(base_url('project/project'))->with('success', 'Project created successfully.');
    }

    public function edit($projectID)
    {
        $data = [
            'title' => 'Edit Project',
            'breadcrumbs' => 'Edit Project',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();
        $userModel = new \App\Models\UserModel();
        $projectModel = new \App\Models\ProjectsModel();
        $userProjectModel = new \App\Models\UserProjectsModel();

        $project = $projectModel->find($projectID);
        if (!$project) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Project not found");
        }
        $data['project'] = $project;
        $data['users'] = $userModel->findAll();


        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();
        $data['assignedUsers'] = $userProjectModel
        ->where('projectID', $projectID)
        ->findAll();


        return view('project/edit', $data);
    }

    public function updateProject($projectID)
    {
        $model = new ProjectsModel();
        $userProjectModel = new UserProjectsModel();
        $now = date('Y-m-d H:i:s');

        // Update project data
        $data = [
            'orgID'        => $this->request->getPost('orgID'),
            'deptID'       => $this->request->getPost('deptID'),
            'clientID'     => $this->request->getPost('clientID'),
            'name'         => $this->request->getPost('name'),
            'startDate'    => $this->request->getPost('startDate'),
            'endDate'      => $this->request->getPost('endDate'),
            'status'       => $this->request->getPost('status'),
            'description'  => $this->request->getPost('description'),
            'contractValue' => $this->request->getPost('contractValue'),
            'cost' => $this->request->getPost('cost'),
            'dateModified' => $now,
        ];

        $model->update($projectID, $data);

        // Remove old assignments
        $userProjectModel->where('projectID', $projectID)->delete();

        // Re-insert new assignments
        $userIDs = $this->request->getPost('userID'); 
        $roles   = $this->request->getPost('roles');  

        if (!empty($userIDs)) {
            foreach ($userIDs as $i => $userID) {
                $userProjectModel->insert([
                    'projectID' => $projectID,
                    'userID'    => $userID,
                    'role'      => $roles[$i] ?? 'developer',
                ]);
            }
        }

       session()->setFlashdata('success', 'Project updated successfully!');
        return redirect()->to('/project/project'); 

    }

        public function view($projectID)
    {
        $data = [
            'title' => 'View Project',
            'breadcrumbs' => 'View Project',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();
        $userModel = new \App\Models\UserModel();
        $projectModel = new \App\Models\ProjectsModel();
        $userProjectModel = new \App\Models\UserProjectsModel();

        $project = $projectModel->find($projectID);
        if (!$project) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Project not found");
        }
        $data['project'] = $project;
        $data['users'] = $userModel->findAll();


        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();
        $data['assignedUsers'] = $userProjectModel
        ->where('projectID', $projectID)
        ->findAll();


        return view('project/view', $data);
    }

    public function getTaskStatsByProject()
    {
        $tasksModel = new TasksModel(); 

        $taskStats = $tasksModel
            ->select("projectID,
                    COUNT(*) as total_tasks,
                    SUM(CASE WHEN status IN ('To Do', 'In Progress', 'In Review') THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as total_completed")
            ->groupBy('projectID')
            ->findAll();

        $statsMap = [];
        foreach ($taskStats as $stat) {
            $statsMap[$stat['projectID']] = $stat;
        }

        return $statsMap;
    }


}


