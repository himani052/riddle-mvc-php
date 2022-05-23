<?php

namespace App\controllers\Account\Admin;

use App\models\Course;
use App\models\User;
use Controller;

class AdminCourseController extends Controller {

    public function index(){

        $course = new Course($this->getDB());
        $courses = $course->allFromView('`COURSE_INFORMATIONS`');

        return $this->view('account/admin/course/index.twig', compact('courses'));
    }

    public function show($id){

        $course = new Course($this->getDB());
        $course = $course->findByFromView($id,'`COURSE_INFORMATIONS`');

        return $this->view('account/admin/course/show.twig', compact('course'));
    }


}