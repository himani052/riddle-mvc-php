<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Clue;
use App\models\Course;
use App\models\Location;
use App\models\Riddle;
use App\models\User;
use Controller;
use Database\DBConnection;


class AccountCourseController extends Controller
{

    public function index(){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        $course = new Course($this->getDB());
        $courses = $course->findCourseByUser($_SESSION['email']);

        return $this->view('account/course/index.twig', compact('courses'));

    }

    public function list(){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        $course = new Course($this->getDB());
        $courses = $course->findCourseByUser($_SESSION['email']);


        return $this->view('account/course/list.twig', compact('courses'));

    }

    public function show($id){

        if(isAuth() != true){
            return redirect('user.connect');
        }

        $courseGeneral = new Course($this->getDB());
        $courseGeneral = $courseGeneral->findById($id);

        $courseLocations = new Location($this->getDB());
        $courseLocations = $courseLocations->findCourseLocations($id);



        foreach ($courseLocations as $courseLocation){

            //Affichage des énigmes du parcours
            $locationRiddle = new Riddle($this->getDB());
            $courseLocation->riddles = $locationRiddle->findLocationRiddle($courseLocation->idLocation);


            foreach ($courseLocation->riddles as $riddle) {

                //Affichage des indices des énigmes
                $clueRiddle = new Clue($this->getDB());
                $riddle->clues = $clueRiddle->findClueRiddle($riddle->idRiddle);

            }


        }



        return $this->view('account/course/show.twig', compact('courseGeneral', 'courseLocations'));

    }

    public function createForm(){

        if(isAuth() != true){
            return redirect('home.index');
        }
        return $this->view('account/course/create.twig');

    }

    public function create(HttpRequest $request){

        if(isAuth() != true){
            return redirect('home.index');
        }

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
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => '/public/assets/img/jpg/courses/default.png']);
        }

        //var_dump($_POST['courseImage']);

        //Insérer les données dans la table course
        var_dump($data);

        $new_course = new Course($this->getDB());

        $new_course->create($data['courseTitle'],$data['courseDescription'], $data['image'],$data['courseDistance'],$_SESSION['email']);
        //$new_course->joinCreatedCourseWithUser($_SESSION['email']);


        //trouver l'ID du dernier parcours créé (par l'utilisateur)
        $idCourse = $new_course->findLastCourse($_SESSION['email'])->idCourse;

        return redirect('account.location.create', ['id' => $idCourse]);

    }


    public function updatepost(HttpRequest $request){

        if(isAuth() != true){
            return redirect('home.index');
        }

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('courseImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'] );

        //Récupération de nos champs
        $value = $request->validator([
            'courseId',
            'courseTitle' => ['required'],
            'courseDescription' => ['required'],
            'courseDistance' => ['required'],
        ]);


        $course = new Course($this->getDB());
        $course = $course->findById($value['courseId']);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if(!empty($image)){
            $data = array_merge_recursive($value, ['image' => '/public/'.$image]);
        }else{
            $data = array_merge_recursive($value, ['image' => $course->imageCourse]);
        }

        //Mise à jour du parcours
        $update_course = new Course($this->getDB());
        $update_course->update($data['courseId'], $data['courseTitle'], $data['courseDescription'],$data['image'],$data['courseDistance']);

        return redirect('account.course.show', ['id' => $data['courseId']]);

    }

    public function update($id){

        if(isAuth() != true){
            return redirect('home.index');
        }

        $course = new Course($this->getDB());
        $course = $course->findById($id);



        return $this->view('account/course/update.twig', compact('course'));

    }

    public function delete($id){

        if(isAuth()){
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