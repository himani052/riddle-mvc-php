<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\User;
use Controller;
use Database\DBConnection;

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
            if(password_verify($request->name('password'), $user->passwordUser)){
                //stocker la session
                //Declaration variables de sessions
                
                $request->session('admin', (int) $user->admin);
                $request->session('pseudo', $user->pseudoUser);
                $request->session('email', $user->emailUser);
                $request->session('photo', $user->photoUser);
                $request->session('registrationDate', $user->registrationDateUser);

                header('Location: /?success=true');
            }else{
                echo '<script type="text/javascript">
                    window.onload = function () { alert("Welcome"); } 
                </script>';
                $request->lastRedirect();
            }

        }else{
            $request->lastRedirect();
        };
    }

    public function logout(){
        session_destroy();
        return redirect('home.index');
    }

    public function register(){
        return $this->view('security/registration.twig');
    }

    public function create(HttpRequest $request){

        //Récupération des valeus POST
        //Traitement des valeurs POST par la méthode validator
        $values = $request->validator(
            [
                'pseudoUser'  => ['required'],
                'birthdateUser'  => ['required'],
                'emailUser' =>  ['email'],
                'passwordUser' => ['min:8'],
                'passwordUserConfirmation' => ['passverif'],
            ]
        );

        //Insertion des valeurs dans la base de donnée
        $user = new User($this->getDB());
        $user = $user->create($values['emailUser'],$values['pseudoUser'],password_hash($values['passwordUser'], PASSWORD_DEFAULT),$values['birthdateUser'],0 );

        return redirect('user.connect');
    }

    public function index(){
        return $this->view('security/password.twig');
    }

    public function password(HttpRequest $request){
        $values = $request->validator(
            [
                'mail'  => ['required'],
            ]
        );
        $password = uniqid();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $subject = 'Mot de passe oublié';
        $message = "Bonjour, voici votre nouveau mot de passe : $password";
        $headers = 'Content-Type: text/plain; charset="UTF-8"';
        
        if (mail($values['mail'], $subject, $message, $headers)) {
            $req = $this->db->getPDO()->prepare("UPDATE USER SET passwordUser = ? WHERE emailUser = ?");
            $req->execute([$hashedPassword, $values['mail']]);
            echo "E-mail envoyé";
        } else {
            echo "Une erreur est survenue";
        }

    }

}