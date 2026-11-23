<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $counts = [];

        foreach (['projects', 'education', 'experiences', 'skills', 'certificates'] as $table) {
            $counts[$table] = $db->table($table)->countAllResults();
        }

        return view('admin/dashboard', [
            'title' => 'Ringkasan',
            'counts' => $counts,
            'userName' => session()->get('admin_user_name') ?? 'Admin',
        ]);
    }
}
