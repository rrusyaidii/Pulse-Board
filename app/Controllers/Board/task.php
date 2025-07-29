<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;

class task extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Task Overview',
            'breadcrumbs' => 'Task Overview'
        ];
        return view('board/task_overview',$data);
    }
}
