<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Config\View;

class HomeController
{
    public function index()
    {
        $view = new View();
        $data = array(
            "Name" => "Pradeep Yadav",
            "Occupation" => "Developer",
        );
        print_r($data);
        printArr($data);exit;

        $view->load("dashboard", $data);
    }
}
