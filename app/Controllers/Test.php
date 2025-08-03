<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Database;

class Test extends Controller
{
    public function index(): string
    {
        try {
            $db = Database::connect();

            // Force the connection
            $db->initialize();

            if ($db->connID !== false) {
                return "✅ Database Connected Successfully!";
            } else {
                return "❌ Database Not Connected!";
            }
        } catch (\Throwable $e) {
            return "❌ Connection Failed: " . $e->getMessage();
        }
    }
}
