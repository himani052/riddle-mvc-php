-- ---------------------------------------------------------------------------

-- DEVELOPPEMENT WEB - CRÉATION D'UN SITE DE PARCOURS & D'ENIGMES

-- CNAM 2eme annee Semestre 1
-- Auteurs : CHAMBET Anthony, IMANI Houssam, ESQUIEU Thomas

-- ---------------------------------------------------------------------------


-- ---------------------------------------------------------------------------
-- Changer le format de la table pour permettre la lecture des smileys
-- ---------------------------------------------------------------------------
/*
ALTER DATABASE
    `riddle-test`
    CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;

ALTER DATABASE `riddle-test` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `comment` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

set global character_set_client='utf8mb4'
set global character_set_connection='utf8mb4';
set global character_set_database='utf8mb4';
set global character_set_results='utf8mb4';
set global character_set_server='utf8mb4';

*/


-- ---------------------------------------------------------------------------
-- Supprimer les informations précedentes
-- ---------------------------------------------------------------------------


DROP TABLE IF EXISTS `SCORE_USER_COURSE`, `USER`,`COMMENT`, `CLUE`, `RIDDLE`,`LOCATION`,`DEPARTMENT`,`CITY`,`COURSE` ;

DROP VIEW IF EXISTS `COURSE_BY_CREATOR`;
DROP VIEW IF EXISTS `COURSES_DETAILS`;
DROP VIEW IF EXISTS `COURSE_PARTICIPANT`;

-- ---------------------------------------------------------------------------
-- Table DEPARTMENT
-- ---------------------------------------------------------------------------

CREATE TABLE `DEPARTMENT` (
                              codeDepartment INT NOT NULL,
                              titleDepartment TEXT NOT NULL,
                              PRIMARY KEY (codeDepartment)
);


-- ---------------------------------------------------------------------------
-- Table CITY
-- ---------------------------------------------------------------------------

CREATE TABLE `CITY` (
                        codeCity INT NOT NULL,
                        titleCity TEXT NOT NULL,
                        PRIMARY KEY (codeCity)
);


-- ---------------------------------------------------------------------------
-- Table LOCATION
-- ---------------------------------------------------------------------------

CREATE TABLE `LOCATION` (
                            idLocation INT NOT NULL AUTO_INCREMENT,
                            titleLocation VARCHAR(249) NOT NULL,
                            descriptionLocation TEXT NOT NULL,
                            imageLocation VARCHAR(249),
                            addressLocation TEXT NOT NULL,
                            department_codeDepartment INT NOT NULL,
                            city_codeCity INT NOT NULL,
                            course_idCourse INT NOT NULL,
                            PRIMARY KEY (idLocation)
);


-- ---------------------------------------------------------------------------
-- Table SCORE_USER_COURSE
-- ---------------------------------------------------------------------------


CREATE TABLE `SCORE_USER_COURSE` (
                                     scoreUser INT DEFAULT 0,
                                     user_emailUser VARCHAR(249) NOT NULL,
                                     course_idCourse INT NOT NULL,
                                     timeStartCourseUser TIME DEFAULT NULL ,
                                     timeEndCourseUser TIME DEFAULT NULL,
                                     PRIMARY KEY (user_emailUser,course_idCourse)
);

-- ---------------------------------------------------------------------------
-- Table USER
-- ---------------------------------------------------------------------------


CREATE TABLE `USER` (
                        emailUser VARCHAR(249) NOT NULL,
                        pseudoUser VARCHAR(249) NOT NULL,
                        passwordUser VARCHAR(249) NOT NULL,
                        birthdateUser DATE NOT NULL,
                        photoUser VARCHAR(249) DEFAULT '/public/assets/img/jpg/users/default.png',
                        registrationDateUser DATETIME DEFAULT CURRENT_TIMESTAMP,
                        levelUser INT DEFAULT 0,
                        totalScoreUser INT DEFAULT 0,
                        admin BOOLEAN,
                        PRIMARY KEY (emailUser)
);


-- ---------------------------------------------------------------------------
-- Table COURSE
-- ---------------------------------------------------------------------------


