<?php

/**
 * Initialisation de la session
 */
session_start();

/**
 * Chargement automatique de fichier via l'autoload
 */
require_once "../vendor/autoload.php";

/**
 * Appel de la méthode chargée d'exécuter les routes
 */
Route::run();

