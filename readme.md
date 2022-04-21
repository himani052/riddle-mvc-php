#PHP MVC Framework 


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