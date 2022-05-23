<?php

//initialiser la session
session_start();

require_once "../vendor/autoload.php";

//Appel de la méthode chargé d'exécuter les routes
Route::run();