CREATE TABLE `COURSE` (
                          idCourse INT NOT NULL AUTO_INCREMENT,
                          titleCourse VARCHAR(255) NOT NULL,
                          descriptionCourse TEXT NOT NULL,
                          distanceCourse INT,
                          imageCourse VARCHAR(255) DEFAULT '/public/assets/img/jpg/courses/default.png',
                          creationDateCourse DATETIME DEFAULT CURRENT_TIMESTAMP,
                          creatorCourse VARCHAR(255) NOT NULL,
                          PRIMARY KEY (idCourse)
);






-- ---------------------------------------------------------------------------
-- Table RIDDLE
-- ---------------------------------------------------------------------------


CREATE TABLE `RIDDLE` (
                          idRiddle INT NOT NULL AUTO_INCREMENT,
                          titleRiddle VARCHAR(255),
                          descriptionRiddle TEXT NOT NULL,
                          imageRiddle VARCHAR(255),
                          solutionRiddle VARCHAR(255),
                          location_idLocation INT NOT NULL,
                          PRIMARY KEY (idRiddle)
);



-- ---------------------------------------------------------------------------
-- Table CLUE
-- ---------------------------------------------------------------------------


CREATE TABLE `CLUE` (
                        idClue INT NOT NULL AUTO_INCREMENT,
                        titleClue VARCHAR(255),
                        descriptionClue TEXT,
                        imageClue VARCHAR(255),
                        riddle_idRiddle INT NOT NULL ,
                        PRIMARY KEY (idClue)
);



-- ---------------------------------------------------------------------------
-- Table COMMENT
-- ---------------------------------------------------------------------------

CREATE TABLE `COMMENT` (
                           idComment INT NOT NULL AUTO_INCREMENT,
                           descriptionComment TEXT NOT NULL,
                           creationDateComment DATETIME DEFAULT CURRENT_TIMESTAMP,
                           pseudoUserNotRegistered VARCHAR (255),
                           user_emailUser VARCHAR(255),
                           course_idCourse INT NOT NULL,
                           PRIMARY KEY (idComment)
);




-- ---------------------------------------------------------------------------
-- Table TAG
-- ---------------------------------------------------------------------------

-- Créer une liste de tags pour la recherche





-- ---------------------------------------------------------------------------
-- Add Constraint
-- ---------------------------------------------------------------------------


-- FOREIGN KEYS

ALTER TABLE `COURSE` ADD CONSTRAINT fk_course_has_creator FOREIGN KEY(creatorCourse)  REFERENCES `USER`(emailUser) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `SCORE_USER_COURSE` ADD CONSTRAINT fk_user_has_courses_score FOREIGN KEY(user_emailUser)  REFERENCES `USER`(emailUser) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `SCORE_USER_COURSE` ADD CONSTRAINT fk_course_score_has_users FOREIGN KEY(course_idCourse)  REFERENCES `COURSE`(idCourse) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `COMMENT` ADD CONSTRAINT fk_user_has_courses_comments FOREIGN KEY(user_emailUser)  REFERENCES `USER`(emailUser) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `COMMENT` ADD CONSTRAINT fk_course_comment_has_users FOREIGN KEY(course_idCourse)  REFERENCES `COURSE`(idCourse) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `LOCATION` ADD CONSTRAINT fk_course FOREIGN KEY(course_idCourse)  REFERENCES `COURSE`(idCourse) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `LOCATION` ADD CONSTRAINT fk_department FOREIGN KEY(department_codeDepartment)  REFERENCES `DEPARTMENT`(codeDepartment) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `LOCATION` ADD CONSTRAINT fk_city FOREIGN KEY(city_codeCity)  REFERENCES `CITY`(codeCity) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `RIDDLE` ADD CONSTRAINT fk_location FOREIGN KEY(location_idLocation)  REFERENCES `LOCATION`(idLocation) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `CLUE` ADD CONSTRAINT fk_riddle FOREIGN KEY(riddle_idRiddle)  REFERENCES `RIDDLE`(idRiddle) ON DELETE CASCADE ON UPDATE CASCADE;




-- ---------------------------------------------------------------------------
-- Insertion des données de test
-- ---------------------------------------------------------------------------




-- Création des utilisateurs
INSERT INTO `USER` (emailUser, pseudoUser,passwordUser,photoUser, birthdateUser,`admin`)
VALUES ('houssam.imani@gmail.com', 'hortalia', SHA2('azertyui',512),'/public/assets/img/jpg/users/portrait-1.jpg','2000-03-17', 1),
       ('hissani.imani@gmail.com', 'mlsni', SHA2('azertyui',512),'/public/assets/img/jpg/users/portrait-2.jpg','1998-11-29', 0),
       ('tom.orhon@gmail.com', 'araschi', SHA2('azertyui',512),'/public/assets/img/jpg/users/portrait-3.jpg', '1998-07-25',0);


