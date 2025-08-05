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
