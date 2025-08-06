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

        $draw   = $request->getVar('draw');
        $start  = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        // Join with organization and department tables to get names
        $userModel->select('user.userID, user.name, user.email, user.orgID, user.deptID, user.role, 
                            organization.name as organization_name, 
                            department.name as department_name')
                ->join('organization', 'organization.orgID = user.orgID', 'left')
                ->join('department', 'department.deptID = user.deptID', 'left')
                ->where('user.status', 'active');

        // Apply search filters if needed
        if (!empty($search)) {
            $userModel->groupStart()
                    ->like('user.name', $search)
                    ->orLike('user.email', $search)
                    ->orLike('user.role', $search)
                    ->orLike('organization.name', $search)
                    ->orLike('department.name', $search)
                    ->groupEnd();
        }

        // Count filtered and fetch paginated users
        $totalFiltered = $userModel->countAllResults(false);
        $users = $userModel->findAll($length, $start);

        // Build response rows
        $result = [];
        $i = $start + 1;
        foreach ($users as $user) {
            $result[] = [
                'no'            => $i++,
                'id'            => $user['userID'],
                'username'      => $user['name'],
                'email'         => $user['email'],
                'organization'  => $user['organization_name'] ?? '-',
                'department'    => $user['department_name'] ?? '-',
                'role'          => ucfirst($user['role']),
            ];
        }

        // Count total active users for DataTables
        $totalActive = (new UserModel())
                        ->where('status', 'active')
                        ->countAllResults();

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalActive,
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
            // update user
            $data['dateModified'] = date('Y-m-d H:i:s');
            $userModel->update($userID, $data);
            $message = 'User updated successfully.';
        } else {
            // create new user
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
            'title'         => 'Update User',
            'breadcrumbs'   => 'Update User',
            'user'          => $user,
            'organizations' => $organizationModel->findAll(),
            'departments'   => $departmentModel->findAll(),
            'clients'       => $clientsModel->findAll(),
        ];
        
        return view('admin/createUser', $data);
    }

    public function deleteUser($userID)
    {
        $userModel = new UserModel();
        $userModel->where('userID', $userID)->set('status', 'inactive')->update();
        return redirect()->to(base_url('admin/users'))->with('success', 'User has been deleted.');
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
            'title' => 'Create Organization',
            'breadcrumbs' => 'Create Organization',
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
        
        $orgID = $this->request->getPost('orgID');

        $data = [
            'name'        => $this->request->getPost('name'),
            'status'       => $this->request->getPost('status'),
            'address'       => $this->request->getPost('address'),
            'dateCreated' => date('Y-m-d H:i:s'),
        ];

        if (!empty($orgID)) {
            // update organization
            $data['dateModified'] = date('Y-m-d H:i:s');
            $organizationModel->update($orgID, $data);
            $message = 'User updated successfully.';
        } else {
            // create new organization
            $data['dateCreated'] = date('Y-m-d H:i:s');
            $organizationModel->insert($data);
            $orgID = $organizationModel->getInsertID();
            $message = 'User created successfully.';
        }

        return redirect()->to(base_url('admin/organizations'))->with('success', $message);
    }

    public function editOrganizations($orgID)
    {
        $organizationModel = new \App\Models\OrganizationModel();
        $departmentModel = new \App\Models\DepartmentModel();
        $clientsModel = new \App\Models\ClientsModel();

        $organization = $organizationModel->find($orgID);

        if (!$organization) {
            return redirect()->to(base_url('admin/organizations'))->with('error', 'Organization not found.');
        }

        $data = [
            'title'         => 'Update Organization',
            'breadcrumbs'   => 'Update Organization',
            'org'           => $organization,
            'organizations' => $organizationModel->findAll(),
            'departments'   => $departmentModel->findAll(),
            'clients'       => $clientsModel->findAll(),
        ];
        
        return view('admin/createOrganization', $data);
    }

    public function deleteOrganizations($orgID)
    {
        $organizationModel = new \App\Models\OrganizationModel();
        $organizationModel->where('orgID', $orgID)->set('status', 'inactive')->update();
        return redirect()->to(base_url('admin/organizations'))->with('success', 'Organization has been deleted.');
    }

    public function organizationsAjax()
    {
        $request = service('request');
        $orgModel = new OrganizationModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $orgModel->select('orgID, name, address, status')->where('status', 'active');

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
                'id'            => $org['orgID'],
                'organization'  => $org['name'],
                'address'       => $org['address'],
                'status'        => $org['status'],
            ];
        }

        $totalActive = (new OrganizationModel())
                    ->where('status', 'active')
                    ->countAllResults();

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalActive,
            // 'recordsTotal'    => $orgModel->countAll(),
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

        $deptID = $this->request->getPost('deptID');

        $data = [
            'name'        => $this->request->getPost('name'),
            'orgID'       => $this->request->getPost('orgID'),
            'status'       => $this->request->getPost('status'),
            'dateCreated' => date('Y-m-d H:i:s'),
        ];

        if (!empty($deptID)) {
            // update department
            $data['dateModified'] = date('Y-m-d H:i:s');
            $departmentModel->update($deptID, $data);
            $message = 'Department updated successfully.';
        } else {
            // create new department
            $data['dateCreated'] = date('Y-m-d H:i:s');
            $departmentModel->insert($data);
            $deptID = $departmentModel->getInsertID();
            $message = 'Department created successfully.';
        }

        return redirect()->to(base_url('admin/departments'))->with('success', $message);
    }

    public function editDepartments($deptID)
    {
        $organizationModel = new \App\Models\OrganizationModel();
        $departmentModel = new \App\Models\DepartmentModel();
        $clientsModel = new \App\Models\ClientsModel();

        $department = $departmentModel->find($deptID);

        if (!$department) {
            return redirect()->to(base_url('admin/departments'))->with('error', 'Department not found.');
        }

        $data = [
            'title'         => 'Update Department',
            'breadcrumbs'   => 'Update Department',
            'department'    => $department,
            'organizations' => $organizationModel->findAll(),
            'departments'   => $departmentModel->findAll(),
            'clients'       => $clientsModel->findAll(),
        ];
        
        return view('admin/createDepartment', $data);
    }

    public function deleteDepartments($deptID)
    {
        $departmentModel = new DepartmentModel();
        $departmentModel->where('deptID', $deptID)->set('status', 'inactive')->update();
        return redirect()->to(base_url('admin/departments'))->with('success', 'Department has been deleted.');
    }

    public function departmentsAjax()
    {
        $request = service('request');
        $deptModel = new DepartmentModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $deptModel->select('deptID, name, status')->where('status', 'active');

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
                'id'         => $department['deptID'],
                'department' => $department['name'],
                'status'     => $department['status'],
            ];
        }

        $totalActive = (new DepartmentModel())
                    ->where('status', 'active')
                    ->countAllResults();

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalActive,
            // 'recordsTotal'    => $deptModel->countAll(),
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
        // dd($data);

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

        $clientID = $this->request->getPost('clientID');

        $data = [
            'name'        => $this->request->getPost('name'),
            'address'       => $this->request->getPost('address'),
            'status'       => $this->request->getPost('status'),
            'dateCreated' => date('Y-m-d H:i:s'),
        ];

        if (!empty($clientID)) {
            // update client
            $data['dateModified'] = date('Y-m-d H:i:s');
            $clientsModel->update($clientID, $data);
            $message = 'Client updated successfully.';
        } else {
            // create new client
            $data['dateCreated'] = date('Y-m-d H:i:s');
            $clientsModel->insert($data);
            $clientID = $clientsModel->getInsertID();
            $message = 'Client created successfully.';
        }

        return redirect()->to(base_url('admin/clients'))->with('success', $message);
    }

    public function editClient($clientID)
    {
        $userModel = new \App\Models\UserModel();
        $organizationModel = new \App\Models\OrganizationModel();
        $departmentModel = new \App\Models\DepartmentModel();
        $clientsModel = new \App\Models\ClientsModel();

        $client = $clientsModel->find($clientID);

        if (!$client) {
            return redirect()->to(base_url('admin/clients'))->with('error', 'Client not found.');
        }

        $data = [
            'title'         => 'Update Client',
            'breadcrumbs'   => 'Update Client',
            'client'        => $client,
            'organizations' => $organizationModel->findAll(),
            'departments'   => $departmentModel->findAll(),
            'clients'       => $clientsModel->findAll(),
        ];
        
        return view('admin/createClient', $data);
    }

    public function deleteClient($clientID)
    {
        $clientsModel = new ClientsModel();
        $clientsModel->where('clientID', $clientID)->set('status', 'inactive')->update();
        return redirect()->to(base_url('admin/clients'))->with('success', 'Client has been deleted.');
    }

    public function clientsAjax()
    {
        $request = service('request');
        $clientsModel = new ClientsModel();

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $clientsModel->select('clientID, name, address, status')->where('status', 'active');

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
                'id'         => $client['clientID'],
                'client'    => $client['name'],
                'address'   => $client['address'],
                'status'    => ucfirst($client['status']),
            ];
        }

        $totalActive = (new ClientsModel())
                    ->where('status', 'active')
                    ->countAllResults();

        $output = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalActive,
            // 'recordsTotal'    => $clientsModel->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data'            => $result,
        ];

        // dd($output);

        return $this->response->setJSON($output);
    }
}
