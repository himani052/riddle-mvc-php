<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\Comment;
use App\models\User;
use Controller;

class CommentController extends Controller {

    public function index(){

    }

    public function create(HttpRequest $request){


        //récupération du champ post idparcours
        $idCourse = $request->name('idCourse');
        

        //Valeurs post récupérées traités par la méthode validator
        $feilds = $request->validator(
            [
                'usercomment' => ['required']
            ]
        );

        //Insertion des commentaires dans la base
        $comment = new Comment($this->getDB());
        if(!empty($request->session('email'))){
            //Si l'utilisateur a un compte, utiliser son pseudo pour le commentaire
            $comment->create($feilds['usercomment'], $request->session('email'), $idCourse, NULL);

            //Récupérer les informations de l'utilisateur ayant inscris un commentaire
            $user = new User($this->getDB());
            $user = $user->findUserCommentByCourse($idCourse, $request->session('email'));



        }else{
            //Si l'utilisateur n'a pas de compte, utiliser le pseudo qu'il a renseigné
            $comment->create($feilds['usercomment'], NULL, $idCourse, $feilds['pseudo']);
        }



        return redirect('course.show', ['id' => $idCourse]);

    }

    public function delete($idComment, $idCourse){

        if(isAdmin() != true){
            return redirect('home.index');
        }

        $comment = new Comment($this->getDB());
        $comment->removeById($idComment);

        return redirect('course.show', ['id' => $idCourse]);

    }



}