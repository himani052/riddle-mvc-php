<?php

namespace App\controllers;

use App\https\HttpRequest;
use Controller;
use Database\DBConnection;


class ParcoursController extends Controller
{

    public function index(){
        //appel de la vue avec twig
        $req = $this->bd->getPDO()->query('SELECT * FROM parcours');
        $parcours = $req->fetchAll();

        return $this->view('parcours/index.twig', compact('parcours'));

    }

    public function show($id){
        //echo "Je suis la page show ".$id;

        $req = $this->bd->getPDO()->prepare("SELECT * FROM parcours WHERE id = :id");
        $req->execute(array('id' => $id));
        $parc = $req->fetch();

        $req = $this->bd->getPDO()->query("SELECT * FROM user LIMIT 3");
        $users =  $req->fetchAll();

        return $this->view('parcours/show.twig', compact('parc', 'users'));


    }

    public function create(HttpRequest $request){
        //$request->all()
        //donne l'accès au methode post
    }
}