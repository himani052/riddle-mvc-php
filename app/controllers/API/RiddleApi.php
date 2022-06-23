<?php

namespace App\controllers\API;


use App\models\User;
use Controller;


class RiddleApi extends Controller
{
    function index()
    {
        $user = new User($this->getDB());
        $users = $user->all();
        $data = serialize($users);
        $output = json_encode($data);
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Lenght: ' . strlen($output));
        echo $output;
    }
}