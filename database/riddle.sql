-- ---------------------------------------------------------------------------
-- Supprimer les informations précedentes
-- ---------------------------------------------------------------------------
DROP TABLE IF EXISTS comment;



-- ---------------------------------------------------------------------------
-- Création des tables
-- ---------------------------------------------------------------------------

CREATE TABLE comment (
                         id INT NOT NULL AUTO_INCREMENT,
                         description TEXT NOT NULL,
                         creationDate DATETIME DEFAULT CURRENT_TIMESTAMP,
                         user_emailUser VARCHAR(255) NOT NULL,
                         parcours_id INT NOT NULL,
                         PRIMARY KEY (id)
);


-- ---------------------------------------------------------------------------
-- Add Constraint
-- ---------------------------------------------------------------------------


ALTER TABLE comment ADD CONSTRAINT fk_user FOREIGN KEY(user_emailUser)  REFERENCES user(emailUser);
ALTER TABLE comment ADD CONSTRAINT fk_parcours FOREIGN KEY(parcours_id)  REFERENCES parcours(id);

