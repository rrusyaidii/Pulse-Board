<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login(){
        $data =[
            'title' => 'Login',
        ];
        return view('auth/logins', $data);
    }
}