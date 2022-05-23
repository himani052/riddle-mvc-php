<?php

namespace App\controllers\Account\Admin;

use App\models\User;
use Controller;

class AdminUserController extends Controller {

    public function index(){

        $user = new User($this->getDB());
        $users = $user->all();

        return $this->view('account/admin/user/index.twig', compact('users'));
   }
}
