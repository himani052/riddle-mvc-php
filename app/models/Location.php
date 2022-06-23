<?php

namespace App\models;

use Model;

class Location extends Model {

    protected $table = '`LOCATION`';
    protected $id = '`idLocation`';


    public function create( $titleLocation, $descriptionLocation, $imageLocation, $addressLocation, $idCourse, $codeCity, $codeDepartment)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO `LOCATION` (titleLocation, descriptionLocation,imageLocation, addressLocation, course_idCourse, department_codeDepartment, city_codeCity) VALUES (:titleLocation, :descriptionLocation,:imageLocation, :addressLocation, :course_idCourse, :department_codeDepartment, :city_codeCity)');

        return $req->execute(array(
            'titleLocation' => $titleLocation,
            'descriptionLocation' => $descriptionLocation ,
            'imageLocation' => $imageLocation,
            'addressLocation' => $addressLocation,
            'course_idCourse' => $idCourse,
            'department_codeDepartment' => $codeDepartment,
            'city_codeCity' => $codeCity

        ));
    }

    public function update($titleLocation, $descriptionLocation, $imageLocation, $addressLocation, $codeCity, $codeDepartment,$idLocation)
    {
        $req = $this->db->getPDO()->prepare('UPDATE `LOCATION` SET titleLocation = :titleLocation, descriptionLocation = :descriptionLocation , imageLocation = :imageLocation, addressLocation = :addressLocation, department_codeDepartment = :department_codeDepartment, city_codeCity = :city_codeCity WHERE idLocation = :idLocation');

        return $req->execute(array(
            'titleLocation' => $titleLocation,
            'descriptionLocation' => $descriptionLocation ,
            'imageLocation' => $imageLocation,
            'addressLocation' => $addressLocation,
            'department_codeDepartment' => $codeDepartment,
            'city_codeCity' => $codeCity,
            'idLocation' => $idLocation,
        ));
    }

    public function findCourseLocations($idCourse){
        $stmt = $this->db->getPDO()->prepare("SELECT DISTINCT idLocation, titleLocation, descriptionLocation, imageLocation, addressLocation, city_codeCity, department_codeDepartment FROM `COURSES_DETAILS` WHERE idCourse = ?;");
        $stmt->execute([$idCourse]);
        return $stmt->fetchAll();
    }

    public function findLastLocationId(){
        $stmt = $this->db->getPDO()->query("SELECT MAX(idLocation) AS idLocation FROM `LOCATION`;");
        return $stmt->fetch();
    }

}