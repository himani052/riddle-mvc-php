<?php

use Database\DBConnection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class  Controller{

    //connexion à la base de donnée
    protected $bd;

    public function __construct(DBConnection $bd){
        $this->bd = $bd;
    }

    public function view($path, $datas = []){

        //mécanique de twig
        $loader = new FilesystemLoader('../ressources/views');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        //ajouter fonction twig route
        $twig->addFunction(new TwigFunction('route', function ($name, $params = []) {
            return route($name, $params);
        }));

        echo $twig->render($path,$datas);
    }
}