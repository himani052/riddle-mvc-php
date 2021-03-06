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

    public function update($idCourse,$titleCourse,$descriptionCourse,$imageCourse,$distanceCourse){

        $req = $this->db->getPDO()->prepare('UPDATE `COURSE` SET titleCourse = :titleCourse, descriptionCourse = :descriptionCourse, imageCourse = :imageCourse, distanceCourse = :distanceCourse WHERE idCourse = :idcourse');

        return $req->execute(array(
            'idcourse' => $idCourse,
            'titleCourse' => $titleCourse,
            'descriptionCourse' => $descriptionCourse ,
            'imageCourse' => $imageCourse,
            'distanceCourse' => $distanceCourse,
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


    public function classementUsersParcoursShow($idParcours){
        $req = $this->db->getPDO()->prepare("SELECT * FROM COURSE_PARTICIPANT WHERE course_idCourse = ? ORDER BY scoreUser LIMIT 3");
        $req->execute([$idParcours]);
        return $req->fetchAll();
    }

    public function findAllCourseFromPlayer($emailUser){
        $req = $this->db->getPDO()->prepare("SELECT * FROM COURSE_PARTICIPANT WHERE emailUser = ? ");
        $req->execute([$emailUser]);
        return $req->fetchAll();
    }

    public function findAllCoursesPlayed(){
        $req = $this->db->getPDO()->query("SELECT * FROM COURSE_PARTICIPANT ORDER BY scoreUser DESC LIMIT 15");
        return $req->fetchAll();
    }

    public function countPlayerByCourse($idCourse){
        $req = $this->db->getPDO()->prepare("SELECT COUNT(emailUser) AS count FROM COURSE_PARTICIPANT WHERE course_idCourse = ? ");
        $req->execute([$idCourse]);
        return $req->fetchAll();
    }

}

