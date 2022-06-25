<?php

namespace App\controllers\Account\Admin;

use App\https\HttpRequest;
use App\models\User;
use Controller;

class AdminUserController extends Controller {

    public function index(){

        if(isAdmin() != true){
            return redirect('home.index');
        }

        $user = new User($this->getDB());
        $users = $user->all();

        return $this->view('account/admin/user/index.twig', compact('users'));
    }

    public function show($emailUser){

        if(isAdmin() != true){
            return redirect('home.index');
        }

        $user = new User($this->getDB());
        $user = $user->findByEmail($emailUser);

        return $this->view('account/admin/user/show.twig', compact('user'));
    }

    public function edit(HttpRequest $request){

        if(isAdmin() != true){
            return redirect('home.index');
        }

        //récupération du champ post
        $roleUser = $_POST['roleUser'];
        $emailUser =  $_POST['emailUser'];

        $user = new User($this->getDB());
        $user->changeRole($emailUser,$roleUser);

        //redirection
        return redirect('admin.user.show', ['emailUser' => $emailUser]);
    }

    public function delete($email){
        if(isAdmin()){
            //Si administrateur supprimer course
            $user = new User($this->getDB());
            $user->removeByEmail($email);
            return redirect('admin.user.index');
        }else{
            //Sinon renvoyer vers la page de login
            return redirect('home.index');
        }
    }

}