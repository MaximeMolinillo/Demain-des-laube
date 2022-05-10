<?php
session_start();
require("./vendor/autoload.php");

$message = "";
$errors = [];
if (isset($_GET["token"])) {
    require_once './system/config.php';
    $token = trim(strip_tags($_GET["token"]));
    // $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("SELECT email, validity FROM password_reset WHERE token = :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $result = $query->fetch();
    //  validité
    if (!$result || $result["validity"] < time()) {
        $message = "Votre lien de récupération du mot de passe est invalide ou expiré";
    } else {
        $_SESSION["token"] = $token;
    }
    // var_dump($result);
    if (empty($result)) {
        //token pas trouvé redirection
        header("Location: index.php");
    }

    if (isset($_POST["newPassword"])) {
        //  $token = $_SESSION["token"];
        $passwordReset = trim(strip_tags($_POST["passwordReset"]));
        $retypePasswordReset = trim(strip_tags($_POST["retypePasswordReset"]));
        $req = $db->prepare("SELECT email, validity FROM password_reset WHERE token=:token");
        $req->bindParam(":token", $token);
        $req->execute();
        $res = $req->fetch();
        // var_dump($res["email"]);
        $emailReset = $res["email"];
        //Validation password
        if ($passwordReset !== $retypePasswordReset) {
            $errors["retypePassword"] = "Les mots de passe ne correspondent pas!";
        }
        if ($emailReset && $res["validity"] > time()) {
            $uppercase = preg_match("/[A-Z]/", $passwordReset);
            $lowercase = preg_match("/[a-z]/", $passwordReset);
            $number = preg_match("/[0-9]/", $passwordReset);
            $haveSpace = preg_match("/ /", $passwordReset);
            $specialChar = preg_match("/[^a-zA-Z0-9]/", $passwordReset);

            if (strlen($passwordReset) < 6 || !$uppercase || !$lowercase || $haveSpace || !$specialChar) {
                $errors["password"] = "Le mot de passe doit contenir 6 caractères minimum, une majuscule, une minuscule, un chiffre et un caractère spécial";
            }

            //var_dump($result);
            //Le formulaire est envoyé et un mot de passe est disponible
            //N'oubliez pas de valider la consistance du mot de passe comme dans create_account.php

            if (empty($message)) {
                $passwordReset = password_hash($passwordReset, PASSWORD_DEFAULT);
                //Requete SQL de mise a jour du mot de passe
                $query = $db->prepare("UPDATE users SET password = :passwordReset WHERE email = :email");
                $query->bindParam(":passwordReset", $passwordReset);
                $query->bindParam(":email", $emailReset);
                if ($query->execute()) {
                    //Possibilité de compléter avec une réquéte DELETE sur la table password_reset pour purger la ligne en question
                    // var_dump($emailReset);
                    $req = $db->prepare("DELETE  FROM password_reset WHERE email = :email");
                    $req->bindParam(":email", $emailReset);
                    $req->execute();
                }

                if (!empty($errors)) {
                    $errors;
                } else {
                    header("Location: login.php");
                }
            } else {
                $errors = "Erreur de base de donnée";
            }
        }
    }
} else {
    //Pas de token dans l'url c'est louche !
    header("Location: index.php");
}

include("templates/header.php");
?>

<div class="newPassword">
    <form action="" method="post">
        <div class="error"> <?= $message ?></div>
        <div class="form-group">
            <label for="inputPassword">Nouveau mot de passe :</label>
            <input type="password" name="passwordReset" id="inputPassword">
        </div>
        <?php
        if (isset($errors["password"])) {
        ?>
            <p class="error"><?= $errors["password"] ?></p>
        <?php
        }
        ?>

        <div class="form-group">
            <label for="retypeInputPassword">Retapez votre mot de passe :</label>
            <input type="password" name="retypePasswordReset" id="retypeInputPassword" required>
        </div>
        <?php
        if (isset($errors["retypePasword"])) {
        ?>
            <p class="error"><?= $errors["retypePassword"] ?></p>
        <?php
        }
        ?>

        <input type="submit" value="Envoyer" class="submit" name="newPassword">
    </form>
</div>

<?php
include("templates/footer.php");
?>