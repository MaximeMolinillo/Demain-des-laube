<?php
//Ne pas oublier de démarer le systéme de session sinon la fonction session_destroy() ne fonctionne pas
session_start();
require_once('../system/config.php');


// $email = $_SESSION["email"];
// $query = $db->prepare("DELETE  FROM user_login WHERE email_log = :email");
// $query->bindParam(":email", $email);
// $query->execute();
//Détruire les variables de session pour faire une deconnexion
session_destroy();

// Rediriger vers la page d'accueil
header("Location: ./index.php");
?>