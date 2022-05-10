<?php
include("templates/header.php");
require_once './system/config.php';

// $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
$query = $db->query("SELECT * FROM photos ORDER BY id DESC LIMIT 0,12");
$photos = $query->fetchAll();
?>

<div class="topSection">
    <img src="assets/img/logo/Flower.png" alt="">
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
                    <img src="assets/img/products/<?= $photo['picture'] ?>">
                    <!-- <h1><?= $photo["title"] ?></h1>  -->
                    <!-- <h2><?= $photo["category"] ?></h2> -->
                </div>
            </div>
        <?php
        }
        ?>
        <div class="presentation">
            <h2>Présentation</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi rem quos beatae molestiae provident, dolor veniam quibusdam magni officia suscipit. Amet architecto obcaecati id neque vel explicabo itaque blanditiis similique nostrum! Rerum odit saepe quae, molestiae dolore ducimus nobis omnis autem tempore in corporis nesciunt voluptates! Vel hic assumenda accusamus dignissimos ipsam! Incidunt maiores obcaecati iste atque tempora fuga hic repudiandae ducimus possimus veritatis. Maiores dolorum quo aliquam vel voluptates id expedita, sunt sequi fugiat cumque adipisci quis quasi corporis, hic ipsa tempore quam perferendis a inventore labore incidunt laudantium dolorem at? Voluptas qui obcaecati omnis molestias ullam? Repellendus perferendis, aliquam quia odit repellat laborum vitae corporis in nisi maiores vel eveniet quis est consequatur, illum reprehenderit laboriosam ipsam! Odio minus ex magni et tempore natus saepe inventore, eius dolorum, officiis laborum, magnam commodi. Aliquid pariatur enim, mollitia dolorum sint fugiat quae deserunt magni quam! Aut autem alias reprehenderit culpa illum eveniet facere cumque totam quasi, odit error illo accusantium sunt ratione officia molestias tempora? Repellendus eligendi alias nulla earum accusantium tempora blanditiis? Expedita non eum omnis harum ut nulla odio aliquid beatae qui temporibus architecto porro reiciendis quo necessitatibus, consequatur officia velit atque earum quam dolor vel suscipit repudiandae?</p>
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
                        <img src="./assets/img/logo/bouquet-de-fleurs.png" alt="Bouquet de fleurs">
                        <hr>
                        <h4>Fleurs </h4>
                        <p>Fleurs, bouquets, compositions... Découvrez nos diverses créations florales</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#plantLink">
                        <img src="./assets/img/logo/plante.png" alt="Plante Verte">
                        <hr>
                        <h4>Plantes Vertes</h4>
                        <p>Retrouvez notre sélection de plantes vertes pour égayer votre intérieur</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#decoLink">
                        <img src="./assets/img/logo/decoratif.png" alt="Décorations">
                        <hr>
                        <h4>Décorations</h4>
                        <p>Voici nos décorations florales et artisanales</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#jewelsLink">
                        <img src="./assets/img/logo/collier.png" alt="Bijoux">
                        <hr>
                        <h4>Bijoux</h4>
                        <p>Notre gamme de bijoux faits maison</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#wedingLink">
                        <img src="./assets/img/logo/weding.png" alt="Mariage">
                        <hr>
                        <h4>Mariages</h4>
                        <p>Découvrez nos réalisations pour vos mariages</p>
                    </a>
                </div>
                <div class="prod">
                    <a href="nosProduits.php#mourningLink">
                        <img src="./assets/img/logo/rip.png" alt="Deuil">
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
                    <img src="./assets/img/Magasin/couronne.png" alt="Contact">
                    <h6>Contact</h6>
                </a>
            </div>
            <div class="wrapImg">
                <a href="./partners.php">
                    <img src="./assets/img/Magasin/potager-city-box.png" alt="Nos partenaires">
                    <h6>Nos partenaires</h6>
                </a>
            </div>
            <div class="wrapImg">
                <a href="./whoIAm.php">
                    <img src="./assets/img/Magasin/carolineDelautre.png" alt="Qui-suis-je ?">
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
                    <img src="./assets/img/logo/parking.png" alt="">
                    <img src="./assets/img/logo/fauteuil-roulant.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("templates/footer.php");
?>