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


$errors = [];
$message = "";

if (!empty($_POST)) {
    require_once('../system/config.php');

    $name = trim(strip_tags($_POST["name"]));
    $firstname = trim(strip_tags($_POST["firstname"]));
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));
    $retypePassword = trim(strip_tags($_POST["retypePassword"]));

    //-----------Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide.";
    }

    //----------Validation password
    if ($password !== $retypePassword) {
        $errors["retypePassword"] = "Les mots de passe ne correspondent pas!";
    }

    //------On impose 6 caractére minimun, une majuscule, une minuscule un chiffre et exclu les espaces et caractéres spéciaux
    $uppercase = preg_match("/[A-Z]/", $password);
    $lowercase = preg_match("/[a-z]/", $password);
    $number = preg_match("/[0-9]/", $password);
    $haveSpace = preg_match("/ /", $password);
    $specialChar = preg_match("/[^a-zA-Z0-9]/", $password);

    if (strlen($password) < 12 || !$uppercase || !$lowercase || $haveSpace || !$specialChar) {
        $errors["password"] = "Le mot de passe doit contenir 12 caractères minimum, une majuscule, une minuscule, un chiffre  et un caractère spécial";
    }

    //--------Gestion des doublons email
    $req = $db->prepare("SELECT * FROM users WHERE email = :email");
    $req->bindParam(":email", $email);
    $req->execute();
    $resultEmail = $req->fetchAll();
    if (!empty($resultEmail)) {
        $errors["email"] = "Votre email a déja servi pour ouvrir un compte";
    }
    // -----Insertion en BDD
    if (empty($errors)) {
        //---------cryptage MDP
        $password = password_hash($password, PASSWORD_DEFAULT);

        //-------requete SQL
        $query = $db->prepare("INSERT INTO users(name, firstname, email, password)
                               VALUES(:name, :firstname, :email, :password)");
        $query->bindParam(":name", $name);
        $query->bindParam(":firstname", $firstname);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        if ($query->execute()) {
            header("location: ./login.php");
        } else {
            $message = "Erreur de bdd";
        }
    } else {
        // -------Message d'erreur
        $message = "Erreur !";
    }
}


include("../templates/header.php");
?>


<div class="flowerPicture"></div>
<div class="login">
    <div class="log">
        <form action="" method="post">
            <h2>Se connecter</h2>

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
    </div>
    <!-- <hr> -->

    <div class="inscription">
        <!-- </div> -->

        <form action="" method="post">
            <h2>Où s'inscrire</h2>
            <div class="form-group">
                <label for="inputName">Votre nom* :</label>
                <input type="name" name="name" id="inputName" value="<?= isset($name) ? $name : "" ?>" required>
            </div>
            <div class="form-group">
                <label for="inputFirstname">Votre Prénom* :</label>
                <input type="firstname" name="firstname" id="inputFirstname" value="<?= isset($firstname) ? $firstname : "" ?>" required>
            </div>
            <div class="form-group">
                <label for="inputEmail">Email* :</label>
                <input type="email" name="email" id="inputEmail" value="<?= isset($email) ? $email : "" ?>" required>
            </div>
            <?php
            if (isset($errors["email"])) {
            ?>
                <p class="error"><?= $errors["email"] ?></p>
            <?php
            }
            ?>
            <div class="form-group">
                <label for="inputPassword">Mot de passe* :</label>
                <input type="password" name="password" id="inputPassword" value="<?= isset($password) ? $password : "" ?>" required>
            </div>
            <?php
            if (isset($errors["password"])) {
            ?>
                <p class="error"><?= $errors["password"] ?></p>
            <?php
            }
            ?>
            <div class="form-group">
                <label for="inputRetypePassword">Mot de passe* :</label>
                <input type="password" name="retypePassword" id="inputRetypePassword" value="<?= isset($retypePassword) ? $retypePassword : "" ?>" required>
            </div>
            <?php
            if (isset($errors["retypePassword"])) {
            ?>
                <p class="error"><?= $errors["retypePassword"] ?></p>
            <?php
            }
            ?>
            <p>* Champs obligatoires</p>
            <input value="Création du compte" type="submit" class="submit">
        </form>
    </div>

</div>

<?php
include("../templates/footer.php");
?>