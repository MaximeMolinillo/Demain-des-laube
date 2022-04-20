<?php

include("templates/header.php");




$db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");


$query = $db->query("SELECT * FROM photos");
$photos = $query->fetchAll();



?>



<section>
    <?php
    foreach ($photos as $photo) {
    ?>
        <div class="pic">
            <div class="pictures">
                <img src="<?= $photo["picture"] ?>" alt=" <?= $photo["title"] ?>">
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

    <div class="products">
        <h2>Nos Productions</h2>
        <h3>Tout nos produits sont 100% fait maison</h3>
        <div class="underline"></div>
        <div class="wrapProducts">
            <div class="flowers">
                <a href="">
                    <img src="./assets/img/logo/bouquet-de-fleurs.png" alt="Bouquet de fleurs">
                    <h4>Fleurs et bouquets</h4>
                    <p>Fleurs, bouquets, compositions...Découvrez nos diverses créations florales</p>
                </a>
            </div>
            <div class="deco">
                <a href="">
                    <img src="./assets/img/logo/decoratif.png" alt="Décorations">
                    <h4>Décorations</h4>
                    <p>Voici nos décorations florale ou pas</p>
                </a>
            </div>
            <div class="jewels">
                <a href="">
                    <img src="./assets/img/logo/collier.png" alt="Bijoux">
                    <h4>Bijoux</h4>
                    <p>Notre gamme de bijoux</p>
                </a>
            </div>
            <div class="event">
                <a href="">
                    <img src="./assets/img/logo/groupe.png" alt="Evennementiel">
                    <h4>Evennementiel</h4>
                    <p>Découvrez nos réalisations, pour vos mariages, entérrements...</p>
                </a>
            </div>
        </div>
    </div>

    <div class="magasinPicture2">
    </div>
    <div class="othersActivity">
        <div class="contact">
            <a href="">
                <img src="./assets/img/Magasin/fleurContact.png" alt="Contact">
                <h6>Contact</h6>
            </a>
        </div>
        <div class="partners">
            <a href="./partners.php">
                <img src="./assets/img/Magasin/potager-city-box.png" alt="Nos partenaires">
                <h6>Nos partenaires</h6>
            </a>
        </div>
        <div class="whoIAm">
            <a href="./whoIAm.php">
                <img src="./assets/img/Magasin/carolineDelautre.png" alt="Qui-suis-je ?">
                <h6>Qui-sui-je?</h6>
            </a>
        </div>
    </div>
</section>




<?php
include("templates/footer.php");

?>