<?php
include("templates/header.php");

if (isset($_GET["token"])) {
    $token = trim(strip_tags($_GET["token"]));

    if ($password !== $retypePassword) {
        $errors["retypePasword"] = "Les mots de passe de correspondent pas!";
    }

    $uppercase = preg_match("/[A-Z]/", $password);
    $lowercase = preg_match("/[a-z]/", $password);
    $number = preg_match("/[0-9]/", $password);
    $haveSpace = preg_match("/ /", $password);

    if (strlen($password) < 6 || !$uppercase || !$lowercase || $haveSpace) {
        $errors["password"] = "Le mot de passe doit contenir 6 caractéres minimum, une majuscule, une minuscule et un chiffre";
    }

    $db = new PDO("mysql:host=localhost;dbname=startauth", "root", "");
    $query = $db->prepare("SELECT email FROM password_reset WHERE token LIKE :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $result = $query->fetch();

    if (empty($result)) {
        //token pas trouvé redirection
        header("Location: ./");
    }

    //var_dump($result);
    if (isset($_POST["password"])) {
        //Le formulaire est envoyé et un mot de passe est disponible
        //N'oubliez pas de valider la consistance du mot de passe comme dans create_account.php
        $password = trim(strip_tags($_POST["password"]));
        $password = password_hash($password, PASSWORD_DEFAULT);

        //Requete SQL de mise a jour du mot de passe
        $query = $db->prepare("UPDATE users SET password = :password WHERE email LIKE :email");
        $query->bindParam(":password", $password);
        $query->bindParam(":email", $result["email"]);
        if ($query->execute()) {
            //Possibilité de compléter avec une réquéte DELETE sur la table password_reset pour purger la ligne en question
            header("Location: ./login.php");
        }
    }
} else {
    //Pas de token dans l'url c'est louche !
    header("Location: ./");
}

?>

<div class="newPassword">
    <form action="" method="post">
        <label for="inputPassword">Nouveau mot de passe :</label>
        <input type="password" name="password" id="inputPassword">
        <label for="retypeInputPassword">Retaper votre mot de passe :</label>
        <input type="retypePassword" name="retypePassword" id="retypeInputPassword">
        <input type="submit" value="Envoyer">
    </form>
</div>



<?php
include("templates/footer.php");
?>