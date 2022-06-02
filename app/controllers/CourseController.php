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


    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }



    public function play(HttpRequest $request){


        //$exec_time = $time_post - $time_pre;


        /*
        $chrono = 0;
        echo 'Chrono ='.$chrono;

        if($_POST['start']){

            var_dump($_POST['start']);

            $time_start = $this->microtime_float();

            if($_POST['end']){
                $time_end = $this->microtime_float();
                $time = $time_end - $time_start;
                $chrono = $time;

                echo 'La partie a durée '.$chrono.' minutes';
            }{
                echo 'end not found';
            }

        }else{
            echo 'start not found';
        }
        */

        return redirect('course.show.play');

    }

    public function playshow(){


        $time_start = $this->microtime_float();

        var_dump($time_start);


        return $this->view('course/play/index.twig');

    }




}