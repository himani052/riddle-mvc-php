<?php

namespace App\controllers;

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


    public function create(HttpRequest $request){
        //$request->all()
        //donne l'accès au methode post
    }





}