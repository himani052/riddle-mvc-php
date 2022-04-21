<?php

use App\https\HttpRequest;
use Database\DBConnection;

class Request{

    private $path;
    private $action;
    private $params = [];
    private $request;
    private $routename;

    /**
     * Constructor.
     * @param $path
     * @param $action
     * @param $request
     */
    public function __construct($path, $action)
    {
        $this->request = new HttpRequest();
        //On enlève les / de l'url récupéré
        $this->path = trim($path, '/');
        $this->action = $action;
    }


    /**
     * Méthode permettant d'appeler les routes et leurs paramètres
     * @param $name
     */
    public function name($name = null){

        //tableau avec indice
        //A chaque name de la route correspond un path
        //la fonction retourne un tableau avec une clé indexée
        $this->routename[$name][] = $this->path ;
        return $this->routename;
    }

    /**
     * Méthode qui va comparer l'url de l'utilisateur et celle existantes
     * @param $url
     */
    public function match($url){

        //remplacer tous les caractères alpha numériques par tout sauf des /
        $path = preg_replace('#({[\w]+})#', '([^/]+)', $this->path );

        //passer le chemin complet dans une exp regulière
        //Remplacer toute la chaine
        $pathToMatch = "#^$path$#";

        //comparer le contenu du match avec ce que donne l'url
        //résultat stocké dans result
        if(preg_match($pathToMatch, $url, $results)){

            //On recupere les parametres de l'url en écrasant la 1ere valeur du tableau
            array_shift($results);
            $this->params = $results;

            //Si ça match retourner true
            return true;
        }
        else{
            //si ça ne marche pas retourner false
            return false;
        }
    }


    public function execute(){
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $this->getRequest();
        }else
        {
            $this->postRequest();
        }
    }

    public function getRequest(){

        if(is_string($this->action)){
            $action = explode('@', $this->action);
            $controller = $action[0];
            $controller = new $controller(new DBConnection('riddle-test', 'localhost', 'root', ''));
            $method = $action[1];
            return isset($this->params) ? $controller->$method(implode($this->params)) : $controller->$method(); isset($this->params) ? $controller->method(implode($this->params)) : $controller->method();
        }else{
            call_user_func_array($this->action, $this->params);
        }
    }


    public function postRequest(){
        if(is_string($this->action)) {
            $action = explode('@', $this->action);
            $controller = $action[0];
            $controller = new $controller(new DBConnection('riddle-test', 'localhost', 'root', ''));
            $method = $action[1];
            return isset($this->params) ? $controller->$method($this->request, implode($this->params)) : $controller->$method($this->request);
        }else{
            call_user_func_array($this->action, $this->params);
        }
    }



}
