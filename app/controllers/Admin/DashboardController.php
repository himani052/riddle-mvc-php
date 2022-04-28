<?php

namespace App\controllers\Admin;

use Controller;

class DashboardController extends Controller {

    public function index(){
        return $this->view('admin/dashboard/index.twig');

    }

}