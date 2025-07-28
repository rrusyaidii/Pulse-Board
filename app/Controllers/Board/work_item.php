<?php

namespace App\Controllers\Board;

use App\Controllers\BaseController;

class Work_Item extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Work Items',
            'breadcrumbs' => 'Work Item'
        ];
        return view('board/work_item_overview',$data);
    }
}
