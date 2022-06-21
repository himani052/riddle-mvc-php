<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Clue;
use App\models\Riddle;
use Controller;



class AccountClueController extends Controller
{


    public function createForm($id){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        return $this->view('account/clue/create.twig', ['idRiddle' => $id]);

    }


    public function create(HttpRequest $request){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('clueImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
            'idRiddle',
            'clueTitle' => ['required'],
            'clueDescription' => ['required'],
        ]);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => '/public/assets/img/jpg/courses/default.png']);
        }


        $new_clue = new Clue($this->getDB());
        $new_clue->create($data['clueTitle'], $data['clueDescription'], $data['image'], $data['idRiddle']);

        return redirect('account.course.index');

    }

    public function update($idCourse,$idLocation,$idRiddle,$idClue){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        $clue = new Clue($this->getDB());
        $clue = $clue->findById($idClue);

        return $this->view('account/clue/update.twig', ['idCourse' => $idCourse,'idLocation' => $idLocation, 'idRiddle' => $idRiddle, 'clue' => $clue]);

    }


    public function updatepost(HttpRequest $request){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('clueImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
            'idClue',
            'idRiddle',
            'idLocation',
            'idCourse',
            'clueTitle' => ['required'],
            'clueDescription' => ['required'],
        ]);

        $clue = new Clue($this->getDB());
        $clue = $clue->findById($value['clueTitle']);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => $clue->imageClue ]);
        }


        $update_clue = new Clue($this->getDB());
        $update_clue->update($data['clueTitle'], $data['clueDescription'], $data['image'], $data['idClue']);

        return redirect('account.course.show', ['id' => $data['idLocation']]);


    }

}