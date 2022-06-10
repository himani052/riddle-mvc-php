<?php

namespace App\models;

use Model;

class Riddle extends Model {

    protected $table = '`Riddle`';
    protected $id = '`idRiddle`';

    public function create( $titleRiddle, $descriptionRiddle, $imageRiddle, $solutionRiddle, $idLocation)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `Riddle` (titleRiddle, descriptionRiddle,imageRiddle, solutionRiddle, location_idLocation) VALUES (:titleRiddle, :descriptionRiddle,:imageRiddle, :solutionRiddle, :location_idLocation)');

        return $req->execute(array(
            'titleRiddle' => $titleRiddle,
            'descriptionRiddle' => $descriptionRiddle ,
            'imageRiddle' => $imageRiddle,
            'solutionRiddle' => $solutionRiddle,
            'location_idLocation' => $idLocation
        ));
    }

    public function findLocationRiddle($idLocation){
        $stmt = $this->db->getPDO()->prepare("SELECT DISTINCT idRiddle, titleRiddle, descriptionRiddle, imageRiddle, solutionRiddle FROM `COURSES_DETAILS` WHERE idLocation = ?;");
        $stmt->execute([$idLocation]);
        return $stmt->fetchAll();
    }

    public function findLastRiddleId(){
        $stmt = $this->db->getPDO()->query("SELECT MAX(idRiddle) AS idRiddle FROM `RIDDLE`;");
        return $stmt->fetch();
    }
}