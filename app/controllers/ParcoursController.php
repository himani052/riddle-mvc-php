<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\Parcours;
use App\models\User;
use Controller;
use Database\DBConnection;


class ParcoursController extends Controller
{

    public function index(){

        $parc = new Parcours($this->getDB());
        $parcours = $parc->all();

        return $this->view('parcours/index.twig', compact('parcours'));

    }

    public function show($id){

        $parc = new Parcours($this->getDB());
        $parc = $parc->findById($id);

        $req = $this->db->getPDO()->query("SELECT * FROM user LIMIT 3");
        $users =  $req->fetchAll();

        return $this->view('parcours/show.twig', compact('parc', 'users'));


    }

    public function create(HttpRequest $request){
        //$request->all()
        //donne l'accès au methode post
    }
}