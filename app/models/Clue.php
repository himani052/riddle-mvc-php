<?php

namespace App\models;

use Model;

class Clue extends Model {

    protected $table = '`CLUE`';
    protected $id = '`idClue`';


    public function create( $titleClue, $descriptionClue, $imageClue, $idRiddle)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `CLUE` (titleClue, descriptionClue ,imageClue, riddle_idRiddle) VALUES (:titleClue, :descriptionClue ,:imageClue, :riddle_idRiddle)');

        return $req->execute(array(
            'titleClue' => $titleClue,
            'descriptionClue' => $descriptionClue ,
            'imageClue' => $imageClue,
            'riddle_idRiddle' => $idRiddle
        ));
    }

    public function update( $titleClue, $descriptionClue, $imageClue, $idClue)
    {
        $req = $this->db->getPDO()->prepare('UPDATE `CLUE` SET titleClue = :titleClue, descriptionClue = :descriptionClue ,imageClue = :imageClue WHERE idClue = :idClue');

        return $req->execute(array(
            'idClue' => $idClue,
            'titleClue' => $titleClue,
            'descriptionClue' => $descriptionClue ,
            'imageClue' => $imageClue,
        ));
    }

    public function findClueRiddle($idRiddle){
        $stmt = $this->db->getPDO()->prepare("SELECT DISTINCT idClue, titleClue, descriptionClue, imageClue FROM `COURSES_DETAILS` WHERE idRiddle = ?;");
        $stmt->execute([$idRiddle]);
        return $stmt->fetchAll();
    }


}