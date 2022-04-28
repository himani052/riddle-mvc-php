<?php

namespace App\controllers\Admin;

use App\https\HttpRequest;
use App\models\User;
use Controller;

class SecurityController extends Controller {

    public function connect(){
        return $this->view('admin/security/login.twig');
    }

    public function login(HttpRequest $request){


        //On test si email et password existes dans $_POST
        $value = $request->validator([
            'email' => ['required', 'max:255'],
            'password' => ['required']
        ]);

        //var_dump($value);
        //die();

        $user = new User($this->getDB());
        $user = $user->where('emailUser', '=',$request->name('email'));


        //Si l'utilisateur existe
        if($user !== FALSE ){

            //on vérifie le mot de passe
            if($request->name('password') === $user->password){
                //stocker la session
                //Declaration variables de sessions
                $request->session('role', $user->role);
                $request->session('username', $user->pseudo);
                header('Location: /?success=true');
            }else{
                echo "mot de passe incorrect";
            }

        }else{
            $request->lastRedirect();
        }
    }

}