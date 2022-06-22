<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Course;
use App\models\Location;
use Controller;



class AccountLocationController extends Controller
{


    public function createForm($id){

        if(isAuth() != true){
            return redirect('user.connect');
        }
        return $this->view('account/location/create.twig', ['idCourse' => $id]);

    }


    public function create(HttpRequest $request){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('locationImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
            'idCourse',
            'locationTitle' => ['required'],
            'locationDescription' => ['required'],
            'locationAddress' => ['required'],
        ]);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => '/public/assets/img/jpg/courses/default.png']);
        }

        //Insérer les données dans la table course
        var_dump($data);

        $new_location = new Location($this->getDB());
        $new_location->create($data['locationTitle'], $data['locationDescription'], $data['image'], $data['locationAddress'],$data['idCourse'],83000, 83 );


        //Trouver l'id du dernier lieu créé
        $idLocation = $new_location->findLastLocationId()->idLocation;


        return redirect('account.riddle.create', ['id' => $idLocation]);

    }

    public function update($idCourse,$idLocation){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        $location = new Location($this->getDB());
        $location = $location->findById($idLocation);

        return $this->view('account/location/update.twig', ['idCourse' => $idCourse, 'location' => $location ]);

    }

    public function updatepost(HttpRequest $request){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('locationImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
            'idLocation',
            'idCourse',
            'locationTitle' => ['required'],
            'locationDescription' => ['required'],
            'locationAddress' => ['required'],
        ]);


        $location = new Location($this->getDB());
        $location = $location->findById($value['idLocation']);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => $location->imageLocation]);
        }


        $update_location = new Location($this->getDB());
        $update_location->update($data['locationTitle'], $data['locationDescription'], $data['image'], $data['locationAddress'],83000, 83,$data['idLocation'] );


        return redirect('account.course.show', ['id' => $data['idCourse']]);

    }

    public function delete($idCourse,$idLocation){

        if(isAuth()){
            //Si administrateur supprimer course
            $location = new Location($this->getDB());
            $location->removeById($idLocation);
            return redirect('account.course.show', ['id' => $idCourse]);
        }else{
            //Sinon renvoyer vers la page de login
            return redirect('user.connect');
        }

    }


}