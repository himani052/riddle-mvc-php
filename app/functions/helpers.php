<?php

function route($name, $params = [])
{
    $path = Route::url($name, $params);
    echo $path;
}

function redirect($name, $params = []){
    $path = Route::url($name, $params);
    header('Location:'.$path);
}