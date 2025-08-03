<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;

class Sprints extends BaseController
{
    protected $sprintModel;
    protected $projectsModel;
    protected $tasksModel;

    public function __construct()
    {
        $this->sprintModel   = new SprintModel();
        $this->projectsModel = new ProjectsModel();
        $this->tasksModel    = new TasksModel();
    }

    // Sprint Planning Page
    public function index()
    {
        $data = [
            'title'       => 'Sprint',
            'breadcrumbs' => 'Sprint Planning',
            'projects'    => $this->projectsModel->findAll()
        ];

        return view('board/sprint_overview', $data);
    }

    // Show Create Sprint Form
    public function create()
    {
        $data = [
            'title'       => 'Create Sprint',
            'breadcrumbs' => 'Create Sprint',
            'projects'    => $this->projectsModel->findAll()
        ];

        return view('board/sprint_create', $data);
    }

    // Store Sprint (AJAX)
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'      => 'required|min_length[3]',
            'projectID' => 'required|numeric',
            'startDate' => 'required|valid_date',
            'endDate'   => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $saved = $this->sprintModel->insert([
            'projectID' => $this->request->getPost('projectID'),
            'name'      => $this->request->getPost('name'),
            'status'    => 'Planned',
            'startDate' => $this->request->getPost('startDate'),
            'endDate'   => $this->request->getPost('endDate')
        ]);

        if ($saved) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Sprint created successfully!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to create sprint'
        ]);
    }

    // AJAX: Get Sprints for selected Project
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

    // AJAX: Get Backlog + Current Sprint Tasks
    public function getTasks($sprintID)
    {
        $backlog = $this->tasksModel
            ->where('sprintID IS NULL')
            ->findAll();

        $currentSprintTasks = $this->tasksModel
            ->where('sprintID', $sprintID)
            ->findAll();

        return $this->response->setJSON([
            'status'             => 'success',
            'backlog'            => $backlog,
            'currentSprintTasks' => $currentSprintTasks
        ]);
    }
}
