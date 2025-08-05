<?php

namespace App\Controllers;

use App\Models\ProjectsModel;
use App\Models\TasksModel;

class Home extends BaseController
{
    protected $projectsModel;
    protected $tasksModel;

    public function __construct()
    {
        $this->projectsModel = new ProjectsModel();
        $this->tasksModel    = new TasksModel();
    }

    public function index()
    {
        $userID = session()->get('userID'); 

        $totalProjects = $this->projectsModel
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner')
            ->where('userprojects.userID', $userID)
            ->countAllResults();
        
        $toDo = $this->tasksModel
            ->where('assigneeID', $userID)
            ->where('status', 'To Do')
            ->countAllResults();
        
        $inProgress = $this->tasksModel
            ->where('assigneeID', $userID)
            ->where('status', 'In Progress')
            ->countAllResults();
        
        $done = $this->tasksModel
            ->where('assigneeID', $userID)
            ->whereIn('status', ['Done', 'Completed'])
            ->countAllResults();
        
            $myTasks = $this->tasksModel
            ->select('tasks.*, projects.name as projectName')
            ->join('projects', 'projects.projectID = tasks.projectID', 'left')
            ->where('tasks.assigneeID', $userID)
            ->orderBy('tasks.dateModified', 'DESC')
            ->findAll(10);
        
        $myProjects = $this->projectsModel
            ->select('projects.*,
                SUM(CASE WHEN tasks.status IN ("Done","Completed") THEN 1 ELSE 0 END) AS doneTasks,
                SUM(CASE WHEN tasks.status NOT IN ("Done","Completed") THEN 1 ELSE 0 END) AS pendingTasks')
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner')
            ->join('tasks', 'tasks.projectID = projects.projectID', 'left')
            ->where('userprojects.userID', $userID)
            ->groupBy('projects.projectID')
            ->findAll();
        
        $data = [
            'title'         => 'Dashboard',
            'totalProjects' => $totalProjects,
            'toDo'          => $toDo,
            'inProgress'    => $inProgress,
            'done'          => $done,
            'myTasks'       => $myTasks,
            'myProjects'    => $myProjects
        ];
        
        return view('home', $data);
    }
}
