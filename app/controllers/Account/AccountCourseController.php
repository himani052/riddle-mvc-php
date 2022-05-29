<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Course;
use App\models\User;
use Controller;
use Database\DBConnection;


class AccountCourseController extends Controller
{

    public function index(){

        $course = new Course($this->getDB());
        $courses = $course->all();

        return $this->view('account/course/index.twig', compact('courses'));

    }

    public function list(){

        $course = new Course($this->getDB());
        $courses = $course->all();

        return $this->view('account/course/list.twig', compact('courses'));

    }

    public function show($id){

        /*
        $parc = new Course($this->getDB());
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
        $image = $request->loaderFiles('courseImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
            'courseTitle' => ['required'],
            'courseDescription' => ['required'],
            'courseDistance' => ['required'],
        ]);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        $data = array_merge_recursive($value, ['image' => '/public/'.$image]);

        //Insérer les données dans la table course
        var_dump($data);

        $new_course = new Course($this->getDB());

        $new_course->create($data['courseTitle'],$data['courseDescription'], $data['image'],$data['courseDistance']);

        return redirect('account.course.index');

    }

    public function delete($id){

        if(isAdmin()){
            //Si administrateur supprimer course
            $course = new Course($this->getDB());
            $course->removeById($id);
            return redirect('account.course.list');
        }else{
            //Sinon renvoyer vers la page de login
            return redirect('user.connect');
        }

    }


}