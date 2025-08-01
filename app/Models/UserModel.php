<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Corrected from 'users'
    protected $primaryKey = 'userID';

    protected $allowedFields = [
        'orgID', 'deptID', 'name', 'email', 'password', 'role', 'status', 'dateCreated', 'dateModified'
    ];

    protected $useTimestamps = false; // Disable automatic created_at/updated_at
}
