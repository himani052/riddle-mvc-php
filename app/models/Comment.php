<?php

namespace App\models;

use Model;

class Comment extends Model {

    protected $table = 'comment';

    public function create($description,$userEmailUser,$parcoursId)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO comment (description, user_emailUser, parcours_id) VALUES (:description, :user_emailUser, :parcours_id)');

        return $req->execute(array(
            'description' => $description,
            'user_emailUser' => $userEmailUser,
            'parcours_id' => $parcoursId,
        ));

    }
}

