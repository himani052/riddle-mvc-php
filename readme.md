#PHP MVC Framework 


On a fait le choix de faire notre documentation en français (pour faciliter la compréhension entre nous, 
mais de programmer en anglais pour la réutilisation)



##Installation 

0. Installer composer
   
1. Réécriture d'url avec htacess (accéder à la page index)
   

2. Installation de l'autoloader 
> Permet de charger certaines pages automatiquement et évite ainsi d'avoir à utiliser 
> plusieurs `require()`. Dans notre cas, l'autoloader va permettre de charger automatiquement les classes via les répertoires
> qu'on lui a indiqué. Pour cela on commence par initialiser notre projet grâce à la commande `composer init`. 
> Dans le fichier composer.json géré on a le code suivant :
````json{
"name": "riddle/mvc-framework",
"autoload": {
"psr-4":{
"App\\": "app",
"": "core/"
},
"files": ["routes/routes.php"]
},
"require": {}
}
````
> Par la suite on créer l'autoloader avec la commande `composer dump-autoload`

2. On remplace nos paramètre par des expressions régulières. (ex: show/{id})


2. Installer twig (dernière version). `composer require "twig/twig:^3.0"` 


limiter le text avec twig 
{{ var.content[0:200]|striptags}}


//implémenter autoloader css pour charger img plus rapidement 


## Sécurisation

Lorsque l'utilisateur cherche à supprimer un parcours en étant non connecté via
l'url 'http://riddle-2/account/parcours/delete/7', il est automatiquement renvoyé vers 
la page de connection. 


Insérer images dans formulaires
``enctype="multipart/form-data"``





## Envoyer des smiley dans la bdd et les Afficher via le client php  

Pour insérer les smiley via Mysql il faut s'assurer d'avoir des caractères en UTF8mb4. Pour cela nous avons mise
à jour Mysql vers sa dernière version (MySQL 8) et la dernière version de PHPMyAdmin. A la creation de la 
table on s'assure qu'elle ai bien en UTF8mb4.

Au niveau du code PHP, il est important d'indiquer le format des caractères.  

````php 
$this->pdo = new \PDO("mysql:dbname={$this->dbname};host={$this->host};charset=utf8mb4", $this->username, $this->password,
[
//Thoose options transform it into object/
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
//UTF-8 characters
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
]
);
````

## Utilisation de Tiny Cloud Emoticon API pour afficher un menu de smiley 

https://www.tiny.cloud/docs/quick-start/  


## Initialiser des variables de session 

-> Controlleur userControlleur 
-> Ajouter la variable dans la fonction Twig Auth 