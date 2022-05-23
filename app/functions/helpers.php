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
    //unset($_SESSION['errors']);
    //unset($_SESSION['input']);
    $path = Route::url($name, $params);
    header('Location:'.$path);
}


//Garder en mémoire les input saisi après l'envoie du formulaire en cas d'erreur
function setpost(){
    return isset($_SESSION['input']) ? $_SESSION['input'] : "";
}


function session($val){
    return isset($_SESSION[$val]) ? $_SESSION[$val] : "";
}


//Erreurs formulaires
function Errors(){

    //getErrors retourne un tableau d'erreurs
    $errors = session('errors');
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
        'admin' => $request->session('admin'),
        'pseudo' => $request->session('pseudo'),
        'email' => $request->session('email'),
        'photo' => $request->session('photo'),
        'registrationDate' => $request->session('registrationDate'),
    );
}

//Fonction qui verifie s'il s'agit d'un administrateur
function isAdmin(){
    $request = request();
    if($request->session('admin') == 1){
        return true;
    }else{
        return redirect('home.index');
    }
}

