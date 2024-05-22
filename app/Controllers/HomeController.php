<?php

namespace App\Controllers;
use App\Libraries\Template;
use App\Models\UsersModel;

class HomeController
{
    public function index()
    {
      
        $data = array();
        $template =  new Template();

        $template->render('template', 'contents', 'dashboard', $data);
    }
}
