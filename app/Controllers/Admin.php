<?php

namespace App\Controllers;
use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\OrganizationModel;
use App\Models\DepartmentModel;
use App\Models\ClientsModel;

class Admin extends BaseController
{
    public function users()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $data = [
            'title' => 'Manage Users',
            'breadcrumbs' => 'Manage Users',
        ];
        return view('admin/users', $data);
    }

    public function usersAjax()
    {
        $request = service('request');
        $userModel = new UserModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $userModel->select('userID, name, email, role');

        if (!empty($search)) {
            $userModel->groupStart()
                      ->like('name', $search)
                      ->orLike('email', $search)
                      ->orLike('role', $search)
                      ->groupEnd();
        }

        $totalFiltered = $userModel->countAllResults(false);
        $users = $userModel->findAll($length, $start);

        $result = [];
        $i = $start + 1;
        foreach ($users as $user) {
            $result[] = [
                'no'       => $i++,
                'username' => $user['name'],
                'email'    => $user['email'],
                'id'        =>$user['userID'],
                'role'     => ucfirst($user['role']),
            ];
        }

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $userModel->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data'            => $result,
        ];

        return $this->response->setJSON($output);
    }

    public function createUser()
    {
        $data = [
            'title' => 'Create User',
            'breadcrumbs' => 'Create User',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();

        $userModel = new \App\Models\UserModel(); 
        $data['users'] = $userModel->findAll();
        
        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();

        return view('admin/createUser', $data);
    }
    
   public function addUser()
    {
        $userModel = new UserModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $userID = $this->request->getPost('userID');

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'orgID'    => $this->request->getPost('orgID'),
            'deptID'   => $this->request->getPost('deptID'),
            'role'     => $this->request->getPost('role'),
            'status'   => $this->request->getPost('status'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if (!empty($userID)) {
            // Update existing user
            $data['updated_at'] = date('Y-m-d H:i:s');
            $userModel->update($userID, $data);
            $message = 'User updated successfully.';
        } else {
            // Create new user
            $data['dateCreated'] = date('Y-m-d H:i:s');
            $userModel->insert($data);
            $userID = $userModel->getInsertID();
            $message = 'User created successfully.';
        }

        return redirect()->to(base_url('admin/users'))->with('success', $message);
    }

    public function editUser($userID)
    {
        $userModel = new \App\Models\UserModel();
        $organizationModel = new \App\Models\OrganizationModel();
        $departmentModel = new \App\Models\DepartmentModel();
        $clientsModel = new \App\Models\ClientsModel();

        $user = $userModel->find($userID);

        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $data = [
            'title'         => 'Edit User',
            'breadcrumbs'   => 'Edit User',
            'user'          => $user,
            'organizations' => $organizationModel->findAll(),
            'departments'   => $departmentModel->findAll(),
            'clients'       => $clientsModel->findAll(),
        ];
        //  dd($data);
        return view('admin/createUser', $data);
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

    public function organizations()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $data = [
            'title' => 'Manage Organizations',
            'breadcrumbs' => 'Manage Organizations',
        ];

        return view('admin/organizations', $data);
    }

    public function createOrganizations()
    {
        $data = [
            'title' => 'Create User',
            'breadcrumbs' => 'Create User',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();

        $userModel = new \App\Models\UserModel(); 
        $data['users'] = $userModel->findAll();


        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();

        return view('admin/createOrganization', $data);
    }

    public function addOrganizations()
    {
        $organizationModel = new OrganizationModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $data = [
            'name'        => $this->request->getPost('name'),
            'status'       => $this->request->getPost('status'),
            'address'       => $this->request->getPost('address'),
            'dateCreated' => date('Y-m-d H:i:s'),
        ];

        $organizationModel->insert($data);

        return redirect()->to(base_url('admin/organizations'))->with('success', 'Organization created successfully.');
    }

    public function organizationsAjax()
    {
        $request = service('request');
        $orgModel = new OrganizationModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $orgModel->select('orgID, name, status');

        if (!empty($search)) {
            $orgModel->groupStart()
                     ->like('name', $search)
                     ->orLike('status', $search)
                     ->groupEnd();
        }

        $totalFiltered = $orgModel->countAllResults(false);
        $orgs = $orgModel->findAll($length, $start);

        $result = [];
        $i = $start + 1;
        foreach ($orgs as $org) {
            $result[] = [
                'no'            => $i++,
                'organization'  => $org['name'],
                'status'         => $org['status'],
            ];
        }

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $orgModel->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data'            => $result,
        ];

        return $this->response->setJSON($output);
    }

    public function departments()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $data = [
            'title' => 'Manage Departments',
            'breadcrumbs' => 'Manage Departments',
        ];

        return view('admin/departments', $data);
    }

    public function createDepartments()
    {
        $data = [
            'title' => 'Create Department',
            'breadcrumbs' => 'Create Department',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();

        $userModel = new \App\Models\UserModel(); 
        $data['users'] = $userModel->findAll();

        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();

        return view('admin/createDepartment', $data);
    }

    public function addDepartments()
    {
        $departmentModel = new DepartmentModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $data = [
            'name'        => $this->request->getPost('name'),
            'orgID'       => $this->request->getPost('orgID'),
            'status'       => $this->request->getPost('status'),
            'dateCreated' => date('Y-m-d H:i:s'),
        ];

        $departmentModel->insert($data);

        return redirect()->to(base_url('admin/departments'))->with('success', 'Department created successfully.');
    }

    public function departmentsAjax()
    {
        $request = service('request');
        $deptModel = new DepartmentModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $deptModel->select('deptID, name,status');

        if (!empty($search)) {
            $deptModel->groupStart()
                      ->like('name', $search)
                      ->groupEnd();
        }

        $totalFiltered = $deptModel->countAllResults(false);
        $departments = $deptModel->findAll($length, $start);

        $result = [];
        $i = $start + 1;
        foreach ($departments as $department) {
            $result[] = [
                'no'         => $i++,
                'department' => $department['name'],
                'status'     => $department['status'],
            ];
        }

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $deptModel->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data'            => $result,
        ];


        return $this->response->setJSON($output);
    }

    public function clients()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }
        $data = [
            'title' => 'Manage Clients',
            'breadcrumbs' => 'Manage Clients',
        ];

        return view('admin/clients', $data);
    }

    public function createClient()
    {
        $data = [
            'title' => 'Create Client',
            'breadcrumbs' => 'Create Client',
        ];

        $organizationModel = new OrganizationModel();
        $departmentModel = new DepartmentModel();
        $clientsModel = new ClientsModel();

        $userModel = new \App\Models\UserModel(); 
        $data['users'] = $userModel->findAll();

        $data['organizations'] = $organizationModel->findAll();
        $data['departments'] = $departmentModel->findAll();
        $data['clients'] = $clientsModel->findAll();

        return view('admin/createClient', $data);
    }

    public function addClient()
    {
        $clientsModel = new ClientsModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $data = [
            'name'        => $this->request->getPost('name'),
            'address'       => $this->request->getPost('address'),
            'status'       => $this->request->getPost('status'),
            'dateCreated' => date('Y-m-d H:i:s'),
        ];

        $clientsModel->insert($data);

        return redirect()->to(base_url('admin/clients'))->with('success', 'Department created successfully.');
    }

    public function clientsAjax()
    {
        $request = service('request');
        $clientsModel = new ClientsModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $clientsModel->select('clientID, name, status');

        if (!empty($search)) {
            $clientsModel->groupStart()
                         ->like('name', $search)
                         ->orLike('status', $search)
                         ->groupEnd();
        }

        $totalFiltered = $clientsModel->countAllResults(false);
        $clients = $clientsModel->findAll($length, $start);

        $result = [];
        $i = $start + 1;
        foreach ($clients as $client) {
            $result[] = [
                'no'         => $i++,
                'client'    => $client['name'],
                'status'    => ucfirst($client['status']),
            ];
        }

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $clientsModel->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data'            => $result,
        ];

        return $this->response->setJSON($output);
    }
}
