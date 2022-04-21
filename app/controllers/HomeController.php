<?php

namespace App\controllers;

use App\https\HttpRequest;
use Controller;
use Database\DBConnection;


class HomeController extends Controller
{
    public function index(){
        //appel de la vue avec twig
        $req = $this->bd->getPDO()->query('SELECT * FROM user');
        $users = $req->fetchAll();

        return $this->view('home/index.twig', compact('users'));
    }

    public function show($id){
        //echo "Je suis la page show ".$id;

        $req = $this->bd->getPDO()->query('SELECT * FROM user');
        $users = $req->fetchAll();

        return $this->view('home/show.twig', ['id' => $id] );

    }

    public function create(HttpRequest $request){
        //$request->all()
        //donne l'accès au methode post
    }
}