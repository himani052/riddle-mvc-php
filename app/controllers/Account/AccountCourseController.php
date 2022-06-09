<?php

namespace App\controllers\Account;

use App\https\HttpRequest;
use App\models\Course;
use App\models\Location;
use Controller;


class AccountCourseController extends Controller
{

    public function index()
    {

        $course = new Course($this->getDB());
        $courses = $course->findCourseByUser($_SESSION['email']);

        return $this->view('account/course/index.twig', compact('courses'));

    }

    public function list()
    {

        $course = new Course($this->getDB());
        $courses = $course->findCourseByUser($_SESSION['email']);


        return $this->view('account/course/list.twig', compact('courses'));

    }

    public function show($id)
    {


        $courseGeneral = new Course($this->getDB());
        $courseGeneral = $courseGeneral->findById($id);

        $courseLocations = new Course($this->getDB());
        $courseLocations = $courseLocations->findCourseLocations($id);

        $arraytempo = array();


        foreach ($courseLocations as $courseLocation) {

            $locationRiddle = new Location($this->getDB());
            $courseLocation->riddles = $locationRiddle->findLocationRiddle($courseLocation->idLocation);
            //$arraytempo[] = $locationRiddle;
        }


        return $this->view('account/course/show.twig', compact('courseGeneral', 'courseLocations'));

    }

    public function createForm()
    {

        return $this->view('account/course/create.twig');

    }

    public function create(HttpRequest $request)
    {

        //Télécharger l'image
        //LoaderFile prendre en paramètre : nom de l'imput + addresse de destination + type de fichier
        $image = $request->loaderFiles('courseImage', 'assets/img/loaders/', ['.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG']);

        //Récupération de nos champs
        $value = $request->validator([
            'courseTitle' => ['required'],
            'courseDescription' => ['required'],
            'courseDistance' => ['required'],
        ]);

        //fusionner tableau de valeur et images
        //image => champs img bdd
        if (!empty($image)) {
            $data = array_merge_recursive($value, ['image' => '/public/' . $image]);
        } else {
            $data = array_merge_recursive($value, ['image' => '/public/assets/img/jpg/courses/default.png']);
        }

        //Insérer les données dans la table course
        var_dump($data);

        $new_course = new Course($this->getDB());

        $new_course->create($data['courseTitle'], $data['courseDescription'], $data['image'], $data['courseDistance'], $_SESSION['email']);
        //$new_course->joinCreatedCourseWithUser($_SESSION['email']);

        return redirect('account.course.index');

    }

    public function delete($id)
    {

        if (isAdmin()) {
            //Si administrateur supprimer course
            $course = new Course($this->getDB());
            $course->removeById($id);
            return redirect('account.course.list');
        } else {
            //Sinon renvoyer vers la page de login
            return redirect('user.connect');
        }

    }


}