<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        // Check if the user is authenticated
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }
}
