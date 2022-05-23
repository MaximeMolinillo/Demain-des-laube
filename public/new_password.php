<?php
session_start();
require("../vendor/autoload.php");
$page = "nouveau mot de passe.";

$message = "";
$errors = [];
if (isset($_GET["token"])) {
    require_once('../system/config.php');
    $token = trim(strip_tags($_GET["token"]));
    // $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("SELECT email, validity FROM password_reset WHERE token = :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $result = $query->fetch();
    //  ---------validité
    if (!$result || $result["validity"] < time()) {
        $message = "Votre lien de récupération du mot de passe est invalide ou expiré";
    } else {
        $_SESSION["token"] = $token;
    }

    if (empty($result)) {
        //-------token pas trouvé redirection
        header("Location: ./index.php");
    }

    if (isset($_POST["newPassword"])) {
        //  ------$token = $_SESSION["token"];
        $passwordReset = trim(strip_tags($_POST["passwordReset"]));
        $retypePasswordReset = trim(strip_tags($_POST["retypePasswordReset"]));
        $req = $db->prepare("SELECT email, validity FROM password_reset WHERE token=:token");
        $req->bindParam(":token", $token);
        $req->execute();
        $res = $req->fetch();
        // ---------var_dump($res["email"]);
        $emailReset = $res["email"];
        //-----------Validation password
        if ($passwordReset !== $retypePasswordReset) {
            $errors["retypePassword"] = "Les mots de passe ne correspondent pas!";
        }
        if ($emailReset && $res["validity"] > time()) {
            $uppercase = preg_match("/[A-Z]/", $passwordReset);
            $lowercase = preg_match("/[a-z]/", $passwordReset);
            $number = preg_match("/[0-9]/", $passwordReset);
            $haveSpace = preg_match("/ /", $passwordReset);
            $specialChar = preg_match("/[^a-zA-Z0-9]/", $passwordReset);

            if (strlen($passwordReset) < 12 || !$uppercase || !$lowercase || $haveSpace || !$specialChar) {
                $errors["password"] = "Le mot de passe doit contenir 12 caractères minimum, une majuscule, une minuscule, un chiffre et un caractère spécial";
            }

            if (empty($message)) {
                $passwordReset = password_hash($passwordReset, PASSWORD_DEFAULT);
                //-------Requête SQL de mise a jour du mot de passe
                $query = $db->prepare("UPDATE users SET password = :passwordReset WHERE email = :email");
                $query->bindParam(":passwordReset", $passwordReset);
                $query->bindParam(":email", $emailReset);
                if ($query->execute()) {
                    $req = $db->prepare("DELETE  FROM password_reset WHERE email = :email");
                    $req->bindParam(":email", $emailReset);
                    $req->execute();
                }

                if (!empty($errors)) {
                    $errors;
                } else {
                    header("Location: ../public/login.php");
                }
            } else {
                $errors = "Erreur de base de donnée";
            }
        }
    }
} else {
    header("Location: ../index.php");
}

include("../templates/header.php");
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
include("../templates/footer.php");
?>