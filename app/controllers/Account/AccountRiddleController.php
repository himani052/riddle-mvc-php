<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Location;
use App\models\Riddle;
use Controller;



class AccountRiddleController extends Controller
{


    public function createForm($id){

        return $this->view('account/riddle/create.twig');

    }


    public function create(HttpRequest $request){


        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('riddleImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );



        //Récupération de nos champs
        $value = $request->validator([
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

        var_dump($data);

        //Trouver l'id du dernier lieu créé
        $location = new Location($this->getDB());
        $idLocation = $location->findLastLocationId()->idLocation;


        $new_riddle = new Riddle($this->getDB());

        var_dump($data['riddleTitle']);

        $new_riddle->create($data['riddleTitle'], $data['riddleDescription'], $data['riddleSolution'], $data['image'], $idLocation);



        //Dernière énigme créé
        $riddle = new Riddle($this->getDB());
        $idRiddle = $riddle->findLastRiddleId()->idRiddle;

        return redirect('account.clue.create', ['id' => $idRiddle]);

    }

}