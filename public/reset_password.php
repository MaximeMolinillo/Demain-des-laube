<?php
//Chargement dependances Composer
// require("../vendor/autoload.php");
require_once('../system/config.php');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
//Création d'une constante pour générer le lien de reinitialisation du mot de passe

$page = "mot de passe oublié.";
$errors = [];
$message = "";

if (isset($_POST["email"])) {
    require_once('../system/config.php');
    $email = trim(strip_tags($_POST["email"]));
    //  $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("SELECT email FROM users WHERE email = :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $result = $query->fetch();


    if (empty($email)) {
        array_push($errors, "Votre email est obligatoire");
    } else if (!$result) {
        array_push($errors, "Désolé, aucun utilisateur ne correspond à cette adresse mail");
    }

    //Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }
    if (empty($errors)) {
        //la fonction random_bytes renvoie un binaire que nous transformons en une chaine hexédécimale avec la fonction bin2hex
        // Génération d'un token de 100 caractères
        $token = bin2hex(random_bytes(50));
        $validity = time() + 86400;
        $query = $db->prepare("INSERT INTO password_reset (email, token, validity) VALUES (:email, :token, :validity)");
        $query->bindParam(":email", $email);
        $query->bindParam(":token", $token);
        //Paramétre entier&
        $query->bindParam(":validity", $validity, PDO::PARAM_INT);
        if ($query->execute()) {
            // Appel au constructeur de la classe PHPMailer
            // $phpmailer = new PHPMailer();
            // $phpmailer->isSMTP();
            // $phpmailer->Host = 'smtp.mailtrap.io';
            // $phpmailer->SMTPAuth = true;
            // $phpmailer->Port = 2525;
            // $phpmailer->Username = '4a87d0b4f0169e';
            // $phpmailer->Password = '0163345150a19e';
            // $phpmailer->SMTPSecure = 'tls';
            // //Expéditeur
            // $phpmailer->From = "caro@demaindeslaube.fr";
            // //Nom a afficher à la place de l'adresse mail
            // $phpmailer->FromName = "Demain des lAube";
            // // Destinataire
            // $phpmailer->addAddress($email);
            // //On indique que le contenu du mail sera du code html
            // // Adresse de réponse
            // $phpmailer->addReplyTo("no-reply@demaindeslaube.fr");
            // //Send HTML or Plain Text email
            // $phpmailer->isHTML();
            // //Encodage utf-8
            // $phpmailer->CharSet = "UTF-8";
            // $phpmailer->Subject = "Réinitialisation du mot de passe sur Demain dès l'aube";
            // //Corps du mail
            // $phpmailer->Body = "<a href=\"" . HOST . "/new_password.php?token={$token}\">Pour réinitialiser votre mot de passe sur Demain dès l'aube cliquez ici</a>. </br>Ce lien est valable 24 heures. </br> Si vous n'êtes pas à l'origine de cette demande veuillez ignorer cet email.";

            $to = $email;
            $messageMail = 
            "<a target='_blank' href=\"" . HOST . "/new_password.php?token={$token}\">Pour réinitialiser votre mot de passe sur Demain dès l'aube cliquez ici</a>." ."
             " . "Ce lien est valable 24 heures." ." 
             " . "Si vous n'êtes pas à l'origine de cette demande veuillez ignorer cet email."

            . " " . "Si vous n'êtes pas à l'origine de cette demande veuillez ignorer cet email.";
            $object = "Réinitialisation du mot de passe -- Demain dès l'Aube";
            // $from = $email;
            // $headers = 'From:' . $email . "\r\n" .
            // 'Reply-To:fojiy79138@giftcv.com' . "\r\n" .
            // 'X-Mailer: PHP/' . phpversion();

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1;CharSet = "UTF-8"';

            if (mail($to, $object, $messageMail, implode("\r\n", $headers))) {
                $message = "Un email pour réinitialiser votre mot de passe a été envoyé." . " <br>
                ". "Veuillez consulter votre boîte mail.";
            } else {
                $message = "Impossible d'envoyer le mail, veillez recommencer.";
            }

            // try {
            //     //Envoie du mail
            //     // $phpmailer->send();
         
            //     // On affiche un message de succès si la requéte s'est bien executée.
            //     $messageSucces = "<div class=\"alert alert-success\">Un email pour réinitialiser votre mot de passe a été envoyé. Veuillez consulter votre boîte mail.</div>";
            // } catch (Exception $e) {
            //     $message = "<div class\"alert alert-danger\">Un problème s'est produit {$mail->ErrorInfo}. Détails : {$e->errorMessage()}.</div>";
            // }
        } else {
            $message = "Erreur de Base de donnée";
        }
    } else {
        // Message d'erreur
        $message = "<div class=\"alert alert-danger\">{$errors[0]}</div>";
    }
}

include("../templates/header.php");
?>
<div class="flowerPicture"></div>
<div class="resetPassword">
    <form action="" method="post">
        <h2>Mot de passe oublié</h2>
        <?php
        if (isset($message)) {
        ?>
            <p><?= $message ?></p>
        <?php
        }
        ?>
        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" id="inputEmail" name="email">
        </div>
        <input type="submit" class="submit" value="Envoyer">
    </form>
</div>

<?php
include("../templates/footer.php");
?>