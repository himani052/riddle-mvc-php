<?php

namespace App\controllers;

use App\https\HttpRequest;
use Controller;


class ContactController extends Controller
{

    public function index()
    {
        return $this->view('contact/index.twig');
    }

    public function send(HttpRequest $request)
    {
        ini_set("smpt_port", 1025);
        $values = $request->validator(
            [
                'mail' => ['requiered'],
                'message' => ['requiered'],
            ]
        );
        $destinataire = 'thomas.es13@gmail.com';
        // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
        $expediteur = $values['mail'];
        $copie = 'adresse@fai.com';
        $copie_cachee = 'adresse@fai.com';
        $objet = 'Contact Riddle'; // Objet du message
        $headers = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Reply-To: ' . $expediteur . "\n"; // Mail de reponse
        $headers .= 'From: "<' . $expediteur . '>"' . "\n"; // Expediteur
        $headers .= 'Delivered-to: ' . $destinataire . "\n"; // Destinataire
        $headers .= 'Cc: ' . $copie . "\n"; // Copie Cc
        $headers .= 'Bcc: ' . $copie_cachee . "\n\n"; // Copie cachée Bcc
        $message = $values['message'];
        if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
        {
            echo 'Votre message a bien été envoyé ';
        } else // Non envoyé
        {
            echo "Votre message n'a pas pu être envoyé";
        }

    }

}