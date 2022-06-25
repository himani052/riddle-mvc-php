# RIDDLE - Jeux de piste et résolution d’énigme 
### Projet Web réalisé dans le cadre de la 2ème année au Conservatoire National des Arts et Métiers pour le cours de Développement Web



### Prérequis pour l'installation du projet

- MySQL pour la gestion de la base de donnée
- Serveur web en local pour héberger le site
- PHP (version supérieure à 7)
- Les plus (non obligatoire mais utiles): 
    - Composer
    - PhpMyAdmin


### Installation 

1. Télécharger le projet via le répertoire git :
https://github.com/himani052/riddle-mvc-php.git

2. Lancer le serveur web (ou WAMP, LAMP, ect...)

3. Création de la base de donnée & connection
   - Créer une nouvelle base de donnée MySQL respectant le format "UTF8mb4" (pour l'affichage des smileys) 
   - Récupérer le ficher `riddle.sql` depuis `database/riddle.sql` et le charger 
dans une base de donnée MySQL
    - Modifier le fichier `core/Request.php` pour y modifier les informations de connection à la base de donnée. L'étape 
    sera à faire deux fois (pour les requêtes 'GET' et les requêtes 'POST')
   
4. Se connecter sur le bonne adresse du serveur et démarrer l'expérience ;) 


Note : Si vous souhaitez réinstaller les librairies du projet :
- Installer composer 
- Lancer la commande "composer install" ou "composer update"



### Hébergement en ligne du projet

http://riddle.alwaysdata.net/



### Connection au site

Compte Administrateur (avec parcours)
- Mail : super.admin@gmail.com
- Mot de passe : superadmin


1er Compte Utilisateur (avec parcours)
- mail : user.one@gmail.com
- mot de passe : superuser

2nd Compte Utilisateur (avec parcours)
- mail : user.two@gmail.com
- mot de passe : superuser