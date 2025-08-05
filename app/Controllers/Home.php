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
        $userRole = session()->get('role'); // e.g., 'user', 'admin', 'director'

        // === If Director/CEO ===
        if (in_array(strtolower($userRole), ['director','ceo'])) {
            $projects = $this->projectsModel
                ->select('projects.*,
                    COUNT(CASE WHEN tasks.status IS NOT NULL AND tasks.status != "Backlog" THEN 1 END) AS totalTasks,
                    SUM(CASE WHEN tasks.status IN ("Done","Completed") THEN 1 ELSE 0 END) AS doneTasks')
                ->join('tasks', 'tasks.projectID = projects.projectID', 'left')
                ->groupBy('projects.projectID')
                ->orderBy('projects.dateModified', 'DESC')
                ->findAll();

            $totalProjects = count($projects);
            $totalRevenue = 0;
            $totalCost = 0;
            $totalProfit = 0;
            $myProjects = [];

            foreach ($projects as $project) {
                $totalTasks = (int)$project['totalTasks'];
                $doneTasks = (int)$project['doneTasks'];

                $percentage = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                $progressClass = $percentage < 30 ? 'bg-danger' : ($percentage < 70 ? 'bg-warning' : 'bg-success');

                // Calculate financials
                $revenue = (float)$project['contractValue'];
                $cost = (float)$project['cost'];
                $profit = $revenue - $cost;

                $totalRevenue += $revenue;
                $totalCost += $cost;
                $totalProfit += $profit;

                $project['percentage']    = $percentage;
                $project['progressClass'] = $progressClass;
                $project['doneTasks']     = $doneTasks;
                $project['inProgressTasks'] = 0; // Director not focusing on detailed task stats
                $project['profit']        = $profit;

                $myProjects[] = $project;
            }

            $data = [
                'title'         => 'Director Dashboard',
                'totalProjects' => $totalProjects,
                'toDo'          => 0, // not used for director
                'inProgress'    => 0,
                'done'          => 0,
                'totalRevenue'  => $totalRevenue,
                'totalCost'     => $totalCost,
                'totalProfit'   => $totalProfit,
                'myTasks'       => [], // Director won't see My Tasks
                'myProjects'    => $myProjects
            ];

            return view('home', $data);
        }

        // === Normal User Dashboard ===
        // 1. Total projects for user
        $totalProjects = $this->projectsModel
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner')
            ->where('userprojects.userID', $userID)
            ->countAllResults();

        // 2. Task counts
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

        // 3. My Tasks (excluding Done, Completed, Backlog)
        $myTasks = $this->tasksModel
            ->select('tasks.*, projects.name as projectName')
            ->join('projects', 'projects.projectID = tasks.projectID', 'left')
            ->where('tasks.assigneeID', $userID)
            ->whereNotIn('tasks.status', ['Done', 'Completed', 'Backlog'])
            ->orderBy('tasks.dateModified', 'DESC')
            ->findAll();

        // 4. Projects with stats
        $projects = $this->projectsModel
            ->select('projects.*,
                COUNT(CASE WHEN tasks.status IS NOT NULL AND tasks.status != "Backlog" THEN 1 END) AS totalTasks,
                SUM(CASE WHEN tasks.status IN ("Done","Completed") THEN 1 ELSE 0 END) AS doneTasks,
                SUM(CASE WHEN tasks.status = "In Progress" THEN 1 ELSE 0 END) AS inProgressTasks')
            ->join('userprojects', 'userprojects.projectID = projects.projectID', 'inner')
            ->join(
                'tasks', 
                'tasks.projectID = projects.projectID 
                 AND tasks.assigneeID = '.$this->tasksModel->db->escape($userID).' 
                 AND tasks.status != "Backlog"',
                'left'
            )
            ->where('userprojects.userID', $userID)
            ->groupBy('projects.projectID')
            ->orderBy('projects.dateModified', 'DESC')
            ->findAll();

        $myProjects = [];
        foreach ($projects as $project) {
            $totalTasks      = (int)$project['totalTasks'];
            $doneTasks       = (int)$project['doneTasks'];
            $inProgressTasks = (int)$project['inProgressTasks'];

            $percentage = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
            $progressClass = $percentage < 30 ? 'bg-danger' : ($percentage < 70 ? 'bg-warning' : 'bg-success');

            $project['percentage']      = $percentage;
            $project['progressClass']   = $progressClass;
            $project['inProgressTasks'] = $inProgressTasks;
            $project['doneTasks']       = $doneTasks;

            $myProjects[] = $project;
        }

        // 6. Pass all data to the view
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
