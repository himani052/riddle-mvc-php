<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\Clue;
use App\models\Comment;
use App\models\Course;
use App\models\Location;
use App\models\Riddle;
use App\models\User;
use Controller;
use Database\DBConnection;
use DateTime;


class CourseController extends Controller
{

    public function index(){

        $course = new Course($this->getDB());
        $courses = $course->all();

        return $this->view('course/index.twig', compact('courses'));

    }

    public function show($id){

        //course
        $course = new Course($this->getDB());
        $course = $course->findById($id);

        //Afficher la liste des participants au parcours classés par meilleures score (limité à 3)
        $user = new Course($this->getDB());
        $users = $user->classementUsersParcoursShow($id);

        foreach ($users as $user){
            $firstDate  = $user->timeStartCourseUser;
            $secondDate = $user->timeEndCourseUser;

            //$user->interval = $this->dateDiff($firstDate,$secondDate);

            date_default_timezone_set('Europe/London');
            $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $firstDate);
            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $secondDate);

            $interval = $date1->diff($date2);

            //interval en jour, min, heures
            if($interval->days != null){
                $user->interval = $interval->days.' jours, '.$interval->h.' h '.$interval->i.' min '.$interval->s.' s';
            }else{
                $user->interval = $interval->h.' h '.$interval->i.' min '.$interval->s.' s';
            }

            //interval en heures
            //$user->interval = $interval->days*24 + $interval->h;

        }

        //comments
        $req = $this->db->getPDO()->prepare("SELECT * FROM COMMENT WHERE course_idCourse = ? ");
        $req->execute([$id]);
        $comments = $req->fetchAll();



        return $this->view('course/show.twig', compact('course', 'users', 'comments'));

    }



    public function play(HttpRequest $request){


        $date = date("Y-m-d H:i:s");
        $mail = $request->session('email');
        // $req = $this->db->getPDO()->query("INSERT INTO `SCORE_USER_COURSE` (`scoreUser`, `user_emailUser`,`course_idCourse`, `timeStartCourseUser`, `timeEndCourseUser`) VALUES (DEFAULT, $mail, 'id', DEFAULT, DEFAULT");
        // $users =  $req->fetchAll();
        if (isset($_POST['commencer'])) {
            $req = $this->db->getPDO()->prepare('UPDATE SCORE_USER_COURSE SET timeStartCourseUser =:timeStartCourseUser WHERE course_idCourse =:course_idCourse');
            $req->execute(array(
                'timeStartCourseUser' => $date,
                'course_idCourse' => (int)($_POST['idCourse'])
            ));
        }
        if (isset($_POST['terminer'])) {
            $req = $this->db->getPDO()->prepare('UPDATE SCORE_USER_COURSE SET timeEndCourseUser =:timeStartCourseUser WHERE course_idCourse =:course_idCourse');
            $req->execute(array(
                'timeStartCourseUser' => $date,
                'course_idCourse' => (int)($_POST['idCourse'])
            ));

        }
        return redirect('course.show.play', ['id' => $_POST['idCourse']]);
    }



    public function playshow($id){


        //Récupération des informations du parcours
        $course = new Course($this->getDB());
        $course = $course->findById($id);

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

        return $this->view('course/play/index.twig',compact('id','course', 'courseLocations'));
    }

}