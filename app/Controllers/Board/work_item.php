<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;
use App\Models\UserModel; // ✅ Add User Model

class Work_Item extends BaseController
{
    protected $projectsModel;
    protected $sprintModel;
    protected $tasksModel;
    protected $userModel;

    public function __construct()
    {
        $this->projectsModel = new ProjectsModel();
        $this->sprintModel   = new SprintModel();
        $this->tasksModel    = new TasksModel();
        $this->userModel     = new UserModel(); // ✅ Initialize User Model
    }

    /**
     * Work Item Overview Page
     */
    public function index()
    {
        $data = [
            'title'       => 'Work Items',
            'breadcrumbs' => 'Work Item',
            'projects'    => $this->projectsModel->findAll()
        ];

        return view('board/work_item_overview', $data);
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
     * AJAX: Get Work Items for DataTable
     */
    public function getTasks()
    {
        $projectID = $this->request->getGet('projectID');
        $sprintID  = $this->request->getGet('sprintID');

        $builder = $this->tasksModel;

        if ($projectID) {
            $builder = $builder->where('projectID', $projectID);
        }
        if ($sprintID) {
            $builder = $builder->where('sprintID', $sprintID);
        }

        $tasks = $builder->findAll();

        // Format for DataTable
        $data = [];
        foreach ($tasks as $task) {
            // ✅ Get Assignee Name
            $assigneeName = 'Unassigned';
            if (!empty($task['assigneeID'])) {
                $user = $this->userModel->find($task['assigneeID']);
                if ($user) {
                    $assigneeName = esc($user['name']);
                }
            }

            $data[] = [
                $task['taskID'],
                esc($task['name']),
                '<span class="badge bg-info text-dark">Task</span>',
                '<span class="badge '.($task['status']=='Done'?'bg-success':($task['status']=='In Progress'?'bg-warning text-dark':'bg-secondary')).'">'.esc($task['status']).'</span>',
                '<span class="badge '.($task['priority']=='High'?'bg-danger':($task['priority']=='Medium'?'bg-warning text-dark':'bg-success')).'">'.esc($task['priority']).'</span>',
                $assigneeName, // ✅ Show Name
                $task['endDate'] ?? '-'
            ];
        }

        return $this->response->setJSON([
            'data' => $data
        ]);
    }
}
