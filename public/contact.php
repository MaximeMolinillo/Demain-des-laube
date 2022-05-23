<?php

//ouverture de session
session_start();
require_once('../system/config.php');
require("../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$page = "votre compte.";

if (!isset($_SESSION["user"])  || ($_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"])) {
    header("Location: ./login.php");
    session_destroy();
} else {
    $token = trim(strip_tags($_SESSION["token"]));
    $query = $db->prepare("SELECT email_log,token FROM user_login WHERE token = :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $resultToken = $query->fetch();


    if (($_SESSION["token"]) != ($resultToken["token"])) {
        session_destroy();
        header("Location: ./login.php");
    } else {

        if (!empty($_GET["id"])) {
            $id = trim(strip_tags($_GET["id"]));
            $query = $db->prepare("SELECT * FROM users WHERE id LIKE :id");
            $query->bindParam(":id", $id);
            $query->execute();
            $idContact = $query->fetch();
        }
        ////envoie de mail sur la boite de la patronne
        $errors = [];
        $messageErrors = "";
        if (isset($_POST["contactMail"])) {
            $nameC = trim(strip_tags($_POST["nameC"]));
            $firstnameC = trim(strip_tags($_POST["firstnameC"]));
            $emailC = trim(strip_tags($_POST["emailC"]));
            $telC = trim(strip_tags($_POST["telC"]));
            $objectC = trim(strip_tags($_POST["objectC"]));
            $messageC = trim(strip_tags($_POST["messageC"]));

            if (empty($emailC)) {
                array_push($errors, "Veuillez renseigner votre email, afin que nous puissions vous transmettre une réponse !");
            }
            if (empty($errors)) {
                $phpmailer = new PHPMailer();
                $phpmailer->isSMTP();
                $phpmailer->Host = 'smtp.mailtrap.io';
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = '4a87d0b4f0169e';
                $phpmailer->Password = '0163345150a19e';
                $phpmailer->From = $emailC;
                $phpmailer->FromName = $nameC . " " . $firstnameC;
                // Destinataire
                $phpmailer->addAddress("max_224@hotmail.fr");
                // Adresse de réponse
                $phpmailer->addReplyTo($emailC);
                //Send HTML or Plain Text email
                $phpmailer->isHTML();
                $phpmailer->CharSet = "UTF-8";
                $phpmailer->Subject = $objectC;
                //Corps du mail
                $phpmailer->Body = $messageC . " " . 'De la part de :' . " " . $firstnameC . " " . $nameC . ". " . 'Numéro de téléphone :' . " " . $telC;
                try {
                    //Envoie du mail
                    $phpmailer->send();

                    // On affiche un message de succès si la requéte s'est bien executée.
                    $messageErrors = "<div class=\"error\">Votre message a bien été envoyé.</div>";
                } catch (Exception $e) {
                    $messageErrors = "Un problème s'est produit ";
                }
            }
        }

        //Suppression de compte
        if (!empty($_POST["deleteAccountBtn"])) {
            $idUsers = $_SESSION["userId"];
            $query = $db->prepare("DELETE FROM users WHERE id LIKE :idUsers");
            $query->bindParam(":idUsers", $idUsers);
            if ($query->execute()) {
                session_destroy();
                header("location: ./index.php");
            }
        }
    }
}

include("../templates/header.php");
?>
<div class="flowerPicture"></div>

<div class="contactPage">


    <div class="welcome">
        <h2>Bienvenue sur votre compte, <?= $_SESSION["userName"] . " " . $_SESSION["user"] ?></h2>

    </div>
    <div class="panier">
        <p>Panier(0)</p>
        <img src="../assets/img/logo/sac-de-courses.png" alt="">
    </div>
    <?php
    if (isset($messageErrors)) {
    ?>
        <p class="error"><?= $messageErrors ?></p>
    <?php
    }
    ?>

    <form action="" method="post">
        <h1>Contactez-nous</h1>
        <hr>
        <div class="form-group">
            <label for="inputName">Nom :</label>
            <input type="text" name="nameC" id="inputName" value="<?= isset($_SESSION["userName"]) ? $_SESSION["userName"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="inputFirstname">Prénom :</label>
            <input type="text" name="firstnameC" id="inputFirstname" value="<?= isset($_SESSION["user"]) ? $_SESSION["user"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" name="emailC" id="inputEmail" value="<?= isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="inputTel">Télephone :</label>
            <input type="tel" name="telC" id="inputTel" placeholder="Votre Numéro de tél">
        </div>
        <div class="form-group">
            <label for="inputObject">Objet :</label>
            <input type="text" name="objectC" id="inputObject" placeholder="Objet de votre demande">
        </div>
        <div class="form-group">
            <label for="inputMessage">Message :</label>
            <textarea name="messageC" id="inputMessage" cols="30" rows="10" placeholder="Votre message"></textarea>
        </div>

        <input type="submit" class="submit" value="Envoyer" name="contactMail">
    </form>

    <div class="bottomLink">
        <a href="logout.php">Déconnexion</a>
    </div>

    <div class="deleteAccount">
        <h3>supprimer mon compte</h3>
        <form action="" method="post">
            <div class="form-group">
                <input type="submit" value="Supprimer mon compte" name="deleteAccountBtn">
            </div>
        </form>
    </div>

</div>

<?php
include("../templates/footer.php");
?>