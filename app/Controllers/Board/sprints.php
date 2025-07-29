<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;

class Sprints extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Sprint',
            'breadcrumbs' => 'Sprint Planning'
        ];
        return view('board/sprint_overview',$data);
    }
}
