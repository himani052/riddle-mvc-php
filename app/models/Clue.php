<?php

namespace App\models;

use Model;

class Clue extends Model {

    protected $table = '`Clue`';
    protected $id = '`idClue`';


    public function create( $titleClue, $descriptionClue, $imageClue, $idRiddle)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `Clue` (titleClue, descriptionClue ,imageClue, riddle_idRiddle) VALUES (:titleClue, :descriptionClue ,:imageClue, :riddle_idRiddle)');

        return $req->execute(array(
            'titleClue' => $titleClue,
            'descriptionClue' => $descriptionClue ,
            'imageClue' => $imageClue,
            'riddle_idRiddle' => $idRiddle
        ));
    }

    public function findClueRiddle($idRiddle){
        $stmt = $this->db->getPDO()->prepare("SELECT DISTINCT idClue, titleClue, descriptionClue, imageClue FROM `COURSES_DETAILS` WHERE idRiddle = ?;");
        $stmt->execute([$idRiddle]);
        return $stmt->fetchAll();
    }


}