<?php

namespace App\controllers\Admin;

use App\https\HttpRequest;
use Controller;

class SecurityController extends Controller {

    public function connect(){
        return $this->view('admin/security/login.twig');
    }

    public function login(HttpRequest $request){


        //On test si email et password existes dans $_POST
        $value = $request->validator([
            'email' => ['required', 'max:6'],
            'password' => ['required']
        ]);

        var_dump($value);

        die();
    }

}