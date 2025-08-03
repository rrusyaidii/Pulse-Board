<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;
use App\Models\UserModel; // For assignee dropdown

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
        $this->usersModel    = new UserModel(); // For assignees
    }

    /**
     * Task Overview Page
     */
    public function index()
    {
        $data = [
            'title'       => 'Task Overview',
            'breadcrumbs' => 'Task Overview',
            'projects'    => $this->projectsModel->findAll(),
            'users'       => $this->usersModel->findAll(), // Assignee dropdown
        ];

        return view('board/task_overview', $data);
    }

    /**
     * AJAX: Get Sprints by Project
     */
    public function getSprints($projectID)
    {
        $sprints = $this->sprintModel
            ->where('projectID', $projectID)
            ->orderBy('startDate', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'status'  => 'success',
            'sprints' => $sprints
        ]);
    }

    /**
     * AJAX: Store Task
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'      => 'required|min_length[3]',
            'projectID' => 'required|numeric',
            'sprintID'  => 'permit_empty|numeric',
            'priority'  => 'required',
            'type'      => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $saved = $this->tasksModel->insert([
            'name'       => $this->request->getPost('name'),
            'projectID'  => $this->request->getPost('projectID'),
            'sprintID'   => $this->request->getPost('sprintID') ?: null,
            'assigneeID' => $this->request->getPost('assigneeID') ?: null,
            'priority'   => $this->request->getPost('priority'),
            'type'       => $this->request->getPost('type'),
            'status'     => 'To Do'
        ]);

        if ($saved) {
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

    /**
     * AJAX: Get Tasks for DataTable (filtered by project & sprint)
     */
    public function getTasks()
    {
        $projectID = $this->request->getGet('projectID');
        $sprintID  = $this->request->getGet('sprintID');

        $builder = $this->tasksModel;

        if (!empty($projectID)) {
            $builder = $builder->where('projectID', $projectID);
        }
        if (!empty($sprintID)) {
            $builder = $builder->where('sprintID', $sprintID);
        }

        $tasks = $builder->findAll();

        // Format data for DataTables (without user story)
        $formatted = [];
        foreach ($tasks as $task) {
            $formatted[] = [
                $task['taskID'],
                esc($task['name']),
                $task['sprintID'] ? 'Sprint '.$task['sprintID'] : 'Backlog',
                'Project '.$task['projectID'],
                '<span class="badge bg-secondary">'.esc($task['status']).'</span>',
                $task['assigneeID'] ? 'User '.$task['assigneeID'] : 'Unassigned',
                '<span class="badge '.($task['priority']=='High'?'bg-danger':($task['priority']=='Medium'?'bg-warning text-dark':'bg-success')).'">'.esc($task['priority']).'</span>',
                '<span class="badge bg-primary">'.esc($task['type']).'</span>'
            ];
        }

        return $this->response->setJSON([
            'data' => $formatted
        ]);
    }
}
