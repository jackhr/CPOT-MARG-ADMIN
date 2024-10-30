<?php

namespace App\Middleware;

use App\Models\Role;

class AdminMiddleware
{
    public function handle()
    {
        session_start();

        $roleModel = new Role();
        $admin_role = $roleModel->findByRoleName("Admin");

        // Check if user is not admin
        if ($_SESSION['user']['role_id'] > $admin_role['rol_id']) {
            return false;
        }

        return true; // If user is admin, continue with the request
    }
}
