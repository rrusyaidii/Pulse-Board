<?php

namespace App\Controllers\Project;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\OrganizationModel;
use App\Models\DepartmentModel;
use App\Models\ClientsModel;
use App\Models\UserProjectsModel;

class Project extends BaseController
{
    public function index()
{
    $model = new ProjectsModel();
    $userID = session()->get('userID');
    $role = session()->get('role');

    // ✅ Pass both userID and role
    $projects = $model->getProjectsWithJoins($userID, $role);

    $data = [
        'title' => 'Project Overview',
        'breadcrumbs' => 'My Project',
        'projects' => $projects,
    ];

    return view('project/project_overview', $data);
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

}


