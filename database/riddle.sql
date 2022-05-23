-----------------------------------------------------------------------------

-- DEVELOPPEMENT WEB - CRÉATION D'UN SITE DE PARCOURS & D'ENIGMES

-- CNAM 2eme annee Semestre 1
-- Auteurs : CHAMBET Anthony, IMANI Houssam, ESQUIEU Thomas

-----------------------------------------------------------------------------


-- ---------------------------------------------------------------------------
-- Changer le format de la table pour permettre la lecture des smileys
-- ---------------------------------------------------------------------------

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




-- ---------------------------------------------------------------------------
-- Supprimer les informations précedentes
-- ---------------------------------------------------------------------------


DROP TABLE IF EXISTS `SCORE_USER_COURSE`, `USER`,`COMMENT`, `CLUE`, `RIDDLE`,`LOCATION`,`DEPARTMENT`,`CITY`,`COURSE` ;

DROP VIEW IF EXISTS `COURSE_INFORMATIONS`;

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
                            titleLocation VARCHAR(255) NOT NULL,
                            descriptionLocation TEXT NOT NULL,
                            imageLocation VARCHAR(255),
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
                                     user_emailUser VARCHAR(255) NOT NULL,
                                     course_idCourse INT NOT NULL,
                                     PRIMARY KEY (user_emailUser,course_idCourse)
);

-- ---------------------------------------------------------------------------
-- Table USER
-- ---------------------------------------------------------------------------


CREATE TABLE `USER` (
                        emailUser VARCHAR(255) NOT NULL,
                        pseudoUser VARCHAR(255) NOT NULL,
                        passwordUser VARCHAR(255) NOT NULL,
                        birthdateUser DATE NOT NULL,
                        photoUser VARCHAR(255) DEFAULT 'default.png',
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
                          imageCourse VARCHAR(255),
                          creationDateCourse DATETIME DEFAULT CURRENT_TIMESTAMP,
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
                          solution VARCHAR(255),
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
                          clue_idClue VARCHAR(255),
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
VALUES ('houssam.imani@gmail.com', 'hortalia', '1234','portrait-1.jpg','2000-03-17', 1),
       ('hissani.imani@gmail.com', 'mlsni', '1234','portrait-2.jpg','1998-11-29', 0),
       ('tom.orhon@gmail.com', 'araschi', '1234','portrait-3.jpg', '1998-07-25',0);


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




INSERT INTO `COURSE` (`idCourse`, `titleCourse`,`descriptionCourse`, `imageCourse`) VALUES
(1, 'Le monument oublié', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-1.jpg'),
(2, 'En route vers le lac salé','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-2.jpg'),
(3, 'Fin des cours !', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-3.jpg'),
(4, 'la forêt enchanté', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-4.jpg'),
(5, 'Afterwork mouvementé', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas a laoreet dolor. Phasellus ullamcorper neque eget ante dapibus varius sed in lectus. Praesent et arcu et lorem convallis aliquam ac et dui. Vestibulum ullamcorper velit lectus,\r\n<br><br> et luctus massa vulputate sed. Quisque dignissim metus nisl, non finibus felis feugiat nec. In rhoncus ante ac urna venenatis sodales. Curabitur velit magna, facilisis sit amet mattis in, blandit non urna. Sed ac risus ac tortor semper malesuada non in augue. Fusce luctus lobortis ipsum ac blandit. Vivamus nunc ex, auctor vitae nunc ac, feugiat tincidunt arcu. Nullam iaculis tellus eget enim laoreet, sagittis aliquam risus blandit.<br><br>Aliquam elementum mauris vel lorem iaculis, quis ultricies augue facilisis. Integer egestas suscipit leo, molestie elementum nisl feugiat at. Proin sagittis varius massa ut malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n', '/public/assets/img/jpg/courses/image-5.jpg'),
(6, 'La bibliothèque ensorcelée ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis tellus sed libero iaculis, a dignissim lacus blandit. Praesent lacinia ligula dui', '/public/assets/img/jpg/courses/image-6.jpg');



INSERT INTO `LOCATION` (`idLocation`,`titleLocation`, `descriptionLocation`,imageLocation,addressLocation,department_codeDepartment,city_codeCity,course_idCourse)
    VALUES (1, 'Batîment V1 - Université de Toulon', 'Derrière le bâtiment EVE', 'location-1-course-1.jpg','Av. de l Université',83, 83000, 1),
            (2, 'Bibliothèque de Toulon - Université de Toulon', 'Face à la fac de biologie','location-2-course-1.jpg','Av. de l Université',83, 83000,  1),
            (3, 'Fac de droit - Universitaire Aix-Marseille', 'Devant arrêt du car 72', 'location-1-course-3.jpg','Jardin du Pharo, 58 Boulevard Charles Livon', 13, 13400, 1),
            (4, 'Fac de biologie - Universitaire Aix-Marseille', 'Campus de Lumini', 'location-1-course-4.jpg','163 Av, de Luminy', 13, 13000,  1);



INSERT INTO `SCORE_USER_COURSE` (user_emailUser, course_idCourse)
VALUES  ('houssam.imani@gmail.com', 1),
        ('houssam.imani@gmail.com', 2),
        ('hissani.imani@gmail.com', 3),
        ('tom.orhon@gmail.com', 4),
        ('tom.orhon@gmail.com', 5),
        ('tom.orhon@gmail.com', 6)
;




-- ---------------------------------------------------------------------------
-- Création de vues regroupant les données
-- ---------------------------------------------------------------------------



CREATE VIEW `COURSE_INFORMATIONS` AS
SELECT *
FROM `SCORE_USER_COURSE`
         INNER JOIN `USER`
                    ON user.emailUser = SCORE_USER_COURSE.user_emailUser
         INNER JOIN `COURSE`
                    ON course.idCourse = SCORE_USER_COURSE.course_idCourse
/*GROUP BY `user`.emailUser*/
ORDER BY course.idCourse ASC


/*
CREATE VIEW locations AS
SELECT location.*, group_concat(facilities.FacilityName separator ',') AS facility_name
FROM location_facility
         INNER JOIN location
                    ON location.LocationID = location_facility.LocationID
         INNER JOIN facilities
                    ON facilities.FacilitiesID = location_facility.FacilitiesID
GROUP BY location.LocationName
ORDER BY location.LocationID ASC
*/

