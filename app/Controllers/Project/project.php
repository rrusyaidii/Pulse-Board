<?php

namespace App\Controllers\Project;

use App\Controllers\BaseController;

class Project extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Project Overview',
            'breadcrumbs' =>'My Project',
        ];
        return view('project/project_overview',$data);
    }
}
