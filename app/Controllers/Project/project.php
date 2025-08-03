<?php

namespace App\Controllers\Project;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\OrganizationModel;
use App\Models\DepartmentModel;
use App\Models\ClientsModel;

class Project extends BaseController
{
    public function index()
    {
        $model = new ProjectsModel();
        $projects = $model->getProjectsWithJoins();
        $data =[
            'title' => 'Project Overview',
            'breadcrumbs' =>'My Project',
            'projects' => $projects,
        ];
        return view('project/project_overview',$data);
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

        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();

        return view('project/create', $data);
    }

    public function createProject()
    {
        $model = new ProjectsModel();
        $now = date('Y-m-d H:i:s');

        $data = [
            'orgID' => $this->request->getPost('orgID'),
            'deptID' => $this->request->getPost('deptID'),
            'clientID' => $this->request->getPost('clientID'),
            'name' => $this->request->getPost('name'),
            'startDate' => $this->request->getPost('startDate'),
            'endDate' => $this->request->getPost('endDate'),
            'status' => $this->request->getPost('status'),
            'dateCreated' => $now,
            'dateModified' => $now,
        ];

        // dd($data);
        $model->insert($data);
        return redirect()->to(base_url('project/project'))->with('success', 'Project created successfully.');
    }

}
