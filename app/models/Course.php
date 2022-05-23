<?php

namespace App\models;

use Model;

class Parcours extends Model {

    protected $table = '`COURSE`';
    protected $id = '`idCourse`';

    public function create( $titleCourse, $descriptionCourse, $imageCourse)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `COURSE` (titleCourse, descriptionCourse,imageCourse) VALUES (:titleCourse, :descriptionCourse, :imageCourse)');

        return $req->execute(array(
            'titleCourse' => $titleCourse,
            'descriptionCourse' => $descriptionCourse ,
            'imageCourse' => $imageCourse
        ));

    }
}

