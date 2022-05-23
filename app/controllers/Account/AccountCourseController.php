<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Parcours;
use App\models\User;
use Controller;
use Database\DBConnection;


class AccountParcoursController extends Controller
{

    public function index(){

        $course = new Parcours($this->getDB());
        $courses = $course->all();

        return $this->view('account/course/index.twig', compact('courses'));

    }

    public function list(){

        $course = new Parcours($this->getDB());
        $courses = $course->all();

        return $this->view('account/course/list.twig', compact('course'));

    }

    public function show($id){

        /*
        $parc = new Parcours($this->getDB());
        $parc = $parc->findById($id);

        $req = $this->db->getPDO()->query("SELECT * FROM user LIMIT 3");
        $users =  $req->fetchAll();

        return $this->view('course/show.twig', compact('parc', 'users'));*/


    }

    public function createForm(){

        return $this->view('account/course/create.twig');

    }

    public function create(HttpRequest $request){

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('parcoursImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
           'parcoursTitle' => ['required'],
            'parcoursLieu' => ['required'],
            'parcoursVille' => ['required'],
            'parcoursPays'  => ['required'],
            'ckeditor' => ['required'],
            'parcoursImage' => ['required'],
        ]);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        $data = array_merge_recursive($value, ['image' => '/public/'.$image]);

        //Insérer les données dans la table course
        //var_dump($data);

        $parcours = new Parcours($this->getDB());

        $parcours->create($data['parcoursTitle'],$data['parcoursLieu'], $data['parcoursVille'],$data['parcoursPays'],$data['ckeditor'],$data['image']);

        return redirect('account.course.index');

    }

    public function delete($id){

        if(isAdmin()){
            //Si administrateur supprimer course
            $parcours = new Parcours($this->getDB());
            $parcours->removeById($id);
            return redirect('account.course.list');
        }else{
            //Sinon renvoyer vers la page de login
            return redirect('user.connect');
        }



    }


}