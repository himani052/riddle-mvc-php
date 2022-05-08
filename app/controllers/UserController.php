<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\User;
use Controller;

class UserController extends Controller {

    public function connect(){
        return $this->view('security/login.twig');
    }

    public function login(HttpRequest $request){


        //On test si email et password existes dans $_POST
        $value = $request->validator([
            'email' => ['required', 'max:255'],
            'password' => ['required']
        ]);


        $user = new User($this->getDB());
        $user = $user->where('emailUser', '=',$request->name('email'));


        //Si l'utilisateur existe
        if($user !== FALSE ){

            //on vérifie le mot de passe
            if($request->name('password') === $user->password){
                //stocker la session
                //Declaration variables de sessions
                $request->session('auth', (int) $user->role);
                $request->session('username', $user->pseudo);
                $request->session('photo', $user->photo);
                var_dump($user->photo);
                header('Location: /?success=true');
            }else{
                echo "mot de passe incorrect";
            }

        }else{
            $request->lastRedirect();
        }
    }

    public function logout(){
        session_destroy();
        return redirect('home.index');
    }

    public function register(){
        return $this->view('security/registration.twig');
    }

}