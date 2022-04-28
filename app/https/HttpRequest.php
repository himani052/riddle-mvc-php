<?php

namespace App\https;

class HttpRequest{


    protected $posts;
    protected $errors;

    public function __construct(){
        $this->posts = $this->all() ;
    }

    //Permet de récupéré les valeurs posté par formulaire
    public function all(){
        return $_POST;
    }

    //prend le nom des champs
    public function name($field){
        return $_POST[$field];
    }

    //récupérer la dernière URL
    public function lastUrl(){
        return $_SERVER['HTTP_REFERER'];
    }

    //traiter formulaires
    //Fonction qui permet de traiter les éléments post des formulaires et ajouter des contraintes
    public function validator(array $rules){

        foreach ($rules as $key => $valueArray){
            if(array_key_exists($key,$this->posts)){
                //Si la clé rechercher existe dans $_POST, on traverse notre tableau de valeur (ex: required, nb max, ex...)
                foreach ($valueArray as $rule){
                    switch ($rule){
                        case 'required':
                            $this->required($key, $this->posts[$key]);
                            break;
                        case substr($rule, 0,3) == 'max':
                            $this->max($key, $this->posts[$key], $rule);
                            break;
                        case substr($rule, 0,3) == 'min':
                            $this->min($key, $this->posts[$key], $rule);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        if($this->getErrors() != null){
            //var_dump(isset($_SESSION['errors']) ? $_SESSION['errors'] : []);
            header('Location: '.$this->lastUrl());
        }else{
            return $this->all();
        }
    }

    public function required($name, $value){
        //enlever les espaces de début et de fin
        $value = trim($value);

        //traiter les erreurs en affichant qu'un champ est requis
        if(!isset($value) || is_null($value) || empty($value)){
            $this->errors[$name][] = "Veuillez remplir la valeur ".$name;
        }
    }

    public function max($name, $value, $rule){


        //expression régulière : récupérer des entiers plusieurs fois
        preg_match_all('/(\d+)/', $rule, $matches);
        $limit = (int) $matches[0][0];
        if(strlen($value) > $limit){
            $this->errors[$name][] = ucfirst($name)." doit avoir un nombre de charactères inférieur ou égal à $limit";
        }
    }

    public function min($name, $value, $rule){
        //expression régulière : récupérer des entiers plusieurs fois
        preg_match_all('/(\d+)/', $rule, $matches);
        $limit = (int) $matches[0][0];
        if(strlen($value) < $limit){
            $this->errors[$name][] = ucfirst($name)." doit avoir un nombre de charactères supérieur ou égal à $limit";
        }
    }

    //être redirigé sur la même page en cas d'erreurs
    //Afficher les erreurs dans la sessions et les détruires en relançant le bouton submit
    public function getErrors(){
        if(!empty($this->errors)){
            $_SESSION['errors'] = $this->errors;
        }else{
            session_destroy();
        }
        return isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    }
}