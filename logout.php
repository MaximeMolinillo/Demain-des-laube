<?php
    //Ne pas oublier de démarer le systéme de session sinon la fonction session_destroy() ne fonctionne pas
    session_start();

    //Détruire les variables de session pour faire une deconnexion
    session_destroy();

//Rediriger vers la page d'accueil
header("Location: ./");



?>