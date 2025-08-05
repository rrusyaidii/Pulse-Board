<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;
use App\Models\UserModel;

class Task extends BaseController
{
    protected $projectsModel;
    protected $sprintModel;
    protected $tasksModel;
    protected $usersModel;

    public function __construct()
    {
        $this->projectsModel = new ProjectsModel();
        $this->sprintModel   = new SprintModel();
        $this->tasksModel    = new TasksModel();
        $this->usersModel    = new UserModel();
    }

    public function index()
    {
        $db     = \Config\Database::connect();
        $userID = session()->get('userID');
        $role   = session()->get('role');

        $builder = $db->table('projects')
            ->select('projects.*')
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner');

        if ($role !== 'admin') {
            $builder->where('userprojects.userID', $userID);
        }

        $projects = $builder->get()->getResultArray();

        return view('board/task_overview', [
            'title'       => 'Task Overview',
            'breadcrumbs' => 'Task Overview',
            'projects'    => $projects,
            'users'       => $this->usersModel->findAll(),
        ]);
    }

    public function create()
    {
        $db     = \Config\Database::connect();
        $userID = session()->get('userID');
        $role   = session()->get('role');

        $builder = $db->table('projects')
            ->select('projects.*')
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner');

        if ($role !== 'admin') {
            $builder->where('userprojects.userID', $userID);
        }

        $projects = $builder->get()->getResultArray();

        return view('board/task_create', [
            'title'       => 'Create Task',
            'breadcrumbs' => 'Create Task',
            'projects'    => $projects,
            'users'       => $this->usersModel->findAll(),
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'name'       => 'required|min_length[3]',
            'projectID'  => 'required|numeric',
            'sprintID'   => 'permit_empty|numeric',
            'priority'   => 'required',
            'type'       => 'required',
            'description'=> 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $userID = session()->get('userID');

        $data = [
            'name'        => $this->request->getPost('name'),
            'projectID'   => $this->request->getPost('projectID'),
            'sprintID'    => $this->request->getPost('sprintID') ?: null,
            'assigneeID'  => $this->request->getPost('assigneeID') ?: null,
            'priority'    => $this->request->getPost('priority'),
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'status'      => 'Backlog',
            'createdBy'   => $userID, // ✅ Track creator
            'dateCreated' => date('Y-m-d H:i:s'),
            'dateModified'=> date('Y-m-d H:i:s'),
        ];

        if ($this->tasksModel->insert($data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Task created successfully!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to create task'
        ]);
    }

    public function view($taskID)
    {
        $userID = session()->get('userID');
        $role   = session()->get('role');

        $task = $this->tasksModel->find($taskID);
        if (!$task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Task not found.');
        }

        if ($role !== 'admin' && $task['assigneeID'] != $userID && ($task['createdBy'] ?? null) != $userID) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('You do not have access to this task.');
        }

        $project  = $this->projectsModel->find($task['projectID']);
        $assignee = $task['assigneeID'] ? $this->usersModel->find($task['assigneeID']) : null;

        return view('board/task_view', [
            'title'       => 'Task Details',
            'breadcrumbs' => 'Task Details',
            'task'        => $task,
            'project'     => $project,
            'assignee'    => $assignee
        ]);
    }

    public function edit($taskID)
    {
        $userID = session()->get('userID');
        $role   = session()->get('role');

        $task = $this->tasksModel->find($taskID);
        if (!$task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Task not found.');
        }

        if ($role !== 'admin' && $task['assigneeID'] != $userID && ($task['createdBy'] ?? null) != $userID) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('You do not have access to this task.');
        }

        $db       = \Config\Database::connect();
        $builder  = $db->table('projects')
            ->select('projects.*')
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner');

        if ($role !== 'admin') {
            $builder->where('userprojects.userID', $userID);
        }

        $projects = $builder->get()->getResultArray();

        return view('board/task_edit', [
            'title'       => 'Edit Task',
            'breadcrumbs' => 'Edit Task',
            'task'        => $task,
            'projects'    => $projects,
            'users'       => $this->usersModel->findAll(),
        ]);
    }

    public function getTasks()
    {
        $userID    = session()->get('userID');
        $role      = session()->get('role');
        $projectID = $this->request->getGet('projectID');
        $sprintID  = $this->request->getGet('sprintID');

        $builder = $this->tasksModel->select('*');

        if (!empty($projectID)) $builder->where('projectID', $projectID);
        if (!empty($sprintID))  $builder->where('sprintID', $sprintID);

        if ($role !== 'admin') {
            $builder->groupStart()
                    ->where('assigneeID', $userID)
                    ->orWhere('createdBy', $userID)
                    ->groupEnd();
        }

        $tasks = $builder->findAll();
        $formatted = [];

        foreach ($tasks as $task) {
            $assigneeName = $task['assigneeID'] 
                ? ($this->usersModel->find($task['assigneeID'])['name'] ?? 'Unknown') 
                : 'Unassigned';

            $formatted[] = [
                $task['taskID'],
                '<a href="'.base_url('board/task/view/'.$task['taskID']).'" target="_blank">'.esc($task['name']).'</a>',
                $task['sprintID'] ? 'Sprint '.$task['sprintID'] : 'Backlog',
                'Project '.$task['projectID'],
                '<span class="badge bg-secondary">'.esc($task['status']).'</span>',
                esc($assigneeName), 
                '<span class="badge '.(
                    $task['priority']=='High'?'bg-danger':
                    ($task['priority']=='Normal'?'bg-warning text-dark':'bg-success')
                ).'">'.esc($task['priority']).'</span>',
                '<span class="badge bg-primary">'.esc($task['type']).'</span>'
            ];
        }

        return $this->response->setJSON(['data' => $formatted]);
    }
}
