<?php

//--------------CONNEXION---------------//
require_once('../system/config.php');
$error = "";
if (!empty($_POST)) {

    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));

    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindparam(":email", $email);
    $query->execute();
    //PDO::FETCH_ASSOC pr eviter les doublons
    $result = $query->fetch(PDO::FETCH_ASSOC);

    //password_verify va nous permettre de vérifier la correspondance entre le mot de passe saisi et le hash stocké en BDD
    if (!empty($result) && password_verify($password, $result["password"])) {
        //Démarage du systéme de session 
        session_start();
        // On stocke le prénom dans une variable de session
        $_SESSION["user"] = $result["firstname"];
        $_SESSION["userName"] = $result["name"];
        $_SESSION["userId"] = $result["id"];
        $_SESSION["userRole"] = $result["role"];
        $_SESSION["email"] = $result["email"];
        //On stocke l'adresse ip de l'utilisateur pour palier à une possible attaque "session hijacking"
        $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];

        $token = bin2hex(random_bytes(50));

        $query = $db->prepare("INSERT INTO user_login (email_log, token) VALUES (:email, :token)");
        $query->bindParam(":email", $email);
        $query->bindParam(":token", $token);

        if ($query->execute()) {
            $_SESSION["token"] = $token;
        }

        if ($result["role"] !== "admin") {
            header("Location: ./contact.php");
        } else {
            header("Location: ./my_account.php");
        }
    } else {
        $error = "Impossible de se connecter avec les informations saisies";
    }
}
include("../templates/header.php");
?>

<main class="login">
    <div class="flowerPicture"></div>

    <form action="" method="post">
        <h2>Connexion à votre espace utilisateur</h2>

        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" name="email" id="inputEmail" required>
        </div>

        <div class="form-group">
            <label for="inputPassword">Mot de passe :</label>
            <input type="password" name="password" id="inputPassword" required>
        </div>

        <div class="error"><?= $error ?></div>
        <input type="submit" value="Se connecter" class="submit">
    </form>

    <div class="bottomLink">
        <a href="reset_password.php">J'ai oublié mon mot de passe</a>
    </div>

</main>

<?php
include("../templates/footer.php");
?>