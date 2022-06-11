<?php

namespace App\controllers;

use App\functions\Timer;
use App\https\HttpRequest;
use App\models\Comment;
use App\models\Course;
use App\models\User;
use Controller;
use Database\DBConnection;


class CourseController extends Controller
{

    public function index(){

        $course = new Course($this->getDB());
        $courses = $course->all();

        return $this->view('course/index.twig', compact('courses'));

    }

    public function show($id){

        //course
        $parc = new Course($this->getDB());
        $parc = $parc->findById($id);

        //users
        $req = $this->db->getPDO()->query("SELECT * FROM user LIMIT 3");
        $users =  $req->fetchAll();

        //comments
        $req = $this->db->getPDO()->prepare("SELECT * FROM comment WHERE course_idCourse = ? ");
        $req->execute([$id]);
        $comments = $req->fetchAll();


        return $this->view('course/show.twig', compact('parc', 'users', 'comments'));

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
        return $this->view('course/play/index.twig', ['id' => $id]);
    }

}