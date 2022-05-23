<?php

namespace App\https;

class HttpRequest{


    protected $posts = [];
    protected $errors = [];

    public function __construct(){
        $this->posts = $this->name($name = null) ;
    }

    //Permet de récupéré les valeurs posté par formulaire
    //prend le nom des champs
    public function name($name = null){

        //Sécurisation
        if($name == null){
            return $_POST;
        }else{
            return $_POST[$name];
        }

    }

    public function session($name, $data = null){
        if(!empty($data) | $data != null){
            $_SESSION[$name] = $data;
        }else{
            return isset($_SESSION[$name]) ? $_SESSION[$name] : "";
        }
    }


    //récupérer la dernière URL
    public function lastUrl(){
        return $_SERVER['HTTP_REFERER'];
    }

    public function lastRedirect(){
        return header('Location: '.$this->lastUrl());
    }

    /* File loaders -------------------------------------------------------------------------------------- */

    // name = post name
    public function loaderFiles($name, $file_dest, array $data){

        //récupération nom du fichier
        $file_name = $_FILES[$name]['name'];

        //récupération des chaînes de charactères à partir du point
        $file_extension = strrchr($file_name,".");

        //récupération stockage temporel
       $file_temp = $_FILES[$name]['tmp_name'];

        //Gestion chemin de destination du fichier
        $file_dest = $file_dest.$file_name;


        //Tester si l'extention du fichier post envoyé correspond aux extensions renseignés en paramètre de la méthode
        if(in_array($file_extension, $data)){
            //Si l'extension est valide
            //Le fichier de la machine local est copier dans le serveur

            if(move_uploaded_file($file_temp, $file_dest)){
                return $file_dest;
            }else{
                echo "Erreur survenue lors du chargement des fichiers";
            }
        }else{
            echo "L'extension n'existe pas";
        }

    }


    /* Validator ---------------------------------------------------------------------------------------- */

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

                    $this->session('input', $this->posts);
                }
            }
        }
        if(!empty($this->getErrors())){
            //var_dump(isset($_SESSION['errors']) ? $_SESSION['errors'] : []);
            header('Location: '.$this->lastUrl());
        }else{
            unset($_SESSION['errors']);
            return $this->name();
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
            $this->session('errors', $this->errors);
            return ($this->session('errors') !== null) ? $this->session('errors') : [];
        }else{
            return ($this->session('errors') !== null ) ? null : [];
        }

        /*
        if(!empty($this->errors)){
            $_SESSION['errors'] = $this->errors;
        }else{
            session_destroy();
        }
        return isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
        */

    }
}