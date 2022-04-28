<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\User;
use Controller;
use Database\DBConnection;


class HomeController extends Controller
{
    public function index(){

        $user = new User($this->getDB());
        $users = $user->all();

        //$req = $this->db->getPDO()->query('SELECT * FROM user');
        //$users = $req->fetchAll();

        //appel de la vue avec twig
        return $this->view('home/index.twig', compact('users'));
    }

    public function show($id){
        //echo "Je suis la page show ".$id;

        $req = $this->db->getPDO()->query('SELECT * FROM user');
        $users = $req->fetchAll();

        return $this->view('home/show.twig', ['id' => $id] );

    }

    public function create(HttpRequest $request){
        //$request->all()
        //donne l'accès au methode post
    }
}