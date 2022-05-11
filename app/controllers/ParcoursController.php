<?php

namespace App\controllers;

use App\https\HttpRequest;
use App\models\Comment;
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

        //parcours
        $parc = new Parcours($this->getDB());
        $parc = $parc->findById($id);

        //users
        $req = $this->db->getPDO()->query("SELECT * FROM user LIMIT 3");
        $users =  $req->fetchAll();

        //comments
        $req = $this->db->getPDO()->prepare("SELECT * FROM comment WHERE parcours_id = ? ");
        $req->execute([$id]);
        $comments = $req->fetchAll();


        return $this->view('parcours/show.twig', compact('parc', 'users', 'comments'));


    }


    public function create(HttpRequest $request){
        //$request->all()
        //donne l'accès au methode post
    }





}