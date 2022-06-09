<?php

namespace App\controllers;

use Controller;

class AboutController extends Controller
{
    function index()
    {
        return $this->view('about/index.twig');
    }
}