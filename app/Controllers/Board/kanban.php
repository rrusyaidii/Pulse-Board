<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;
use App\Models\UserModel; // Import the UserModel

class Kanban extends BaseController
{
    protected $projectsModel;
    protected $sprintModel;
    protected $tasksModel;
    protected $usersModel; // Declare the UserModel property

    public function __construct()
    {
        $this->projectsModel = new ProjectsModel();
        $this->sprintModel   = new SprintModel();
        $this->tasksModel    = new TasksModel();
        $this->usersModel    = new UserModel(); // Initialize the UserModel
    }

    /** Show Kanban Board Page */
    public function index()
    {
        $data = [
            'title'       => 'Kanban Board',
            'breadcrumbs' => 'Kanban Board',
            'projects'    => $this->projectsModel->findAll()
        ];
        return view('board/kanban', $data);
    }

    /** AJAX: Load Kanban Tasks by Project & Optional Sprint */
    public function kanbanData($projectID, $sprintID = null)
    {
        $tasksQuery = $this->tasksModel->where('projectID', $projectID);

        if (!empty($sprintID) && $sprintID !== 'all') { // Added 'all' check for filter option
            $tasksQuery->where('sprintID', $sprintID);
        }

        $tasks = $tasksQuery->findAll();

        // Define columns and their display titles
        $columns = [
            'Backlog'     => [],
            'To Do'       => [],
            'In Progress' => [],
            'In Review'   => [],
            'Completed'   => []
        ];

        foreach ($tasks as $task) {
            // Fetch related data for display
            $project = $this->projectsModel->find($task['projectID']);
            $assignee = $task['assigneeID'] ? $this->usersModel->find($task['assigneeID']) : null;

            // Determine priority class for styling
            $priorityClass = '';
            switch (strtolower($task['priority'])) {
                case 'high':
                case 'blocker':
                    $priorityClass = 'badge-danger';
                    break;
                case 'normal':
                    $priorityClass = 'badge-warning text-dark';
                    break;
                case 'low':
                    $priorityClass = 'badge-success';
                    break;
                default:
                    $priorityClass = 'badge-secondary';
                    break;
            }

            // Determine type class for styling (optional, but good for consistency)
            $typeClass = 'badge-primary'; // Default type badge color

            // Construct custom HTML for the Kanban card
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

            // Map task status to a column. If status is null or not in defined columns, default to 'Backlog'
            $currentStatus = $task['status'] ?? 'Backlog';
            if (!array_key_exists($currentStatus, $columns)) {
                $currentStatus = 'Backlog'; // Fallback for undefined statuses
            }

            $columns[$currentStatus][] = [
                'id'    => $task['taskID'],
                'title' => $cardHTML, // Use the rich HTML content
                // Add a class to the item for additional styling if needed, e.g., based on priority
                'class' => 'kanban-item-status-' . strtolower(str_replace(' ', '-', $currentStatus))
            ];
        }

        // Format the data into jKanban's board structure
        $data = [];
        foreach ($columns as $statusTitle => $items) {
            $data[] = [
                'id'    => strtolower(str_replace(' ', '-', $statusTitle)), // jKanban board ID (e.g., "to-do")
                'title' => $statusTitle, // Display title (e.g., "To Do")
                'item'  => $items
            ];
        }

        return $this->response->setJSON($data);
    }

    /** AJAX: Update Task Status from Drag & Drop */
    public function updateStatus()
    {
        $taskID = $this->request->getPost('taskID');
        $status = $this->request->getPost('status');

        // Convert jKanban's board ID back to the correct status name for the database
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

        if ($updated) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Task status updated successfully.'
            ]);
        } else {
            // Log any database errors for debugging
            log_message('error', 'Failed to update task status for ID ' . $taskID . ': ' . json_encode($this->tasksModel->errors()));
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Failed to update task status in the database.'
            ]);
        }
    }

    /** AJAX: Get Sprints for Project */
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