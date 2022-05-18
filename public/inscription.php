<?php
$page = " s'inscrire.";
//------tableau d'erreur
$errors = [];
$message = "";

if (!empty($_POST)) {
    require_once ('../system/config.php');

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
    //$db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $req = $db->prepare("SELECT * FROM users WHERE email = :email");
    $req->bindParam(":email", $email);
    $req->execute();
    $resultEmail = $req->fetchAll();
    if (!empty($resultEmail)) {
        $errors["email"] = "Votre email a déja servi pour ouvrir un compte";
    }
    // -----Insertion en BDD
    if (empty($errors)) {
        //  $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
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

<div class="inscription">
    <div class="flowerPicture"></div>

    <form action="" method="post">
        <h2>Inscription</h2>
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

<?php
include("../templates/footer.php");
?>