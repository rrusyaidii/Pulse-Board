<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\SprintModel;
use App\Models\ProjectsModel;
use App\Models\TasksModel;
use App\Models\UserModel;

class Sprints extends BaseController
{
    protected $sprintModel;
    protected $projectsModel;
    protected $tasksModel;
    protected $userModel;

    public function __construct()
    {
        $this->sprintModel   = new SprintModel();
        $this->projectsModel = new ProjectsModel();
        $this->tasksModel    = new TasksModel();
        $this->userModel     = new UserModel();
    }

    // Sprint Planning Page
    public function index()
    {
        return view('board/sprint_overview', [
            'title'       => 'Sprint Planning',
            'breadcrumbs' => 'Sprint Planning',
            'projects'    => $this->projectsModel->findAll()
        ]);
    }

    // Create Sprint Page
    public function create()
    {
        return view('board/sprint_create', [
            'title'       => 'Create Sprint',
            'breadcrumbs' => 'Create Sprint',
            'projects'    => $this->projectsModel->findAll()
        ]);
    }

    // Store Sprint
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

        return $this->response->setJSON([
            'status'  => $saved ? 'success' : 'error',
            'message' => $saved ? 'Sprint created successfully!' : 'Failed to create sprint'
        ]);
    }

    // Get all sprints for a project
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

    // Get backlog + current sprint tasks
    public function getTasks($projectID, $sprintID = null)
    {
        // Backlog
        $backlog = $this->tasksModel
            ->where('projectID', $projectID)
            ->where('sprintID', null)
            ->findAll();

        foreach ($backlog as &$task) {
            $task['status'] = 'Backlog';
            $task['assigneeName'] = $task['assigneeID']
                ? ($this->userModel->find($task['assigneeID'])['name'] ?? 'Unknown')
                : 'Unassigned';
        }

        // Current Sprint Tasks
        $currentSprintTasks = [];
        if (!empty($sprintID)) {
            $currentSprintTasks = $this->tasksModel
                ->where('sprintID', $sprintID)
                ->findAll();

            foreach ($currentSprintTasks as &$task) {
                $task['assigneeName'] = $task['assigneeID']
                    ? ($this->userModel->find($task['assigneeID'])['name'] ?? 'Unknown')
                    : 'Unassigned';
            }
        }

        return $this->response->setJSON([
            'status'             => 'success',
            'backlog'            => $backlog,
            'currentSprintTasks' => $currentSprintTasks
        ]);
    }

    // Add Task to Sprint
    public function addToSprint()
    {
        $taskID   = $this->request->getPost('taskID');
        $sprintID = $this->request->getPost('sprintID');

        if (!$taskID || !$sprintID) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Invalid task or sprint ID'
            ]);
        }

        $task = $this->tasksModel->find($taskID);
        if (!$task) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Task not found'
            ]);
        }

        $updated = $this->tasksModel->update($taskID, [
            'sprintID'     => $sprintID,
            'status'       => 'To Do',
            'dateModified' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status'  => $updated ? 'success' : 'error',
            'message' => $updated ? 'Task added to sprint successfully!' : 'Failed to add task to sprint'
        ]);
    }

    // Task Details Page
    public function viewTask($taskID)
    {
        $task = $this->tasksModel->where('taskID', $taskID)->first();

        if (!$task) {
            return redirect()->to(base_url('board/sprints'))->with('error', 'Task not found');
        }

        $task['assigneeName'] = $task['assigneeID']
            ? ($this->userModel->find($task['assigneeID'])['name'] ?? 'Unknown')
            : 'Unassigned';

        return view('board/task_view', [
            'title'       => 'Task Details',
            'breadcrumbs' => 'Task Details',
            'task'        => $task
        ]);
    }
}
