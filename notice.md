# Création site MVC

## Initialisation du projet composer

````
composer init 
````

Pour charger automatiquement certains fichiers on fait appel à l'autolaod

`````json
{
    "autoload": {
        "psr-4":{
            "App\\":"app/",
            "":"core/",
            "Database\\": "database/"
        }
    }
}