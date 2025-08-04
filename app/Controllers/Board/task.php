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

    /** Task Overview Page */
    public function index()
    {
        return view('board/task_overview', [
            'title'       => 'Task Overview',
            'breadcrumbs' => 'Task Overview',
            'projects'    => $this->projectsModel->findAll(),
            'users'       => $this->usersModel->findAll(),
        ]);
    }

    /** Show Create Task Page */
    public function create()
    {
        return view('board/task_create', [
            'title'       => 'Create Task',
            'breadcrumbs' => 'Create Task',
            'projects'    => $this->projectsModel->findAll(),
            'users'       => $this->usersModel->findAll(),
        ]);
    }

    /** Store Task (AJAX) */
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

        $data = [
            'name'        => $this->request->getPost('name'),
            'projectID'   => $this->request->getPost('projectID'),
            'sprintID'    => $this->request->getPost('sprintID') ?: null,
            'assigneeID'  => $this->request->getPost('assigneeID') ?: null,
            'priority'    => $this->request->getPost('priority'),
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'status'      => 'Backlog',
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

    /** View Task Page */
    public function view($taskID)
    {
        $task = $this->tasksModel->find($taskID);
        if (!$task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Task not found.');
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

    /** Show Edit Task Page */
    public function edit($taskID)
    {
        $task = $this->tasksModel->find($taskID);
        if (!$task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Task not found.');
        }

        return view('board/task_edit', [
            'title'       => 'Edit Task',
            'breadcrumbs' => 'Edit Task',
            'task'        => $task,
            'projects'    => $this->projectsModel->findAll(),
            'users'       => $this->usersModel->findAll(),
        ]);
    }

    /** Update Task (AJAX) */
    public function update($taskID)
    {
        $task = $this->tasksModel->find($taskID);
        if (!$task) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Task not found.'
            ]);
        }

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

        $data = [
            'name'        => $this->request->getPost('name'),
            'projectID'   => $this->request->getPost('projectID'),
            'sprintID'    => $this->request->getPost('sprintID') ?: null,
            'assigneeID'  => $this->request->getPost('assigneeID') ?: null,
            'priority'    => $this->request->getPost('priority'),
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'dateModified'=> date('Y-m-d H:i:s'),
        ];

        if ($this->tasksModel->update($taskID, $data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Task updated successfully!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to update task'
        ]);
    }

    /** AJAX: Get Tasks for DataTable */
    public function getTasks()
    {
        $projectID = $this->request->getGet('projectID');
        $sprintID  = $this->request->getGet('sprintID');

        $builder = $this->tasksModel;
        if (!empty($projectID)) $builder = $builder->where('projectID', $projectID);
        if (!empty($sprintID))  $builder = $builder->where('sprintID', $sprintID);

        $tasks = $builder->findAll();
        $formatted = [];

        foreach ($tasks as $task) {
            $assigneeName = $task['assigneeID'] 
                ? ($this->usersModel->find($task['assigneeID'])['name'] ?? 'Unknown') 
                : 'Unassigned';

            $formatted[] = [
                $task['taskID'],
                '<a href="'.base_url('board/task/view/'.$task['taskID']).'">'.esc($task['name']).'</a>',
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
