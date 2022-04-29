<?php

//Chargement dependances Composer
require("./svendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

//Création d'une constante pour générer le lien de reinitialisation du mot de passe
define("HOST", "http://localhost/demain-des-laube/");

if(isset($_POST["email"])) {
    $email =trim(strip_tags($_POST["email"]));

    $db =new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $result = $query->fetch();

    if ($result) {
          //la fonction random_bytes renvoie un binaire que nous transformons en une chaine hexédécimale avec la fonction bin2hex
        // si nous indiquons 50 en paramétre de la fonction random_bytes nous obtiendrons une chaine de 100 caractéres
        $token = bin2hex(random_bytes(50));

        $query = $db->prepare("INSERT INTO password_reset (email, token) VALUES (:email, :token)");
        $query->bindParam(":email", $email);
        $query->bindParam(":token", $token);

        if ($query->execute()) {
              // L'insertion en base c'est ok, on peut passer à l'envoi du mail
            // Appel au constructeur de la classe PHPMailer
            $phpmailer = new PHPMailer;

            $phpmailer->isSMTP();

            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '90fa78c7c15642';
            $phpmailer->Password = '52398468b08ac0';


            //Expéditeur
            $phpmailer->From = "caro@demaindeslaube.fr";
            //Nom a afficher à la place de l'adresse mail
            $phpmailer->FromName = "Demain dès l'Aube";
            $phpmailer->addAddress($email);
            //On indique que le contenu du mail sera du code html

            $phpmailer->isHTML();
            $phpmailer->Subject = "Réinitialisation du mot de passe";
            //Corps du mail
            $phpmailer->$Body = "<a href=\"" . HOST . "new_password.php?token={$token}\">Réinitialisation du mot de passe</a>";
            //Encodage utf-8
            $phpmailer->Charset = "UTF-8";
            //Envoie du mail
            $phpmailer->send();



            //Mail en ligne
            // $headers->From = "max_224@hotmail.fr";
            // $header->FromName ="Demain dès l'aube";
            // $header->$phpmailer->isHTML();
            // $header->$phpmailer->Subject = "Réinitialisation du mot de passe";
            // $header->$phpmailer->$Body = "<a href=\"".HOST."new_password.php?token={$token}\">Réinitialisation du mot de passe</a>";
            // $header->$phpmailer->Charset = "UTF-8";
            // $header->send();

            // mail('maxime.molinillo@outlook.fr', 'Demain dès lAube', 'Hello test mail', $headers);


            header("Location: new_password.php");
        }
    }
}

include("templates/header.php");
?>

<div class="resetPassword">
    <form action="" method="post">
        <h2>Mot de passe oublié</h2>
        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" id="inputEmail" name="email">
        </div>
        <input type="submit" class="submit" value="Envoyer">
    </form>
</div>


<?php
include("templates/footer.php");
?>