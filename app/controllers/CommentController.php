<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\Comment;
use Controller;

class CommentController extends Controller {

    public function index(){
        echo "default controller";
    }

    public function create(HttpRequest $request){

        //récupération du champ post idparcours
        $idParcours = $request->name('idparcours');

        var_dump($idParcours);

        //Valeurs post récupérées
        //$feilds = $request->all();

        $comment = new Comment($this->getDB());
        $comment->create($_POST['ckeditor'],$request->session('email'),$idParcours);

        return redirect('parcours.show', ['id' => $idParcours]);

    }

    public function delete($id, $parcoursID){

        var_dump($parcoursID);

        $comment = new Comment($this->getDB());
        $comment->removeById($id);

        return redirect('parcours.show', ['id' => $parcoursID]);

    }


}