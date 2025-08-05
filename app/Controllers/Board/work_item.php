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
        return view('board/work_item_overview', [
            'title'       => 'Work Items',
            'breadcrumbs' => 'Work Items',
            'projects'    => $this->projectsModel->findAll(),
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

    public function getTasks()
    {
        $projectID = $this->request->getGet('projectID');
        $sprintID  = $this->request->getGet('sprintID');

        $builder = $this->tasksModel;
        if ($projectID) $builder = $builder->where('projectID', $projectID);
        if ($sprintID)  $builder = $builder->where('sprintID', $sprintID);

        $tasks = $builder->findAll();
        $data = [];

        foreach ($tasks as $task) {
            $assigneeName = 'Unassigned';
            if (!empty($task['assigneeID'])) {
                $user = $this->userModel->find($task['assigneeID']);
                if ($user) $assigneeName = esc($user['name']);
            }

            $sprintName = !empty($task['sprintID']) ? 'Sprint '.$task['sprintID'] : 'Backlog';
            $taskLink = '<a href="'.base_url('board/task/view/'.$task['taskID']).'" target="_blank">'.esc($task['name']).'</a>';

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

    public function updateAssignee()
    {
        $taskID    = $this->request->getPost('taskID');
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
