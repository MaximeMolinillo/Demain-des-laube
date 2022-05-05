<?php
//ouverture de session
session_start();

//Affichage photo pr suppression/modif
$db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
$query = $db->query("SELECT * FROM photos ORDER BY id DESC");
$photos = $query->fetchAll();


//test que l'utilisateur est bien connecté
if (!isset($_SESSION["user"])  || ($_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"])) {
    header("Location: login.php");
}

$querys = $db->prepare("SELECT * FROM users");
$results = $querys->fetch(PDO::FETCH_ASSOC);


// var_dump($results);

// if ($results["role"] === "utilisateur") {
//     header("Location: contact.php");
// }



//Ajout

if (!empty($_POST["upload"])) {

    // $file = trim(strip_tags($_POST["file"]));
    $title = trim(strip_tags($_POST["title"]));
    $description = trim(strip_tags($_POST["description"]));
    $category = trim(strip_tags($_POST["category"]));
    $files = trim(strip_tags($_FILES["file"]["name"]));

    $errors = [];
    if (isset($_FILES['file'])) {


        $tmpName = $_FILES["file"]["tmp_name"];
        $name = $_FILES["file"]["name"];
        $size = $_FILES["file"]["size"];
        $errors = $_FILES["file"]["error"];
        $uploadPath = "./assets/img/products/" . $name;
        // $errorsF = [];
        $tabExtension = explode(".", $name);
        $extension = strtolower(end($tabExtension));

        $extensions = ["jpg", "png", "jpeg", "bmp"];
        $maxSize = 2000000;

        if (in_array($extension, $extensions) && $size <= $maxSize && $errors == 0) {
            $uniqueName = uniqid("", true);
            $file = $uniqueName . "." . $extension;

            move_uploaded_file($tmpName, $uploadPath);

            rename("assets/img/products/$files", "assets/img/products/$file");

            //var_dump($files);


            if ($maxSize <= $size) {
                $errors["file"] = "Fichier trop volumineux !";
            }
            var_dump($errors);
            if (!empty($title)) {
                $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
                $query = $db->prepare("INSERT INTO photos 
                              (picture, title, description, category)
                               VALUES
                               (:file, :title, :description, :category)");

                $query->bindParam(":file", $file);
                $query->bindParam(":title", $title);
                $query->bindParam(":description", $description);
                $query->bindParam(":category", $category);
                if ($query->execute()) {
                    echo "Image enregistrée";
                }
            } else {
                echo "Vous devez renseigner un titre !";
            }
        }
    } else {
        echo "Une erreur est survenue";
    }
}
//}



///MOdification

if (!empty($_POST["modifyFiles"])) {
    $modifyFiles = trim(strip_tags($_POST["modifyFiles"]));
    //var_dump($photos);
    //  $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    //  $query = $db->prepare("SELECT * FROM photos WHERE id = :modifyFiles");
    //  $query->bindParam("modifyFiles", $modifyFiles);
    //  $photosId = $query->execute();

   // var_dump($modifyFiles);
    $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->query("SELECT * FROM photos where id LIKE $modifyFiles");
    $query->bindParam(":modifyFiles", $modifyFiles);
    $photoId = $query->fetch();
 //   var_dump($photoId);

}


//en entrant l'id :

// if (!empty($_POST['modifyId'])) {
//     //  $modify= trim(strip_tags($_POST["modify"]));
//     $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
//     $query = $db->prepare("SELECT * FROM photos WHERE id = :modify");
//     $photosid = $query->fetchAll();
//     //     $queryr->bindParam(":modify", $modify);
//     //    $idModify = $query->execute();
//     var_dump($photo);
//     echo $photosid;
// }






if (!empty($_POST["modifyP"])) {
    $modify = trim(strip_tags($_POST["modify"]));
    $titleModify = trim(strip_tags($_POST["titleModify"]));
    $descriptionModify = trim(strip_tags($_POST["descriptionModify"]));
    $categoryModify = trim(strip_tags($_POST["categoryModify"]));
    $filesModify = trim(strip_tags($_FILES["filesModify"]["name"]));

    // var_dump($modifyFiles);

    $errorsModify = [];

    if (isset($_FILES['filesModify'])) {
        $tmpName = $_FILES["filesModify"]["tmp_name"];
        $name = $_FILES["filesModify"]["name"];
        $size = $_FILES["filesModify"]["size"];
        $errorsModify = $_FILES["filesModify"]["error"];
        $uploadPath = "./assets/img/products/" . $name;
        $tabExtension = explode(".", $name);
        $extension = strtolower(end($tabExtension));
        $extensions = ["jpg", "png", "jpeg", "bmp"];
        $maxSize = 2000000;

        if (in_array($extension, $extensions) && $size <= $maxSize && $errorsModify == 0) {
            $uniqueName = uniqid("", true);
            //  $uniqueNameM = md5();
            $file = $uniqueName . "." . $extension;

            move_uploaded_file($tmpName, $uploadPath);

            rename("assets/img/products/$filesModify", "assets/img/products/$file");

            //var_dump($file);


            if ($maxSize <= $size) {
                $errorsModify["filesModify"] = "Fichier trop volumineux !";
            }
            // var_dump($errorsM);
            var_dump($errorsModify);
            if (empty($errorsModify)) {
                // if (!empty($titleModify)) {
                $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
                $query = $db->prepare("UPDATE photos SET
                                       title = :titleModify,
                                       description = :descriptionModify,
                                       picture = :filesModify,
                                       category = :categoryModify
                                       WHERE id = :modify");
                $query->bindParam(":modify", $modify);
                $query->bindParam(":filesModify", $file);
                $query->bindParam(":titleModify", $titleModify);
                $query->bindParam(":descriptionModify", $descriptionModify);
                $query->bindParam(":categoryModify", $categoryModify);
                if ($query->execute()) {
                    echo "Image enregistrée";
                }
            } else {
                echo "erreur !";
            }
        }
    } else {
        echo "Une erreur est survenue";
    }
}

//Suppresion de fichier

if (!empty($_POST["delete"])) {

    $delete = ($_POST["delete"]);


    $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("DELETE FROM photos WHERE id = :delete");

    $query->bindParam(":delete", $delete);
    $query->execute();
}

//Suppression de compte
if (!empty($_POST["deleteAccountBtn"])) {
    $idUsers = $_SESSION["userId"];
    $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("DELETE FROM users WHERE id LIKE $idUsers");
    // }
    // $query->bindParam(":deleteAccount", $deleteAccount);
    if ($query->execute()) {
        session_destroy();
        header("location: index.php");
    }
}

include("templates/header.php");
?>

<div class="myAccount">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="welcome">
            <h2>Bienvenue sur votre compte, <?= $_SESSION["user"] . " " . $_SESSION["userName"] ?></h2>
        </div>
        <div class="form-group">




            <div class="submit">
                <label for="file">Sélectionner une photo</label>
                <input type="file" id="file" name="file" accept=".jpg, .png, .bmp" style="display: none;">
            </div>




        </div>


        <div class="form-group">
            <label for="titleUpload">Titre :</label>
            <input type="text" id="titleUpload" name="title" value="<?= isset($title) ? $title : "" ?>">
            <?php
            if (isset($errors["title"])) {
            ?>
                <span class="infoError"><?= $errors["title"] ?></span>
            <?php
            }
            ?>

        </div>
        <div class="form-group">
            <label for="descriptionUpload">Description :</label>
            <input type="text" id="descriptionUpload" name="description" value="<?= isset($description) ? $description : "" ?>">
            <?php
            if (isset($errors["description"])) {
            ?>
                <span class="infoError"><?= $errors["description"] ?></span>
            <?php
            }
            ?>
        </div>

        <div class="form-group">
            <label for="inputCategory">Veuillez séléctionner la catégorie de votre produit :</label>
            <select name="category" id="inputCategory" class="submit">


                <option value="Fleurs" <?= (isset($category) && $category === "Fleurs") ? "selected" : "" ?>>Fleurs</option>
                <option value="PlantesVertes" <?= (isset($category) && $category === "PlantesVertes") ? "selected" : "" ?>>Plantes vertes</option>
                <option value="Decoration" <?= (isset($category) && $category === "Decoration") ? "selected" : "" ?>>Décoration</option>
                <option value="Bijoux" <?= (isset($category) && $category === "Bijoux") ? "selected" : "" ?>>Bijoux</option>
                <option value="Mariage" <?= (isset($category) && $category === "Mariage") ? "selected" : "" ?>>Mariage</option>
                <option value="Deuil" <?= (isset($category) && $category === "Deuil") ? "selected" : "" ?>>Deuil</option>
                <option value="Others" <?= (isset($category) && $category === "Others") ? "selected" : "" ?>>Autres</option>
            </select>

        </div>
        <input type="submit" value="Ajouter le produit" class="submit" name="upload">
    </form>


    <div class="bottomLink">
        <a href="logout.php">Déconnexion</a>
    </div>


    <hr>

    <div class="view">
        <?php
        foreach ($photos as $photo) {
        ?>
            <!-- <div class="photos"> -->
            <div class="photo">
                <img src="assets/img/products/<?= $photo['picture'] ?>">
                <h1><?= $photo["title"] ?></h1>
                <h2><?= $photo["category"] ?></h2>
                <h2>Numéro: <?= $photo["id"] ?></h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <button type="submit" name="delete" value="<?= $photo["id"] ?>">
                        Supprimer
                    </button>
                    <a href="#modifyLink">
                        <button type="submit" name="modifyFiles" value="<?= $photo["id"] ?>">
                            Modifier
                        </button>
                    </a>
                    <!-- <input type="submit" name="modifyFiles" value="Modifier"> -->
                    <!-- Modifier -->

                </form>
            </div>


        <?php
        }
        ?>


        <!-- </form> -->



        <!-- </div> -->

    </div>



    <div class="modifyDelete">

        <form action="" method="post" enctype="multipart/form-data">
            <h2 id="modifyLink">Modifier un produit </h1>
                <div class="form-group">
                    <label for="inputModify">Veuillez entrer le Numéro Identifiant du produit a modifier</label>
                    <input type="text" id="inputModify" name="modify" value="<?= isset($modifyFiles) ? $modifyFiles : "" ?>">
                 
                </div>
                <div class="form-group">
                    <div class="submit">
                        <label for="filesModify">Sélectionner une photo</label>
                        <input type="file" id="filesModify" name="filesModify" accept=".jpg, .png, .bmp" style="display: none">
                        <?php
                        if (isset($errorsModify["filesModify"])) {
                        ?>
                            <p> <?= $errorsModify["filesModify"] ?></p>
                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="form-group">
                    <label for="titleUploadModify">Titre :</label>
                    <input type="text" id="titleUploadModify" name="titleModify" value="<?= isset($photoId["title"]) ? $photoId["title"] : "" ?>">

                </div>
                <div class="form-group">
                    <label for="descriptionUploadModify">Description :</label>
                    <input type="text" id="descriptionUploadModify" name="descriptionModify" value="<?= isset($photoId["description"]) ? $photoId["description"]: "" ?>">
                    <?php
                    if (isset($errors["descriptionModify"])) {
                    ?>
                        <span class="infoError"><?= $errors["descriptionModify"] ?></span>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputCategoryModify">Veuillez séléctionner la catégorie de votre produit :</label>
                    <select name="categoryModify" id="inputCategoryModify" class="submit" value="<?= isset($photoId["category"]) ? $photoId["category"]: "" ?>">


                        <option value="Fleurs" <?= (isset($category) && $category === "Fleurs") ? "selected" : "" ?>>Fleurs</option>
                        <option value="PlantesVertes" <?= (isset($category) && $category === "PlantesVertes") ? "selected" : "" ?>>Plantes vertes</option>
                        <option value="Decoration" <?= (isset($category) && $category === "Decoration") ? "selected" : "" ?>>Décoration</option>
                        <option value="Bijoux" <?= (isset($category) && $category === "Bijoux") ? "selected" : "" ?>>Bijoux</option>
                        <option value="Mariage" <?= (isset($category) && $category === "Mariage") ? "selected" : "" ?>>Mariage</option>
                        <option value="Deuil" <?= (isset($category) && $category === "Deuil") ? "selected" : "" ?>>Deuil</option>
                        <option value="Others" <?= (isset($category) && $category === "Others") ? "selected" : "" ?>>Autres</option>

                    </select>
                </div>
                <input type="submit" class="submit" value="Modifier le produit" name="modifyP">
        </form>


        <!-- <form action="" method="post" enctype="multipart/form-data">

            <h2>Supprimer un produit</h2>
            <div class="form-group">
                <label for="inputDelete">Veuillez entrer le Numéro Identifiant du produit a supprimer</label>
                <input type="text" id="inputDelete" name="delete" value="<?= isset($delete) ? $delete : "" ?>">

            </div>
            <input type="submit" class="submit" value="Supprimer le produit" name="deleteP">
        </form> -->
    </div>

</div>

<div class="deleteAccount">
    <h3>supprimer mon compte</h3>
    <form action="" method="post">
        <div class="form-group">

            <input type="submit" value="Supprimer mon compte" name="deleteAccountBtn">
        </div>
    </form>
</div>



<?php
include("templates/footer.php");
?>