<?php

namespace App\controllers;

use Controller;

class StopwatchController extends Controller
{
    function index()
    {
        return $this->view('stopwatch/index.twig');
    }
}