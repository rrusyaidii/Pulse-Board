<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;

class Kanban extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Board',
        ];
        return view('board/kanban',$data);
    }
}
