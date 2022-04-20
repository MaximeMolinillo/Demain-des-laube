CREATE DATABASE demainDeslAube;

USE demainDeslAube;

CREATE TABLE photos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100),
    description TEXT,
    picture VARCHAR(256) NOT NULL
);




INSERT INTO photos
(title, description, picture)
VALUES
("Composition avec oeuf","","https://scontent-cdg2-1.xx.fbcdn.net/v/t39.30808-6/278509307_952601088882989_4178214904760693974_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=-iWWpA_PgxwAX8DO_FF&_nc_ht=scontent-cdg2-1.xx&oh=00_AT-Qne0LoduEhapxulnhGdqPMktj7fqF9RGN4lkEXUvI9A&oe=6261D794"),
("Bouquet fleuri","","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/275179569_4605927542848995_2220870137660994051_n.jpg?_nc_cat=103&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=QJ58gvjPkJUAX_pT9qO&_nc_ht=scontent-cdt1-1.xx&oh=00_AT8f-Gw7TRPjs_AC5pvPR6Bk25AAdG5kfJCgqVJLahH2bA&oe=62606EAE"),
("Bouquet fleuri","","https://scontent-cdg2-1.xx.fbcdn.net/v/t39.30808-6/275061299_4605927116182371_4749887545273850901_n.jpg?_nc_cat=104&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=pyuu4jA5pRkAX-exyPV&_nc_ht=scontent-cdg2-1.xx&oh=00_AT8whk3dbqHz81npmU8cSwpjTKiqjG3BHE_3cECNbP5MXA&oe=6261F14E"),
("Bouquet apéritif","Bouquet fleuri avec brochette de fromage","https://scontent-cdg2-1.xx.fbcdn.net/v/t39.30808-6/262990835_4292847680823651_3784805399270759790_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=E84RwOVX79wAX8OvMYd&_nc_ht=scontent-cdg2-1.xx&oh=00_AT-q4ypXMXfc2sUY0buz00eoRnxpqUd5VoQDez0freze0w&oe=62613234"),
("Orchidée","Orchidé rose","https://scontent-cdg2-1.xx.fbcdn.net/v/t39.30808-6/273644292_4549544218487328_5069537354875380459_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=M8nDEBCM1l4AX9kMjpf&_nc_ht=scontent-cdg2-1.xx&oh=00_AT8_6ITIKgqUnV_sFqDkZ2LhYAH8mzrtp4Ja-Kx2DFuRfw&oe=6261ACD5"),
("Succulente","","https://scontent-cdg2-1.xx.fbcdn.net/v/t39.30808-6/237103904_3956228247818931_5934380049445346625_n.jpg?_nc_cat=108&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=LHTv_-coIGwAX8AGaJj&_nc_ht=scontent-cdg2-1.xx&oh=00_AT8-kv3fhPpAmkFFEqDZ8VOixp6UnxOGk0CewWs1e1koIQ&oe=62629D2B"),
("Cercle en bois","","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/277302908_4662094203898995_6955037540774220972_n.jpg?_nc_cat=105&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=9sP1vc_YUHgAX85A2GO&tn=F0h-jkE9ptwrZwjM&_nc_ht=scontent-cdt1-1.xx&oh=00_AT-L5XBElz1mMRagfvUgn8rcMRsmFOw0ZzynbzQpPFDgiQ&oe=62617F2D"),
("Suspension","Suspension rose","https://scontent-cdg2-1.xx.fbcdn.net/v/t39.30808-6/275120187_4602183703223379_9046657949077330394_n.jpg?_nc_cat=100&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=M0Dz8aGecdEAX_pZxQ-&_nc_ht=scontent-cdg2-1.xx&oh=00_AT_DSscBJuEtf663YO-YhlghgwLjE21gkZzX-nvyorx4mA&oe=626120EF"),
("Suspension","Suspension verte","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/274989491_4602184009890015_2036231033512421712_n.jpg?_nc_cat=110&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=Ne-E2zgEmmoAX80DkUm&tn=F0h-jkE9ptwrZwjM&_nc_ht=scontent-cdt1-1.xx&oh=00_AT9hPlcMibtqWXnGLYCrfpMydqjx56HzkGK8gNRL7wH-Zg&oe=626066CB"),
("Suspension","Suspension violette","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/275068043_4602184333223316_8987186341537350839_n.jpg?_nc_cat=106&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=r9VqPfhp8PMAX_t6n_B&_nc_ht=scontent-cdt1-1.xx&oh=00_AT9JdngMHOgNkXNthh_mzHXyhqUYXEwAM_wJJCsJOoIFrA&oe=62603F73"),
("Décoration roue de vélo","","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/242727926_4066958206745934_562463370581583158_n.jpg?_nc_cat=109&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=J-6XA9Isn0kAX8Q_HCB&_nc_ht=scontent-cdt1-1.xx&oh=00_AT9umEmX4nUjgTkKxtuhOPZ4WITfnfEMLN82mlZKEejgHQ&oe=6260A7EE"),
("Couronne florale","","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/226584935_3904093436365746_3458218889545929758_n.jpg?_nc_cat=101&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=yoUZ0lWw980AX_CCaAI&tn=F0h-jkE9ptwrZwjM&_nc_ht=scontent-cdt1-1.xx&oh=00_AT_ENcSD2UnSz-e0x2ELfhDrh_whhdyByCIv29bMIe4WGA&oe=62633E87"),
("Arbuste","Sans arrosage","https://scontent-cdt1-1.xx.fbcdn.net/v/t1.6435-9/201464819_3785720771536347_4190509076980695315_n.jpg?_nc_cat=101&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=EJScKUt3U7sAX_TDc4v&_nc_ht=scontent-cdt1-1.xx&oh=00_AT-FePT3e2bYGVVJOXrazxBd6NZeRmICR4ElFbDn_MHPyA&oe=628271AE"),
("Fleurs","Centre de table","https://scontent-cdt1-1.xx.fbcdn.net/v/t1.6435-9/120227495_3071795132928918_6579445003521216087_n.jpg?_nc_cat=109&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=02T793mSIT0AX_zNiJa&_nc_ht=scontent-cdt1-1.xx&oh=00_AT_LGlgAgzlOhGpk7JVRve7bvnubEVtF9KpOaHIjllwyBA&oe=628353D0"),
("Boucle d'oreilles","","https://scontent-cdg2-1.xx.fbcdn.net/v/t1.6435-9/66936617_2128926323882475_1453831453145038848_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=WS5EzIyeve8AX_k6ykH&_nc_ht=scontent-cdg2-1.xx&oh=00_AT89QHp2_vWa33uiUQ8EgsEQHxaPcSd1eBl_29ONtVgvdw&oe=62825DC1"),
("Création diverses","","https://scontent-cdg2-1.xx.fbcdn.net/v/t1.6435-9/67245170_2128926237215817_421484554008657920_n.jpg?_nc_cat=102&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=HhN_zgbYDlgAX8r5rx3&_nc_ht=scontent-cdg2-1.xx&oh=00_AT8-aUeYUGR0V0M3_cw887r5be3ocaiAhqxgyJr7HkcX2A&oe=62803D52"),
("Collection fait maison","","https://scontent-cdt1-1.xx.fbcdn.net/v/t1.6435-9/67532146_2128926170549157_5774948356879024128_n.jpg?_nc_cat=105&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=oSz_4u1NRuoAX_czLpg&_nc_ht=scontent-cdt1-1.xx&oh=00_AT_zfP9cqd6XNElwym02NTiR0Q1ts20JZBYxGZWusUCjTg&oe=62828174"),
("Composition florale","","https://scontent-cdt1-1.xx.fbcdn.net/v/t39.30808-6/278384391_952601252216306_5710686029689219948_n.jpg?_nc_cat=105&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=PdJkjawwmJ8AX9r_Tod&_nc_ht=scontent-cdt1-1.xx&oh=00_AT8SAUoSdCOBhWzr5xq6nb2PlfF1dkeVKYM2diY86SVjCg&oe=6263C318")







/*pas encore inséré en bdd*/
CREATE TABLE type(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL
);