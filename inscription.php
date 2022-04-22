<?php
include("templates/header.php");

if(!empty($_POST)){

    $name = trim(strip_tags($_POST["name"]));
    $firstname = trim(strip_tags($_POST["firstname"]));
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));
    $retypePassword = trim(strip_tags($_POST["retypePassword"]));

    //tableau d'erreur
    $errors =[];

    //Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }

    //Validation password
    if($password !== $retypePassword) {
        $errors["retypePasword"]= "Les mots de passe de correspondent pas!";
    }

   //On impose 6 caractére minimun, une majuscule, une minuscule un chiffre et exclu les espaces
    $uppercase = preg_match("/[A-Z]/", $password);
    $lowercase = preg_match("/[a-z]/", $password);
    $number = preg_match("/[0-9]/", $password);
    $haveSpace = preg_match("/ /", $password);

    if(strlen($password) < 6 || !$uppercase || !$lowercase || $haveSpace) {
        $errors["password"] = "Le mot de passe doit contenir 6 caractéres minimum, une majuscule, une minuscule et un chiffre";
    }

   // Insertion en BDD
    if (empty($errors)) {
        $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");

        //cryptage MDP
        $password = password_hash($password, PASSWORD_DEFAULT);

        //test cryptage
        //var_dump($password);

        //requete SQL
        $query = $db->prepare("INSERT INTO users(name, firstname, email, password)
                               VALUES(:name, :firstname, :email, :password)");
        $query->bindParam(":name", $name);
        $query->bindParam(":firstname", $firstname);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);

        $query->execute();

        header("location: login.php");
    }

}



?>
<div class="inscription">
    <div class="flowerPicture"></div>


<form action="" method="post">
<h2>Inscription</h2>
<div class="form-group">
            <label for="inputName">Votre nom :</label>
            <input type="name" name="name" id="inputName" value="<?= isset ($name) ? $name : "" ?>">
        </div>
        <div class="form-group">
            <label for="inputFirstname">Votre Prénom :</label>
            <input type="firstname" name="firstname" id="inputFirstname" value="<?= isset ($firstname) ? $firstname : "" ?>">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" name="email" id="inputEmail" value="<?= isset ($email) ? $email : "" ?>">
            <?php
            if (isset($errors["email"])) {
                ?>
                <p><?= $errors["email"] ?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputPassword">Mot de passe :</label>
            <input type="password" name="password" id="inputPassword" value="<?= isset ($password) ? $password : "" ?>">
            <?php
            if (isset($errors["password"])) {
                ?>
                <p><?= $errors["password"] ?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputRetypePassword">Mot de passe :</label>
            <input type="password" name="retypePassword" id="inputRetypePassword" value="<?= isset ($retypePassword) ? $retypePassword : "" ?>">
            <?php
            if (isset($errors["retypePassword"])) {
                ?>
                <p><?= $errors["retypePassword"] ?></p>
                <?php
            }
            ?>
        </div>
        <input value="Création du compte" type="submit" class="submit"></input>
</form>
</div>




<?php
include("templates/footer.php");
?>