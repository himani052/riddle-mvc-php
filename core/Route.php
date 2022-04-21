<?php

class Route
{

    //variable stockant les routes post et get
    private static $request;

    public static function get($path,$action)
    {
        //stockage des routes de GET - chaînage
        $routes = new Request($path,$action);
        self::$request['GET'][] = $routes;
        return $routes;
    }

    public static function post($path,$action)
    {
        //stockage des routes de POST - chaînage
        $routes = new Request($path,$action);
        self::$request['POST'][] = $routes;
        return $routes;
    }


    public static function run()
    {
        //parcourir routes stockées dans la variable request

    foreach (self::$request[$_SERVER['REQUEST_METHOD']] as $route){

        //méthode qui va comparer l'url de l'utilisateur et celle existantes
        //la vaviable url provient du htacess
        //On enlève les / de début et de fin avec trim
        if($route->match(trim($_GET['url']), '/' )){

            //méthode d'exécussion => obtenir le résultat
            $route->execute();

            //si la route est trouvé j'arrêtre le processus
            die();
        }

        //Si la route n'existe pas afficher une page d'erreur
        header('HTTP/1.0 404 Not found');

    }

    }


    //fonction qui va traiter la fonction name dans la classe Request
    public static function url($name, $parameters = []){

        //parcourir toutes les routes (post ou get)
        foreach (self::$request as $key => $value){
            foreach (self::$request[$key] as $routes){
                //si la cle existe (ex: home.show existe ?)
                if(array_key_exists($name, $routes->name())){
                    //recuperation de la route

                    $route = $routes->name();
                    //transformer la valeur du tableau en chaine de charactere
                    $path = implode($route[$name]);

                    //tester si le parametre est vide
                    if(!empty($parameters)){
                        //parcourir tableau
                        foreach ($parameters as $key => $value){
                            //je remplace le parametre id par la valeur dans le path
                            $url = str_replace("{{$key}}", $value, $path);
                            return '/'.$url;
                        }
                    }else{
                        //si le parametre est vide retourner un slash
                        return "/".$path;
                    }
                }
            }
        }
    }


}