-- Création des departements
INSERT INTO `DEPARTMENT` (`codeDepartment`, `titleDepartment`)
VALUES ('04', 'Alpes de Haute Provence'),
       (05,'Hautes Alpes' ),
       (06, 'Alpes Maritimes'),
       (13, 'Bouches-du-Rhône'),
       (83, 'Var'),
       (84, 'Vaucluse');


-- Création des villes
INSERT INTO `CITY` (`codeCity`, `titleCity`) VALUES (13000, 'Marseille'),
                                                    (06000,'Nice'),
                                                    (83000, 'Toulon'),
                                                    (13090, 'Aix-en-provence'),
                                                    (84000, 'Avignon'),
                                                    (06600, 'Antibes'),
                                                    (06400, 'Cannes'),
                                                    (83500, 'La Seyne-sur-Mer'),
                                                    (83400, 'Hyère'),
                                                    (83600, 'Fréjus'),
                                                    (13200, 'Arles'),
                                                    (06130, 'Grasse'),
                                                    (13500, 'Martigues'),
                                                    (81130, 'Cagne-sur-Mer'),
                                                    (13400, 'Aubagne'),
                                                    (13300, 'Salon-de-Provence'),
                                                    (13800, 'Istres'),
                                                    (06110, 'Le Cannet'),
                                                    (05000, 'Gap'),
                                                    (83300, 'Draguignan'),
                                                    (13600, 'La Ciotat');




