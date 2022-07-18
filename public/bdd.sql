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


CREATE TABLE password_reset(
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(320),
    token VARCHAR(100),
    validity INT(11)
);

CREATE TABLE user_login(
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(320),
    token VARCHAR(100)
);

INSERT INTO photos
(title, description, picture, category)
VALUES
("HELLO", "123", "IMG-20220422-WA0024", "Fleurs"),

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    firstname VARCHAR(100),
    email VARCHAR(320),
    password VARCHAR(255)
   
);


ALTER TABLE users ADD role VARCHAR(50) DEFAULT "utilisateur";

-- UPDATE users SET role ="admin" WHERE id=1 ;

-- ALTER TABLE type ADD sub_category VARCHAR(70);

-- INSERT INTO category
-- (name)
-- VALUES
-- ("Fleurs"),
-- ("Plantes Vertes"),
-- ("Décorations"),
-- ("Bijoux"),
-- ("Mariage"),
-- ("Deuil"),
-- ("Autres")


INSERT INTO photos_category
(id_photos, id_genre)
VALUES
(1,4)




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

-- ALTER TABLE photos 