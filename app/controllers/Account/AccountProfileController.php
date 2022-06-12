<?php

namespace App\controllers\Account;

use Controller;



class AccountProfileController extends Controller
{

    public function index(){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        return $this->view('account/profile/index.twig');

    }

}