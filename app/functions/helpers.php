<?php

Use App\https\HttpRequest;

function route($name, $params = [])
{
    //supprimer les variables de sessions
    unset($_SESSION['errors']);
    unset($_SESSION['input']);
    $path = Route::url($name, $params);
    echo $path;
}

function redirect($name, $params = []){
    //supprimer les variables de sessions
    unset($_SESSION['errors']);
    unset($_SESSION['input']);
    $path = Route::url($name, $params);
    header('Location:'.$path);
}


//Erreurs formulaires
function Errors(){
    $request = new HttpRequest();

    //getErrors retourne un tableau d'erreurs
    $errors = $request->getErrors();
    $dataErrors = [];

    if(!empty($errors)){
        foreach ($errors as $key => $value){
            //fusionner tous mes tableaux
            //implode => conversion en chaîne de charactères
            $dataErrors = array_merge_recursive($dataErrors, array($key => implode($value)));
        }
    }
    return isset($dataErrors) ? $dataErrors : "";
}