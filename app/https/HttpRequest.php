<?php

namespace App\https;

class HttpRequest{


    //Permet de récupéré les valeurs posté par formulaire
    public function all(){
        return $_POST;
    }

    //prend le nom des champs
    public function name($field){
        return $_POST[$field];
    }
}