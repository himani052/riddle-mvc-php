<?php

namespace App\models;

use Model;

class Course extends Model {

    protected $table = '`COURSE`';
    protected $id = '`idCourse`';

    public function create( $titleCourse, $descriptionCourse, $imageCourse, $distanceCourse)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `COURSE` (titleCourse, descriptionCourse,imageCourse, distanceCourse) VALUES (:titleCourse, :descriptionCourse, :imageCourse, :distanceCourse)');

        return $req->execute(array(
            'titleCourse' => $titleCourse,
            'descriptionCourse' => $descriptionCourse ,
            'imageCourse' => $imageCourse,
            'distanceCourse' => $distanceCourse
        ));

    }

}

