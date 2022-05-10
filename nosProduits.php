<?php
include("templates/header.php");
require_once './system/config.php';

//$db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
$query = $db->query("SELECT *FROM photos
                 WHERE category = 'Fleurs' 
                 ORDER BY id DESC");
$flowersPic = $query->fetchAll();

$query = $db->query("SELECT *FROM photos
                 WHERE category = 'PlantesVertes' 
                 ORDER BY id DESC");
$plantPic = $query->fetchAll();

$query = $db->query("SELECT *FROM photos
                 WHERE category = 'Decoration' 
                 ORDER BY id DESC");
$decoPic = $query->fetchAll();

$query = $db->query("SELECT *FROM photos
                 WHERE category = 'Bijoux' 
                 ORDER BY id DESC");
$jewelsPic = $query->fetchAll();

$query = $db->query("SELECT *FROM photos
                 WHERE category = 'Mariage' 
                 ORDER BY id DESC");
$wedingPic = $query->fetchAll();

$query = $db->query("SELECT *FROM photos
                 WHERE category = 'Deuil' 
                 ORDER BY id DESC");
$mourningPic = $query->fetchAll();

$query = $db->query("SELECT *FROM photos
                 WHERE category = 'Others' 
                 ORDER BY id DESC");
$othersPic = $query->fetchAll();
?>

<div class="topSection" id="top">
    <img src="assets/img/logo/Flower.png" alt="">
    <h3 class="smH3">Découvrez</h3>

    <h3 class="xlH3">Nos Productions</h3>
    <hr>
</div>

<div class="productsView">
    <h3>Tous nos produits sont 100% faits maison</h3>
    <hr>
    <div class="wrapProducts">
        <div class="prod">
            <a href="#flowerLink">
                <img src="./assets/img/logo/bouquet-de-fleurs.png" alt="Bouquet de fleurs">
                <h4>Fleurs </h4>
                <hr>
                <p>Fleurs, bouquets, compositions...Découvrez nos diverses créations florales</p>
            </a>
        </div>
        <div class="prod">
            <a href="#plantLink">
                <img src="./assets/img/logo/plante.png" alt="Plantes Vertes">
                <h4>Plantes vertes</h4>
                <hr>
                <p>Retrouvez notre sélection de plantes vertes pour égayer votre intérieur</p>
            </a>
        </div>
        <div class="prod">
            <a href="#decoLink">
                <img src="./assets/img/logo/decoratif.png" alt="Décorations">
                <h4>Décorations</h4>
                <hr>
                <p>Voici nos décorations florales et artisanales</p>
            </a>
        </div>
        <div class="prod">
            <a href="#jewelsLink">
                <img src="./assets/img/logo/collier.png" alt="Bijoux">
                <h4>Bijoux</h4>
                <hr>
                <p>Notre gamme de bijoux faits maison</p>
            </a>
        </div>
        <div class="prod">
            <a href="#wedingLink">
                <img src="./assets/img/logo/weding.png" alt="Mariage">
                <h4>Mariages</h4>
                <hr>
                <p>Découvrez nos réalisations pour vos mariages</p>
            </a>
        </div>
        <div class="prod">
            <a href="#mourningLink">
                <img src="./assets/img/logo/rip.png" alt="Deuil">
                <h4>Deuils</h4>
                <hr>
                <p>Découvrez nos réalisations pour accompagner vos périodes de deuil</p>
            </a>
        </div>
    </div>
</div>
<div class="radient">
</div>

<div class="viewProducts">
    <h1>Fleurs</h1>
    <div class="view flowersView" id="flowersLink">
        <?php
        foreach ($flowersPic as $flowerP) {
        ?>
            <div class="wrapImg">
                <a href="assets/img/products/<?= $flowerP['picture'] ?>" target="_blank">
                    <img src="assets/img/products/<?= $flowerP['picture'] ?>" alt="">
                </a>
                <div class="txtView">
                    <h3> <?= $flowerP["title"] ?></h3>

                    <h4> <?= $flowerP["category"] ?></h4>
                    <h4> <?= $flowerP["description"] ?></h4>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="#top" class="a">Retour vers le haut de page</a>
    <h1>Plantes Vertes</h1>
    <div class="view plantView" id="plantLink">
        <?php
        foreach ($plantPic as $plantP) {
        ?>
            <div class="wrapImg">
                <a href="assets/img/products/<?= $plantP['picture'] ?>" target="_blank">
                    <img src="assets/img/products/<?= $plantP['picture'] ?>" alt="">
                </a>
                <div class="txtView">
                    <h3> <?= $plantP["title"] ?></h3>

                    <h4> <?= $plantP["description"] ?></h4>
                    <h4> <?= $plantP["category"] ?></h4>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="#top" class="a">Retour vers le haut de page</a>
    <h1>Décorations</h1>
    <div class="view decoView" id="decoLink">
        <?php
        foreach ($decoPic as $decoP) {
        ?>
            <div class="wrapImg">
                <a href="assets/img/products/<?= $decoP['picture'] ?>" target="_blank">
                    <img src="assets/img/products/<?= $decoP['picture'] ?>" alt="">
                </a>
                <div class="txtView">
                    <h3> <?= $decoP["title"] ?></h3>
                    <h4> <?= $decoP["description"] ?></h4>
                    <h4> <?= $decoP["category"] ?></h4>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="#top" class="a">Retour vers le haut de page</a>
    <h1>Bijoux</h1>
    <div class="view jewelsView" id="jewelsLink">
        <?php
        foreach ($jewelsPic as $jewelsP) {
        ?>
            <div class="wrapImg">
                <a href="assets/img/products/<?= $jewelsP['picture'] ?>" target="_blank">
                    <img src="assets/img/products/<?= $jewelsP['picture'] ?>" alt="">
                </a>
                <div class="txtView">
                    <h3> <?= $jewelsP["title"] ?></h3>
                    <h4> <?= $jewelsP["description"] ?></h4>
                    <h4> <?= $jewelsP["category"] ?></h4>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="#top" class="a">Retour vers le haut de page</a>
    <h1>Mariage</h1>
    <div class="view wedingView" id="wedingLink">
        <?php
        foreach ($wedingPic as $wedingP) {
        ?>
            <div class="wrapImg">
                <a href="assets/img/products/<?= $wedingP['picture'] ?>" target="_blank">
                    <img src="assets/img/products/<?= $wedingP['picture'] ?>" alt="">
                </a>
                <div class="txtView">
                    <h3> <?= $wedingP["title"] ?></h3>
                    <h4> <?= $wedingP["description"] ?></h4>
                    <h4> <?= $wedingP["category"] ?></h4>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="#top" class="a">Retour vers le haut de page</a>
    <h1>Deuil</h1>
    <div class="view mourningView" id="mourningLink">
        <?php
        foreach ($mourningPic as $mourningP) {
        ?>
            <div class="wrapImg">
                <a href="assets/img/products/<?= $mourningP['picture'] ?>" target="_blank">
                    <img src="assets/img/products/<?= $mourningP['picture'] ?>" alt="">
                </a>
                <div class="txtView">
                    <h3> <?= $mourningP["title"] ?></h3>
                    <h4> <?= $mourningP["description"] ?></h4>
                    <h4> <?= $mourningP["category"] ?></h4>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="#top" class="a">Retour vers le haut de page</a>
</div>

<?php
include("templates/footer.php");
?>