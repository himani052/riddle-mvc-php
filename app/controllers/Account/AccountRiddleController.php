<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Location;
use App\models\Riddle;
use Controller;



class AccountRiddleController extends Controller
{


    public function createForm($id){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        return $this->view('account/riddle/create.twig', ['idLocation' => $id]);

    }


    public function create(HttpRequest $request){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('riddleImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );



        //Récupération de nos champs
        $value = $request->validator([
            'idLocation',
            'riddleTitle' => ['required'],
            'riddleDescription' => ['required'],
            'riddleSolution' => ['required'],
        ]);


        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => '/public/assets/img/jpg/courses/default.png']);
        }


        $new_riddle = new Riddle($this->getDB());

        var_dump($data['riddleTitle']);

        $new_riddle->create($data['riddleTitle'], $data['riddleDescription'], $data['riddleSolution'], $data['image'], $data['idLocation']);


        //Dernière énigme créé
        $riddle = new Riddle($this->getDB());
        $idRiddle = $riddle->findLastRiddleId()->idRiddle;

        return redirect('account.clue.create', ['id' => $idRiddle]);

    }

    public function update($idCourse,$idLocation,$idRiddle){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        $riddle = new Riddle($this->getDB());
        $riddle = $riddle->findById($idRiddle);

        return $this->view('account/riddle/update.twig', ['idCourse' => $idCourse, 'idLocation' => $idLocation, 'riddle' => $riddle]);

    }


    public function updatepost(HttpRequest $request){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('riddleImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );



        //Récupération de nos champs
        $value = $request->validator([
            'idRiddle',
            'idLocation',
            'idCourse',
            'riddleTitle' => ['required'],
            'riddleDescription' => ['required'],
            'riddleSolution' => ['required'],
        ]);

        $riddle = new Riddle($this->getDB());
        $riddle = $riddle->findById($value['idRiddle']);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => $riddle->imageRiddle]);
        }


        $update_riddle = new Riddle($this->getDB());
        $update_riddle->update($data['riddleTitle'], $data['riddleDescription'], $data['riddleSolution'], $data['image'], $data['idRiddle']);


        return redirect('account.course.show', ['id' => $data['idCourse']]);

    }

}