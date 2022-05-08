<?php

use Database\DBConnection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

abstract class Controller{

    //connexion à la base de donnée
    protected $db;

    public function __construct(DBConnection $db){
        $this->db = $db;
    }

    public function view($path, $datas = []){


        //mécanique de twig
        $loader = new FilesystemLoader('../ressources/views');
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        //ajouter fonction twig route
        $twig->addFunction(new TwigFunction('route', function ($name, $params = []) {
            return route($name, $params);
        }));

        $twig->addGlobal('error', Errors());
        $twig->addGlobal('auth', Auth());


        echo $twig->render($path,$datas);
    }

    protected function getDB(){
        return $this->db;
    }

}


