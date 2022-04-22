<?php
//ouverture de session
session_start();

//test que l'utilisateur est bien connecté
if (!isset($_SESSION["user"])  || ($_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"])) {
    header("Location: login.php");
}

include("templates/header.php");
?>

<div class="myAccount">
    <h1>Bienvenue sur votre compte, <?= $_SESSION["user"] ?></h1>
    <a href="logout.php">Déconnexion</a>
</div>




<?php
include("templates/footer.php");
?>