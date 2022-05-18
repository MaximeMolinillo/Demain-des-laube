<?php
require_once('../system/config.php');
$page = "Page d'accueil.";

// $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
$query = $db->query("SELECT * FROM photos ORDER BY id DESC LIMIT 0,12");
$photos = $query->fetchAll();
include("../templates/header.php");
?>

<div class="topSection">
    <img src="../assets/img/logo/Flower.webp" alt="Fleur">
    <h3 class="smH3">Découvrez</h3>
    <h3 class="xlH3">Nos produits</h3>
    <hr>
</div>
<section>
    <div class="wrapSection">
        <?php
        foreach ($photos as $photo) {
        ?>
            <div class="pic">
                <div class="pictures">
                    <img src="../assets/img/products/<?= $photo['picture'] ?>" alt="<?= $photo["title"] ?>">
                </div>
            </div>
        <?php
        }
        ?>
        <div class="presentation">
            <h2>Présentation</h2>
            <p>Demain dès l'Aube est un fleuriste situé à cinq minutes du centre de Douai. Les fleurs ne sont pas nos seules spécialités car nous proposons également des plantes vertes, de la décoration ainsi que des bijoux. Toutes nos créations sont 100% artisanales et faites maison. Nous proposons également des services évènementiels comme vous accompagner lors de vos mariages (Bouquets de fleurs, décoration voitures, accessoires vestimentaires etc…), ou être à vos côtés lors de vos périodes de deuil . Vous trouverez des emplacements de parking gratuit juste devant la boutique. </p>
        </div>

        <div class="magasinPicture">
        </div>

        <div class=" productsView ">
            <h2>Nos Productions</h2>
            <h3>Tous nos produits sont 100% faits maison</h3>
            <hr>
            <div class="wrapProducts">
                <div class="prod">
                    <a href="nosProduits.php#flowerLink">
                        <img src="../assets/img/logo/bouquet-de-fleurs.webp" alt="Bouquet de fleurs">
                        <hr>
                        <h4>Fleurs </h4>
                        <p>Fleurs, bouquets, compositions... Découvrez nos diverses créations florales</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#plantLink">
                        <img src="../assets/img/logo/plante.webp" alt="Plante Verte">
                        <hr>
                        <h4>Plantes Vertes</h4>
                        <p>Retrouvez notre sélection de plantes vertes pour égayer votre intérieur</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#decoLink">
                        <img src="../assets/img/logo/decoratif.webp" alt="Décorations">
                        <hr>
                        <h4>Décorations</h4>
                        <p>Voici nos décorations florales et artisanales</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#jewelsLink">
                        <img src="../assets/img/logo/collier.webp" alt="Bijoux">
                        <hr>
                        <h4>Bijoux</h4>
                        <p>Notre gamme de bijoux faits maison</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#wedingLink">
                        <img src="../assets/img/logo/weding.webp" alt="Mariage">
                        <hr>
                        <h4>Mariages</h4>
                        <p>Découvrez nos réalisations pour vos mariages</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#mourningLink">
                        <img src="../assets/img/logo/rip.webp" alt="Deuil">
                        <hr>
                        <h4>Deuil</h4>
                        <p>Découvrez nos réalisations pour accompagner vos périodes de deuil</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="magasinPicture2">
        </div>

        <div class="othersActivity">
            <div class="wrapImg">
                <a href="./contact.php">
                    <img src="../assets/img/Magasin/couronne.webp" alt="Contact">
                    <h6>Contact</h6>
                </a>
            </div>
            <div class="wrapImg">
                <a href="./partners.php">
                    <img src="../assets/img/Magasin/potager-city-box.webp" alt="Nos partenaires">
                    <h6>Nos partenaires</h6>
                </a>
            </div>
            <div class="wrapImg">
                <a href="./whoIAm.php">
                    <img src="../assets/img/Magasin/carolineDelautre.webp" alt="Qui-suis-je ?">
                    <h6>Qui-suis-je?</h6>
                </a>
            </div>
        </div>
        <hr>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2544.5096726493302!2d3.0634544151514738!3d50.37569680063032!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2cbe3ef9c0247%3A0x1fbe85b0815afbc8!2sDemain%20d%C3%A8s%20l&#39;Aube!5e0!3m2!1sfr!2sfr!4v1650524633544!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="parking">
                <h3>Places de parking gratuit et handicapés </h3>
                <p>Une place handicapés, ainsi que des places de parking gratuit sont à votre disposition juste devant la boutique.</p>
                <div class="wrapImgParking">
                    <img src="../assets/img/logo/parking.webp" alt="">
                    <img src="../assets/img/logo/fauteuil-roulant.webp" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("../templates/footer.php");
?>