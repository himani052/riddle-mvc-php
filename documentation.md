# Création du site Riddle : Jeux et création d'énigmes   
  
**Sommaire :**   

 - Création d'un "Framework" PHP MVC
	 - Création du routeur
	 - Interaction avec la base de donnée
		 - Classe de connexion à la BDD
		 - Les modèles   
	 - Implémentation du moteur de templating 'Twig' pour l'affichage de nos vues
	 - Création d'un CRUD via les Contrôleurs 
- Implémentation de la base de donnée (schéma)
- Créer les fonctionnalités du site


## 1. Création d'un "Framework" PHP MVC

### 1.1. Création du routeur

### 1.2. Interaction avec la base de donnée (modèles)

### 1.3. Implémentation du moteur de templating 'Twig' pour l'affichage de nos vues

### 1.4. Création d'un CRUD via les Contrôleurs 



## 2. Implémentation de la base de donnée 

### 2.1. MEA

### 2.2. MCD


## 3. Créer les fonctionnalités du site



Le site internet dispose de deux rôles : 

- Le rôle "user" est donné à la première connexion sur le site. Ce rôle permet de participer à des parcours où l'utilisateur peut suivre sa progression de score et de niveau, de laisser des commentaires sur des parcours, mais également de créer ses propres parcours. Un utilisateur peut très bien choisir de ne pas exploiter la fonctionnalité "création de parcours" du site. S'il décide de se lancer dans la création de parcours, il aura accès à tous les parcours qu'il a créé sur son compte et pourra ainsi suivre le nombre utilisateurs qui ont participé à son parcours et leur retour par commentaire. Il aura de même la possibilé de supprimer ces commentaires. 
 
- Le rôle "admin" est donné nativement uniquement à l'administrateur du site. Cet administrateur pourra par la suite modifier le rôle de certains utilisateurs pour leur attribuer le rôle admin. Le rôle de l'administrateur est d'une part de gérer les rôles des utilisateurs, mais également de supprimer l'ensemble des commentaires ou des parcours du site. C'est le modérateur. Cette fonction est primordiale pour garantir un espace web propre. L'administrateur a également nativement le rôle "user", il peut donc effectuer les mêmes actions (participation à des parcours, ajouter des commentaires, etc...).      


###  3.1. Espace de connexion

#### 3.1.1. Gérer les sessions (variables de sessions)
#### 3.1.2. Inscription
#### 3.1.3. Encrypter les mots de passe 
		   
		   
### 3.2. CRUD sur les parcours

#### 3.2.1. Création d'un parcours
#### 3.2.2. Modification d'un parcours (s'il a été créé par lui)
#### 3.2.3. Suppression d'un parcours (s'il a été créé par lui)

### 3.3. CRD sur les commentaires 
(géré par l'utilisateur qui a posté le parcours ainsi que par l'administrateur)

#### 3.3.1. Création de commentaires 

#### 3.3.2. Suppression de commentaires 
	 

### 3.4. CRUD sur les utilisateurs (admin)

#### 3.4.1. Création de nouvel utilisateurs
#### 3.4.2. Modification des rôles des utilisateurs 
#### 3.4.3. Modification de tous les parcours
#### 3.4.4. Possibilité de supprimer tous les commentaires  

### 3.5. Participer à un parcours 

#### 3.5.1. Entrer dans un parcours (enregistrement des données de session)
#### 3.5.2. Gestion du temps 
#### 3.5.4. Affichage des lieux l'un après l'autre 
#### 3.5.3. Gestion des réponses et affichage des indices
#### 3.5.3. Gestion des scores des utilisateurs / et modification de niveau en fonction
#### 3.5.4. Gérer la localisation des utilisateurs (API ?) 