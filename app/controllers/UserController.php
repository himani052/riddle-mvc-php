<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\User;
use Controller;

class UserController extends Controller
{

    public function connect()
    {
        return $this->view('security/login.twig');
    }

    public function login(HttpRequest $request)
    {


        //On test si email et password existes dans $_POST
        $value = $request->validator([
            'email' => ['required', 'max:255'],
            'password' => ['required']
        ]);


        $user = new User($this->getDB());
        $user = $user->where('emailUser', '=', $request->name('email'));


        //Si l'utilisateur existe
        if ($user !== FALSE) {

            //on vérifie le mot de passe
            if ($request->name('password') === $user->passwordUser) {
                //stocker la session
                //Declaration variables de sessions

                $request->session('admin', (int)$user->admin);
                $request->session('pseudo', $user->pseudoUser);
                $request->session('email', $user->emailUser);
                $request->session('photo', $user->photoUser);
                $request->session('registrationDate', $user->registrationDateUser);

                header('Location: /?success=true');
            } else {
                echo "mot de passe incorrect";
            }

        } else {
            $request->lastRedirect();
        }
    }

    public function logout()
    {
        session_destroy();
        return redirect('home.index');
    }

    public function register()
    {
        return $this->view('security/registration.twig');
    }

    public function create(HttpRequest $request)
    {

        //Récupération des valeus POST
        //Traitement des valeurs POST par la méthode validator
        $values = $request->validator(
            [
                'pseudoUser' => ['requiered'],
                'birthdateUser' => ['requiered'],
                'emailUser' => ['requiered'],
                'passwordUser' => ['requiered'],
                'passwordUserConfirmation' => ['requiered'],
            ]
        );

        //Insertion des valeurs dans la base de donnée
        $user = new User($this->getDB());
        $user = $user->create($values['emailUser'], $values['pseudoUser'], $values['passwordUser'], $values['birthdateUser'], 0);

        return redirect('user.connect');
    }


}