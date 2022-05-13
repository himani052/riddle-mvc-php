<?php

namespace App\models;

use Model;

class Parcours extends Model {

    protected $table = 'parcours';

    public function create($parcoursTitle,$parcoursLieu,$parcoursVille, $parcoursPays, $ckeditor, $image)
    {
        $req = $this->db->getPDO()->prepare('INSERT INTO parcours (titre, lieu, ville, pays, description, image) VALUES (:titre,:lieu,:ville, :pays, :description, :image)');

        return $req->execute(array(
            'titre' => $parcoursTitle,
            'lieu' => $parcoursLieu,
            'ville' => $parcoursVille,
            'pays' => $parcoursPays,
            'description' => $ckeditor ,
            'image' => $image
        ));

    }
}

