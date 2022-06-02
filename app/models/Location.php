<?php

namespace App\models;

use Model;

class Location extends Model {

    public function findLocationRiddle($idLocation){
        $stmt = $this->db->getPDO()->prepare("SELECT DISTINCT idRiddle, titleRiddle, descriptionRiddle, imageRiddle, solutionRiddle FROM `COURSES_DETAILS` WHERE idLocation = ?;");
        $stmt->execute([$idLocation]);
        return $stmt->fetchAll();
    }

}