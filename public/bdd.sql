CREATE DATABASE demainDeslAube;

USE demainDeslAube;

CREATE TABLE photos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100),
    description TEXT,
    picture VARCHAR(256) NOT NULL,
    category VARCHAR(60)
 
);

CREATE TABLE category(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100)
);


INSERT INTO photos
(title, description, picture, category)
VALUES
("HELLO", "123", "IMG-20220422-WA0024", "Fleurs"),




ALTER TABLE users ADD role VARCHAR(50) DEFAULT "utilisateur";

UPDATE users SET role ="admin" WHERE id=1 ;

ALTER TABLE type ADD sub_category VARCHAR(70);

INSERT INTO type
(category)
VALUES
("Fleurs"),
("Décorations"),
("Bijoux"),
("Mariage"),
("Deuil"),
("Autres")


INSERT INTO photos_category
(id_photos, id_genre)
VALUES
(1,4)


-- SELECT photos.title, type.category AS "type"
-- FROM photos
-- INNER JOIN photos_category
-- ON photos.id = photos_category.id_photos
-- INNER JOIN type
-- ON photos_category.id_genre = type.id
-- GROUP BY photos.title;

--Ajout nouvelle colonne a passwordreset pr donner une validité au lien
ALTER TABLE password_reset
ADD validity  int(11);

INSERT INTO category
(name)
VALUES
("Fleurs"),
("Plantes Vertes"),
("Décoration"),
("Bijoux"),
("Mariage"),
("Deuil"),
("Autres")

ALTER TABLE photos
DELETE category

ALTER TABLE photos
ADD id_category INT


SELECT category.name AS 'type',GROUP_CONCAT(photos.title ORDER BY photos.id separator ' </br> ') AS 'photo' FROM category 
INNER JOIN photos ON category.id = photos.id_category