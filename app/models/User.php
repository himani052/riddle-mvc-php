<?php

namespace App\models;

use Model;

class User extends Model {

    protected $table = '`USER`';
    protected $id = '`emailUser`';



    public function create($emailUser,$pseudoUser, $passwordUser, $birthdateUser, $admin ){

        $req = $this->db->getPDO()->prepare("INSERT INTO `USER` (emailUser, pseudoUser, passwordUser, birthdateUser, admin) VALUES  (:emailUser, :pseudoUser , :passwordUser, :birthdateUser, :admin) ");

        return $req->execute(array(
           'emailUser' => $emailUser,
           'pseudoUser' => $pseudoUser,
            'passwordUser' => $passwordUser,
            'birthdateUser' => $birthdateUser,
            'admin' => $admin
        ));
    }




    //Trouver les commentaires d'un utilisateur par course

    public function findUserCommentByCourse($idCourse, $emailUser) {


        $stmt = $this->db->getPDO()->prepare("
        SELECT * FROM `USER`,`COMMENT`, `COURSE` 
        WHERE course_idCourse = :idCourse 
        AND idCourse = :idCourse2 
        AND user_emailUser = :emailUser
        AND emailUser = :emailUser2
        
        ");

        return $stmt->execute(array(
            'idCourse' => $idCourse,
            'idCourse2' => $idCourse,
            'emailUser' => $emailUser,
            'emailUser2' => $emailUser
        ));



    }

}

