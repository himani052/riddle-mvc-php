<?php

namespace App\controllers;

use App\https\HttpRequest;
use Controller;

class DefaultController extends Controller {

    public function index(){
        echo "default controller";
    }

    public function traitement(HttpRequest $request){

        echo "traiter formulaire";
    }

}