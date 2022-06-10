<?php

namespace App\controllers\API;


use App\models\User;
use Controller;


class RiddleApi extends Controller
{
    function index()
    {
        echo "Hello API";

        $user = new User($this->getDB());
        $users = $user->all();
        
    }
}
