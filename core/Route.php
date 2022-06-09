<?php

class Route
{


    /**
     * @var
     * Stocke les routes post "POST" "GET"
     */
    private static $request;


    /**
     * @param $path
     * @param $action
     * @return Request
     * Gère le traitement des routes avec la méthode "GET" {Affichages}
     * Stockage des routes de GET - chaînage
     */
    public static function get($path, $action)
    {
        $routes = new Request($path, $action);
        self::$request['GET'][] = $routes;
        return $routes;
    }

    /**
     * @param $path
     * @param $action
     * @return Request
     * Gère le traitement des routes avec la méthode "POST" {formulaires, actions}
     * Stockage des routes de GET - chaînage
     */
    public static function post($path, $action)
    {

        $routes = new Request($path, $action);
        self::$request['POST'][] = $routes;
        return $routes;
    }


    /**
     * Méthode d'exécution des routes
     * 1. Parcourir les routes stockées dans la variable request avec le 'foreach'
     * 2. Compare l'URL saisi par l'utilisateur avec les URL prédéfinis dans le fichier Route/routes.php avec la méthode 'match'
     *      => La variable url de '$_GET['url']' provient du fichier htaccees
     *      => la méthode trim permet ici de retirer les '/' de l'url
     * 3. '$route->execute()' est une méthode d'exécution afin d'obtenir le résultat (renvoie vers le bon controlleur)
     * 4. Si la route saisi par l'utilisateur est trouvé arrêter le processus => die();
     * 5. Si la route saisi par l'utilisateur n'est pas trouvé => afficher une page d'erreur
     */
    public static function run()
    {
        foreach (self::$request[$_SERVER['REQUEST_METHOD']] as $route) {

            if ($route->match(trim($_GET['url']), '/')) {

                $route->execute();
                die();
            }
        }
        header('HTTP/1.0 404 Not found');
    }


    /**
     * @param $name
     * @param array $parameters
     * @return string
     * fonction qui va traiter la fonction name dans la classe Request
     */
    public static function url($name, $parameters = [])
    {

        //parcourir toutes les routes (post ou get)
        foreach (self::$request as $key => $value) {
            foreach (self::$request[$key] as $routes) {
                //si la cle existe (ex: home.show existe ?)
                if (array_key_exists($name, $routes->name())) {

                    //récupération de la route
                    $route = $routes->name();

                    //transformer la valeur du tableau en chaine de charactères
                    $path = implode($route[$name]);

                    //tester si le paramètre est vide
                    if (!empty($parameters)) {

                        //parcourir tableau
                        foreach ($parameters as $key => $value) {
                            //je remplace le parametre id par la valeur dans le 'path' (chemin)
                            $path = str_replace("{{$key}}", $value, $path);

                        }
                        return '/' . $path;
                    } else {
                        //si le paramètre est vide retourner un slash
                        return "/" . $path;
                    }
                }
            }
        }
    }


}
