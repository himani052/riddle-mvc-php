<?php

namespace App\models;

use Model;

class Course extends Model {

    protected $table = '`COURSE`';
    protected $id = '`idCourse`';

    public function create( $titleCourse, $descriptionCourse, $imageCourse, $distanceCourse, $creatorCourse)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `COURSE` (titleCourse, descriptionCourse,imageCourse, distanceCourse, creatorCourse) VALUES (:titleCourse, :descriptionCourse, :imageCourse, :distanceCourse, :creatorCourse)');

        return $req->execute(array(
            'titleCourse' => $titleCourse,
            'descriptionCourse' => $descriptionCourse ,
            'imageCourse' => $imageCourse,
            'distanceCourse' => $distanceCourse,
            'creatorCourse' => $creatorCourse
        ));
    }

    /*public function findLastCourse(){
        $req = $this->db->getPDO()->query("SELECT * FROM `COURSE` ORDER BY `creationDateCourse` DESC LIMIT 1");
        return $req->fetch();
    }*/


    public function findLastCourse($emailUser){
        $req = $this->db->getPDO()->prepare("SELECT * FROM `COURSE` WHERE creatorCourse = ? ORDER BY `creationDateCourse` DESC LIMIT 1");
        $req->execute([$emailUser]);
        return $req->fetch();
    }

    public function joinCreatedCourseWithUser($emailUser){
        $req = $this->db->getPDO()->prepare('INSERT INTO `score_user_course` (user_emailUser, course_idCourse) VALUES ( :emailUser , :idCourse )');

        var_dump($this->findLastCourse());


        return $req->execute(array(
            'emailUser' => $emailUser,
            'idCourse' => $this->findLastCourse()->idCourse
        ));
    }

    public function findCourseByUser($emailUser){
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM `COURSE_BY_CREATOR`  WHERE `emailUser` = ?;");
        $stmt->execute([$emailUser]);
        return $stmt->fetchAll();
    }

    public function findCourseDetails($idCourse){

        $stmt = $this->db->getPDO()->prepare("SELECT * FROM `COURSES_DETAILS` WHERE `course_idCourse` = ? ;");
        $stmt->execute([$idCourse]);
        return $stmt->fetchAll();
    }





}

