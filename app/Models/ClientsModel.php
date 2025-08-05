<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientsModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'clientID';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $allowedFields = ['name', 'address', 'status', 'dateCreated', 'dateModified'];

    protected $useTimestamps = false;
}
