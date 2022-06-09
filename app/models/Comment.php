<?php

namespace App\models;

use Model;

class Comment extends Model
{

    protected $table = '`COMMENT`';
    protected $id = '`idComment`';

    public function create($descriptionComment, $userEmail, $courseId, $pseudoUserNotRegistered)
    {
        $req = $this->db->getPDO()->prepare("INSERT INTO COMMENT (descriptionComment,user_emailUser,course_idCourse, pseudoUserNotRegistered) VALUES (:descriptionComment,:user_emailUser,:course_idCourse, :pseudoUserNotRegistered )");

        return $req->execute(array(
            'descriptionComment' => $descriptionComment,
            'user_emailUser' => $userEmail,
            'course_idCourse' => $courseId,
            'pseudoUserNotRegistered' => $pseudoUserNotRegistered
        ));

    }


}

