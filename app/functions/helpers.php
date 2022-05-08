<?php

Use App\https\HttpRequest;


//Fonction qui va créer un object de request
function request($instance = null){
    if($instance == null){
        $instance = new HttpRequest();
    }
    return $instance;
}


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

//Autentification
function Auth(){
    $request = request();
    return array(
        'status' => $request->session('auth'),
        'username' => $request->session('username'),
        'photo' => $request->session('photo')
    );
}

//Fonction qui verifie s'il s'agit d'un administrateur
function isAdmin(){
    $request = request();
    if($request->session('auth') == 1){
        return true;
    }else{
        return redirect('home.index');
    }
}

