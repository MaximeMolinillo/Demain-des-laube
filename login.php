<?php
include("templates/header.php");
$error = "";


// if ($email === "max_224@hotmail.fr") {
    if (!empty($_POST)) {
        $email = trim(strip_tags($_POST["email"]));
        $password = trim(strip_tags($_POST["password"]));

        $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
        $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
        $query->bindparam(":email", $email);
        $query->execute();
        //PDO::FETCH_ASSOC pr eviter les doublons
        $result = $query->fetch(PDO::FETCH_ASSOC);

        //var_dump($result);
        //   if ($password == $result["password"])  pas possible de tester comme ca car nous avons d'un coté une donnée non cryptée et une donnée cryptée
        //  if ($password_hash($password) == $result["password"])  pas possible non plus car la hash généré par password_hash change à chaque appel
        //password_verify va nous permettre de vérifier la correspondance entre le mot de passe saisi et le hash stocké en BDD
        if (!empty($result) && password_verify($password, $result["password"])) {
            // Les informations de connexion sont correctes
            //Démarage du systéme de session 
            session_start();
            // On stocke le prénom dans une variable de session
            $_SESSION["user"] = $result["firstname"] . " " . $result["name"];
            //On stocke l'adresse ip de l'utilisateur pour palier à une possible attaque "session hijacking"
            $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];
            // Redirection 
            header("Location: my_account.php");
        } else {
            $error = "Erreur de connexion veillez recomencer l'identification";
        }
    // }
}
?>

<main class="login">

    <?= $error ?>
    <div class="flowerPicture"></div>
    <form action="" method="post">
        <h2>Connexion à votre espace utilisateur</h2>
        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" name="email" id="inputEmail">
        </div>
        <div class="form-group">
            <label for="inputPassword">Mot de passe :</label>
            <input type="password" name="password" id="inputPassword">
        </div>
        <input type="submit" value="Se connecter" class="submit">
    </form>
    <div class="bottomLink">
        <a href="reset_password.php">J'ai oublié mon mot de passe</a>
    </div>


</main>


<?php
include("templates/footer.php");
?>