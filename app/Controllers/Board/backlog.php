<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;

class Backlog extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Backlog',
        ];
        return view('board/backlog_overview',$data);
    }
}
