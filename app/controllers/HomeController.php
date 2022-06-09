<?php

namespace App\controllers;

use App\models\User;
use Controller;


class HomeController extends Controller
{
    public function index()
    {

        $user = new User($this->getDB());
        $users = $user->all();

        //$user = new User($this->getDB());
        //$user = $user->where('emailUser', '=','houssam.imani@gmail.com');

        //appel de la vue avec twig
        return $this->view('home/index.twig', compact('users'));
    }

    public function show($id)
    {
        //echo "Je suis la page show ".$id;

        $req = $this->db->getPDO()->query('SELECT * FROM `USER`');
        $users = $req->fetchAll();

        return $this->view('home/show.twig', ['id' => $id]);

    }


}