INSERT INTO `COURSE` (`idCourse`, `titleCourse`,`descriptionCourse`, `imageCourse`, `creatorCourse`) VALUES
(1, 'Le monument oublié', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-1.jpg','houssam.imani@gmail.com'),
(2, 'En route vers le lac salé','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-2.jpg','houssam.imani@gmail.com'),
(3, 'Fin des cours !', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-3.jpg','hissani.imani@gmail.com'),
(4, 'la forêt enchanté', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-4.jpg','hissani.imani@gmail.com'),
(5, 'Afterwork mouvementé', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas a laoreet dolor. Phasellus ullamcorper neque eget ante dapibus varius sed in lectus. Praesent et arcu et lorem convallis aliquam ac et dui. Vestibulum ullamcorper velit lectus,\r\n<br><br> et luctus massa vulputate sed. Quisque dignissim metus nisl, non finibus felis feugiat nec. In rhoncus ante ac urna venenatis sodales. Curabitur velit magna, facilisis sit amet mattis in, blandit non urna. Sed ac risus ac tortor semper malesuada non in augue. Fusce luctus lobortis ipsum ac blandit. Vivamus nunc ex, auctor vitae nunc ac, feugiat tincidunt arcu. Nullam iaculis tellus eget enim laoreet, sagittis aliquam risus blandit.<br><br>Aliquam elementum mauris vel lorem iaculis, quis ultricies augue facilisis. Integer egestas suscipit leo, molestie elementum nisl feugiat at. Proin sagittis varius massa ut malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n', '/public/assets/img/jpg/courses/image-5.jpg','tom.orhon@gmail.com'),
(6, 'La bibliothèque ensorcelée ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-6.jpg','tom.orhon@gmail.com');



INSERT INTO `LOCATION` (`idLocation`,`titleLocation`, `descriptionLocation`,imageLocation,addressLocation,department_codeDepartment,city_codeCity,course_idCourse)
VALUES (1, 'Batîment V1 - Université de Toulon', 'Derrière le bâtiment EVE', 'location-1-course-1.jpg','Av. de l Université',83, 83000, 1),
       (2, 'Bibliothèque de Toulon - Université de Toulon', 'Face à la fac de biologie','location-2-course-1.jpg','Av. de l Université',83, 83000,  1),
       (3, 'Fac de droit - Universitaire Aix-Marseille', 'Devant arrêt du car 72', 'location-1-course-3.jpg','Jardin du Pharo, 58 Boulevard Charles Livon', 13, 13400, 1),
       (4, 'Fac de biologie - Universitaire Aix-Marseille', 'Campus de Lumini', 'location-1-course-4.jpg','163 Av, de Luminy', 13, 13000,  1);


-- Ajouter la table RIDLE & Clue (finaliser un parcours)

INSERT INTO `RIDDLE` (idRiddle, titleRiddle, descriptionRiddle, imageRiddle, solutionRiddle, location_idLocation)
VALUES (1, 'bâtiment','Combien de batiments compte l université de Toulon ? ', NULL,'15', 1 ),
       (2, 'Object disparue','Retrouve dans la bibliothèques l objets manquants. Dès que tu aura retrouvé indique les 3 premières lettres dans le champ texte',NULL,'liv', 2 ),
       (3, 'Retrouve un livre','Retrouve le livre des mysérables de Victor Hugo et va à la page 100, ligne 6, caractère 10. Note la lettre',NULL,'a', 2 ),
       (4, 'Couleure','De quelle couleure est la bibliothèque d aix en provence',NULL,'blanc', 3),
       (5, 'Biologie','Quelle est la matiere principale enseigné en fac de biologie?',NULL,'biologie',4 );


INSERT INTO `CLUE` (idClue,titleClue,descriptionClue, imageClue, riddle_idRiddle)
VALUES (1, 'indice 1','Demandez aux étudiants si vous voulez en avoir le coeur net ;)', NULL,1),
       (2,'indice 2','Le chiffre est compris entre 5 et 25', NULL,1),
       (3,'indice 1','L object en question est assez evident', NULL,2),
       (4,'indice 1','Le livre se trouve dans l allé 4', NULL,3),
       (5,'indice 1','C est une couleure neutre !', NULL,4),
       (6,'indice 1','Ne réflechis pas trop c est tout simple la reponse est dans la question ;)', NULL,5);




-- Utilisateurs ayant joué aux parcours

INSERT INTO `SCORE_USER_COURSE` (user_emailUser, course_idCourse)
VALUES  ('houssam.imani@gmail.com', 1),
        ('houssam.imani@gmail.com', 2),
        ('hissani.imani@gmail.com', 3),
        ('tom.orhon@gmail.com', 4),
        ('tom.orhon@gmail.com', 5),
        ('tom.orhon@gmail.com', 6)
;




-- ---------------------------------------------------------------------------
-- Création de vues regroupant les données de parcours
-- ---------------------------------------------------------------------------


CREATE VIEW `COURSE_BY_CREATOR` AS
SELECT *
FROM  COURSE
          INNER JOIN `USER`
                     ON COURSE.creatorCourse = USER.emailUser
ORDER BY COURSE.idCourse ASC;



/* Pour afficher un parcours il faut :
   * Num parcours/ description/ images
   * Email/Peudo du créateur
   * Les commentaires associées au parcours et aux utilisateurs
   * Les lieux associés au parcours
   * La ville associé au parcours
   * Le départementassocié au parcours
   * Les enigmes associées aux lieux
   * Les indices associés aux enigmes
 */

CREATE VIEW `COURSES_DETAILS` AS
SELECT *
FROM  COURSE
          LEFT JOIN `USER`
                    ON COURSE.creatorCourse = USER.emailUser
          LEFT JOIN `LOCATION`
                    ON COURSE.idCourse = LOCATION.course_idCourse
          LEFT JOIN `DEPARTMENT`
                    ON LOCATION.department_codeDepartment = DEPARTMENT.codeDepartment
          LEFT JOIN `CITY`
                    ON LOCATION.city_codeCity = CITY.codeCity
          LEFT JOIN `RIDDLE`
                    ON LOCATION.idLocation = RIDDLE.location_idLocation
          LEFT JOIN `CLUE`
                    ON CLUE.riddle_idRiddle = RIDDLE.idRiddle
ORDER BY COURSE.idCourse ASC;



-- Pour afficher les participants aux courses

CREATE VIEW `COURSE_PARTICIPANT` AS
SELECT *
FROM `SCORE_USER_COURSE`
         INNER JOIN `USER`
                    ON USER.emailUser = SCORE_USER_COURSE.user_emailUser
         INNER JOIN `COURSE`
                    ON COURSE.idCourse = SCORE_USER_COURSE.course_idCourse
/*GROUP BY `user`.emailUser*/
ORDER BY COURSE.idCourse ASC;

