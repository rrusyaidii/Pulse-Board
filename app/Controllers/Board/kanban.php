<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;
use App\Models\UserModel;

class Kanban extends BaseController
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

        $data = [
            'title'       => 'Kanban Board',
            'breadcrumbs' => 'Kanban Board',
            'projects'    => $projects
        ];

        return view('board/kanban', $data);
    }

    public function kanbanData($projectID, $sprintID = null)
    {
        $userID = session()->get('userID');
        $role   = session()->get('role');

        $tasksQuery = $this->tasksModel->where('projectID', $projectID);
        if (!empty($sprintID) && $sprintID !== 'all') {
            $tasksQuery->where('sprintID', $sprintID);
        }
        if ($role !== 'admin') {
            $tasksQuery->groupStart()
                       ->where('assigneeID', $userID)
                       ->orWhere('createdBy', $userID)
                       ->groupEnd();
        }

        $tasks = $tasksQuery->findAll();

        $columns = [
            'Backlog'     => [],
            'To Do'       => [],
            'In Progress' => [],
            'In Review'   => [],
            'Completed'   => []
        ];

        foreach ($tasks as $task) {
            $project  = $this->projectsModel->find($task['projectID']);
            $assignee = $task['assigneeID'] ? $this->usersModel->find($task['assigneeID']) : null;

            $priorityClass = match(strtolower($task['priority'] ?? '')) {
                'high', 'blocker' => 'badge-danger',
                'normal'          => 'badge-warning text-dark',
                'low'             => 'badge-success',
                default           => 'badge-secondary'
            };

            $typeClass = 'badge-primary';

            $cardHTML = '
                <a href="' . base_url('board/task/view/' . $task['taskID']) . '" class="kanban-item-link">
                    <span class="kanban-item-title">' . esc($task['name']) . '</span>
                </a>
                <div class="kanban-item-meta mt-2">
                    <span class="badge ' . $priorityClass . '">' . esc($task['priority']) . '</span>
                    <span class="badge ' . $typeClass . '">' . esc($task['type']) . '</span>
                </div>
                <div class="kanban-item-details mt-2 text-muted">
                    <small>Project: ' . esc($project['name'] ?? 'N/A') . '</small><br>
                    <small>Assignee: ' . esc($assignee['name'] ?? 'Unassigned') . '</small>
                </div>
            ';

            $currentStatus = $task['status'] ?? 'Backlog';
            if (!array_key_exists($currentStatus, $columns)) {
                $currentStatus = 'Backlog';
            }

            $columns[$currentStatus][] = [
                'id'    => $task['taskID'],
                'title' => $cardHTML,
                'class' => 'kanban-item-status-' . strtolower(str_replace(' ', '-', $currentStatus))
            ];
        }

        $data = [];
        foreach ($columns as $statusTitle => $items) {
            $data[] = [
                'id'    => strtolower(str_replace(' ', '-', $statusTitle)),
                'title' => $statusTitle,
                'item'  => $items
            ];
        }

        return $this->response->setJSON($data);
    }

    public function updateStatus()
    {
        $taskID = $this->request->getPost('taskID');
        $status = $this->request->getPost('status');

        $statusMap = [
            'backlog'     => 'Backlog',
            'to-do'       => 'To Do',
            'in-progress' => 'In Progress',
            'in-review'   => 'In Review',
            'completed'   => 'Completed'
        ];
        $dbStatus = $statusMap[$status] ?? null;

        if (!$taskID || !$dbStatus) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Invalid task ID or status provided.'
            ]);
        }

        $updated = $this->tasksModel->update($taskID, [
            'status'       => $dbStatus,
            'dateModified' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status'  => $updated ? 'success' : 'error',
            'message' => $updated ? 'Task status updated successfully.' : 'Failed to update task status.'
        ]);
    }

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
}
