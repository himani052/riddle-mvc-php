<?php

namespace App\controllers\Account\Admin;

use App\models\Course;
use Controller;

class AdminCourseController extends Controller
{

    public function index()
    {

        $course = new Course($this->getDB());
        $courses = $course->allFromView('`COURSE_BY_CREATOR`');

        return $this->view('account/admin/course/index.twig', compact('courses'));
    }

    public function show($id)
    {

        $course = new Course($this->getDB());
        $course = $course->findByFromView($id, '`COURSES_DETAILS`');

        return $this->view('account/admin/course/show.twig', compact('course'));
    }

    public function delete($id)
    {

        if (isAdmin()) {
            //Si administrateur supprimer course
            $course = new Course($this->getDB());
            $course->removeById($id);
            return redirect('admin.course.index');
        } else {
            //Sinon renvoyer vers la page de login
            return redirect('user.connect');
        }

    }

}