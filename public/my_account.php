<?php
//ouverture de session
session_start();
require_once('../system/config.php');

$page = "compte admin.";

$query = $db->query("SELECT * FROM photos ORDER BY id DESC");
$photos = $query->fetchAll();

$message = "";
$errors = [];


//test que l'utilisateur est bien connecté
if (!isset($_SESSION["user"])  || ($_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"]) || !isset($_SESSION["token"])) {
    header("Location: ./login.php");
    session_destroy();
} else {
    $token = trim(strip_tags($_SESSION["token"]));
    $query = $db->prepare("SELECT email,token FROM password_reset WHERE token = :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $resultToken = $query->fetch();

    if (($_SESSION["token"]) != ($resultToken["token"])) {
        session_destroy();
        header("Location: ./login.php");
    } else {

        //------------essai de suppresion ds BDD----------
        // $req = $db->prepare("DELETE * FROM password_reset WHERE token = :token");
        // $req->bindParam(":token", $token);
        // $req->execute();
        // $token = trim(strip_tags($_GET["token"]));


        //Ajout

        if ($_SESSION['userRole'] === 'admin') {
            if (!empty($_POST["upload"])) {
                $message = "";
                $errorsF = [];
                $title = trim(strip_tags($_POST["title"]));
                $description = trim(strip_tags($_POST["description"]));
                $category = trim(strip_tags($_POST["category"]));
                $files = trim(strip_tags($_FILES["file"]["name"]));

                if (isset($_FILES['file'])) {

                    $tmpName = $_FILES["file"]["tmp_name"];
                    $name = $_FILES["file"]["name"];
                    $size = $_FILES["file"]["size"];
                    $errors = $_FILES["file"]["error"];
                    $uploadPath = "../assets/img/products/" . $name;
                    $tabExtension = explode(".", $name);
                    $extension = strtolower(end($tabExtension));
                    $extensions = ["jpg", "png", "jpeg", "bmp"];
                    $maxSize = 2000000;
                    if ($maxSize <= $size) {
                        $errorsF["file"] = "Fichier trop volumineux !";
                    }

                    if (in_array($extension, $extensions) && $size <= $maxSize && $errors == 0) {
                        $uniqueName = md5(time());
                        $file = $uniqueName . "." . $extension;
                        move_uploaded_file($tmpName, $uploadPath);
                        rename("../assets/img/products/$files", "../assets/img/products/$file");

                        if (empty(!$title)) {
                            $query = $db->prepare("INSERT INTO photos 
                              (picture, title, description, category)
                               VALUES
                               (:file, :title, :description, :category)");
                            $query->bindParam(":file", $file);
                            $query->bindParam(":title", $title);
                            $query->bindParam(":description", $description);
                            $query->bindParam(":category", $category);
                            if ($query->execute()) {
                                $message = "Image enregistrée. ";
                            }
                        } else {
                            $errorsF["title"] = "Vous devez renseigner un titre !";
                        }
                    }
                } else {
                    $errorsF = "Une erreur est survenue";
                }
            }

            //-----------/MOdification
            //-----------selection id
            if (!empty($_GET["id"])) {
                $id = trim(strip_tags($_GET["id"]));
                $query = $db->prepare("SELECT * FROM photos where id LIKE :id");
                $query->bindParam(":id", $id);
                $query->execute();
                $photoId = $query->fetch();
        
            }

            if (!empty($_POST["modifyP"])) {
                $modify = trim(strip_tags($_POST["modify"]));
                $titleModify = trim(strip_tags($_POST["titleModify"]));
                $descriptionModify = trim(strip_tags($_POST["descriptionModify"]));
                $categoryModify = trim(strip_tags($_POST["categoryModify"]));
                $filesModify = trim(strip_tags($_FILES["filesModify"]["name"]));
                $messageModify = "";
                $errorsModify = [];

                if (isset($_FILES['filesModify'])) {
                    $tmpName = $_FILES["filesModify"]["tmp_name"];
                    $name = $_FILES["filesModify"]["name"];
                    $size = $_FILES["filesModify"]["size"];
                    $errorsModify = $_FILES["filesModify"]["error"];
                    $uploadPath = "../assets/img/products/" . $name;
                    $tabExtension = explode(".", $name);
                    $extension = strtolower(end($tabExtension));
                    $extensions = ["jpg", "png", "jpeg", "bmp"];
                    $maxSize = 2000000;

                    if (in_array($extension, $extensions) && $size <= $maxSize && $errorsModify == 0) {
                        $uniqueName =  md5(time());
                        $file = $uniqueName . "." . $extension;
                        move_uploaded_file($tmpName, $uploadPath);
                        rename("../assets/img/products/$filesModify", "../assets/img/products/$file");
                        //var_dump($file);
                        if ($maxSize <= $size) {
                            $errorsModify["filesModify"] = "Fichier trop volumineux !";
                        }
                        if (empty($errorsModify)) {
                            //  $dbase = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
                            $query = $db->prepare("UPDATE photos SET
                                       title = :titleModify,
                                       description = :descriptionModify,
                                       picture = :filesModify,
                                       category = :categoryModify
                                       WHERE id = :modify");
                            $query->bindParam(":modify", $modify, PDO::PARAM_INT);
                            $query->bindParam(":filesModify", $file);
                            $query->bindParam(":titleModify", $titleModify);
                            $query->bindParam(":descriptionModify", $descriptionModify);
                            $query->bindParam(":categoryModify", $categoryModify);
                            if ($query->execute()) {
                                $messageModify = "Image enregistrée";
                            }
                        } else {
                            $errorsModify["error"] = "Erreur !";
                        }
                    }
                } else {
                    $errorsModify["files"] = "Une erreur de fichier est survenue";
                }
            }


            //--------------Suppresion de fichier
            if (!empty($_POST["delete"])) {
                $deleteMessage = [];
                $delete = ($_POST["delete"]);
                $query = $db->prepare("DELETE FROM photos WHERE id = :delete");
                $query->bindParam(":delete", $delete);
                if ($query->execute()) {
                    $deleteMessage["succes"] = "Votre fichier a été supprimé.";
                    // //   unlink("assets/img/products/")
                    // $queryp = $db->query("SELECT * FROM photos WHERE id = :delete");
                    // $queryp->bindParam(":delete", $delete);
                    // $queryp->execute();
                    // $pho = $queryp->fetch();
                    // foreach ($photos as $phot) {
                    // unlink("assets/img/products/" . $pho["picture"]);
                    // }
                } else {
                    $deleteMessage["fail"] = "Erreur de suppression.";
                }
            }

            //--------Suppression de compte
            if (!empty($_POST["deleteAccountBtn"])) {
                $idUsers = $_SESSION["userId"];
                $query = $db->prepare("DELETE FROM users WHERE id LIKE :idUsers");
                $query->bindParam(":idUsers", $idUsers);
                if ($query->execute()) {
                    session_destroy();
                    header("location: ./index.php");
                }
            }
        } else {
            Header("Location: ../public/contact.php");
        }
    }
}
// }
include("../templates/header.php");
?>

<div class="myAccount">
    <div class="welcome">
        <h2>Bienvenue sur votre compte, <?= $_SESSION["user"] . " " . $_SESSION["userName"] ?></h2>
    </div>
    <?php
    if (isset($message)) {
    ?>
        <p class="error"><?= $message ?></p>
    <?php
    }
    ?>
    <form method="post" enctype="multipart/form-data">
        <h2>Ajouter un produit</h2>
        <div class="form-group">
            <div class="submit">
                <label for="file">Sélectionner une photo</label>
                <input type="file" id="file" name="file" accept=".jpg, .png, .bmp, .jpeg" style="display: none;">
            </div>
            <?php
            if (isset($errorsF["file"])) {
            ?>
                <p class="error"><?= $errorsF["file"] ?></p>
            <?php
            }
            ?>
        </div>

        <div class="form-group">
            <label for="titleUpload">Titre :</label>
            <input type="text" id="titleUpload" name="title" value="<?= isset($title) ? $title : "" ?>">
        </div>
        <?php
        if (isset($errorsF["title"])) {
        ?>
            <p class="error"><?= $errorsF["title"] ?></p>
        <?php
        }
        ?>

        <div class="form-group">
            <label for="descriptionUpload">Description :</label>
            <input type="text" id="descriptionUpload" name="description" value="<?= isset($description) ? $description : "" ?>">
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
    <hr>
    <h2 class="ourProducts">Vos produits</h2>
    <?php
    if (isset($deleteMessage["succes"])) {
    ?>
        <p class="error"><?= $deleteMessage["succes"] ?></p>
    <?php
    }
    ?>
    <?php
    if (isset($deleteMessage["fail"])) {
    ?>
        <p class="error"><?= $deleteMessage["fail"] ?></p>
    <?php
    }
    ?>

    <div class="view">
        <?php
        foreach ($photos as $photo) {
        ?>
            <div class="photo">
                <img src="../assets/img/products/<?= $photo['picture'] ?>">
                <h1><?= $photo["title"] ?></h1>
                <h2><?= $photo["category"] ?></h2>
                <h2>Numéro: <?= $photo["id"] ?></h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <button type="submit" name="delete" value="<?= $photo["id"] ?>">
                        Supprimer
                    </button>
                   
                        <button type="submit" name="modifyFiles" value="<?= $photo["id"] ?>">
                        <a href="./my_account.php?id=<?= $photo["id"] ?>#modifyLink">   Modifier </a>
                        </button>
                   
                </form>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="modifyDelete">
        <form method="post" enctype="multipart/form-data">
            <h2>Modifier un produit </h2>
            <!-- <?php
                    if (isset($messageModify)) {
                    ?>
                <p class="error"><?= $messageModify ?></p>
            <?php
                    }
            ?> -->
            <h3>Veuillez sélectionner votre produit à modifier </h3>
            <div class="form-group" >
                <label for="inputModify" id="modifyLink">Veuillez entrer le Numéro Identifiant du produit à modifier ou selectionnez directement la photo</label>
                <input type="text" id="inputModify" name="modify" value="<?= isset($id) ? $id : "" ?>">

            </div>
            <div class="form-group">
                <div class="submit">
                    <label for="filesModify">Sélectionner une photo</label>
                    <input type="file" id="filesModify" name="filesModify" accept=".jpg, .png, .bmp, .jpeg" style="display: none">
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
                <input type="text" id="descriptionUploadModify" name="descriptionModify" value="<?= isset($photoId["description"]) ? $photoId["description"] : "" ?>">
                <!-- <?php
                        if (isset($errors["descriptionModify"])) {
                        ?>
                    <span class="infoError"><?= $errors["descriptionModify"] ?></span>
                <?php
                        }
                ?> -->
            </div>
            <div class="form-group">
                <label for="inputCategoryModify">Veuillez séléctionner la catégorie de votre produit :</label>
                <select name="categoryModify" id="inputCategoryModify" class="submit" value="<?= isset($photoId["category"]) ? $photoId["category"] : "" ?>">
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
    </div>
</div>

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

<?php
include("../templates/footer.php");
?>