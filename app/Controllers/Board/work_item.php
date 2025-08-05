<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;
use App\Models\ProjectsModel;
use App\Models\SprintModel;
use App\Models\TasksModel;
use App\Models\UserModel;

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
        $this->userModel     = new UserModel();
    }

    /** Work Item Overview Page */
    public function index()
    {
        $userID = session()->get('userID');

        // Only list projects the user is involved in
        $db = \Config\Database::connect();
        $projectIDs = $db->table('userprojects')
            ->select('projectID')
            ->where('userID', $userID)
            ->get()
            ->getResultArray();

        $projectIDs = array_column($projectIDs, 'projectID');

        $projects = [];
        if (!empty($projectIDs)) {
            $projects = $this->projectsModel
                ->whereIn('projectID', $projectIDs)
                ->findAll();
        }

        return view('board/work_item_overview', [
            'title'       => 'Work Items',
            'breadcrumbs' => 'Work Items',
            'projects'    => $projects,
            'users'       => $this->userModel->findAll()
        ]);
    }

    /** AJAX: Get Sprints by Project */
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

    /** AJAX: Get Tasks (Role-based filtering from userprojects table) */
    public function getTasks()
    {
        $projectID = $this->request->getGet('projectID');
        $sprintID  = $this->request->getGet('sprintID');
        $userID    = session()->get('userID');

        if (!$projectID) {
            return $this->response->setJSON(['data' => []]);
        }

        // Check user's role for this project
        $db = \Config\Database::connect();
        $projectRole = $db->table('userprojects')
            ->select('role')
            ->where('projectID', $projectID)
            ->where('userID', $userID)
            ->get()
            ->getRowArray();

        $canViewAll = false;
        if ($projectRole && in_array(strtolower($projectRole['role']), [ 'manager'])) {
            $canViewAll = true;
        }

        // Build query
        $builder = $this->tasksModel->where('projectID', $projectID);
        if ($sprintID) {
            $builder->where('sprintID', $sprintID);
        }

        // Restrict for developers/testers to only their tasks
        if (!$canViewAll) {
            $builder->where('assigneeID', $userID);
        }

        $tasks = $builder->findAll();
        $data = [];

        foreach ($tasks as $task) {
            // Resolve assignee name
            $assigneeName = 'Unassigned';
            if (!empty($task['assigneeID'])) {
                $user = $this->userModel->find($task['assigneeID']);
                if ($user) {
                    $assigneeName = esc($user['name']);
                }
            }

            // Sprint or Backlog
            $sprintName = !empty($task['sprintID']) ? 'Sprint '.$task['sprintID'] : 'Backlog';
            $taskLink   = '<a href="'.base_url('board/task/view/'.$task['taskID']).'" target="_blank">'.esc($task['name']).'</a>';

            $data[] = [
                $task['taskID'],
                $taskLink,
                $sprintName,
                $task['status'] ?? 'Backlog',
                $task['priority'] ?? 'Low',
                $assigneeName,
                $task['assigneeID'] ?? '',
            ];
        }

        return $this->response->setJSON(['data' => $data]);
    }

    /** Update Task Status */
    public function updateStatus()
    {
        $taskID = $this->request->getPost('taskID');
        $status = $this->request->getPost('status');

        if ($taskID && $status) {
            $updated = $this->tasksModel->update($taskID, [
                'status'       => $status,
                'dateModified' => date('Y-m-d H:i:s')
            ]);
            return $this->response->setJSON([
                'status'  => $updated ? 'success' : 'error',
                'message' => $updated ? 'Status updated successfully.' : 'Failed to update status.'
            ]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
    }

    /** Update Task Priority */
    public function updatePriority()
    {
        $taskID   = $this->request->getPost('taskID');
        $priority = $this->request->getPost('priority');

        if ($taskID && $priority) {
            $updated = $this->tasksModel->update($taskID, [
                'priority'     => $priority,
                'dateModified' => date('Y-m-d H:i:s')
            ]);
            return $this->response->setJSON([
                'status'  => $updated ? 'success' : 'error',
                'message' => $updated ? 'Priority updated successfully.' : 'Failed to update priority.'
            ]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
    }

    /** Update Task Assignee */
    public function updateAssignee()
    {
        $taskID     = $this->request->getPost('taskID');
        $assigneeID = $this->request->getPost('assigneeID') ?: null;

        if ($taskID) {
            $updated = $this->tasksModel->update($taskID, [
                'assigneeID'   => $assigneeID,
                'dateModified' => date('Y-m-d H:i:s')
            ]);
            return $this->response->setJSON([
                'status'  => $updated ? 'success' : 'error',
                'message' => $updated ? 'Assignee updated successfully.' : 'Failed to update assignee.'
            ]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
    }
}
