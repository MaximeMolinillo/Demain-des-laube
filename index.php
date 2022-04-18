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
    <div class="pictures">
        <img src="<?= $photo["picture"] 
      
        ?>" alt="">
    </div>
    <?php

    }
    ?>
    <div class="presentation">
        <h2>Présentation</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi rem quos beatae molestiae provident, dolor veniam quibusdam magni officia suscipit. Amet architecto obcaecati id neque vel explicabo itaque blanditiis similique nostrum! Rerum odit saepe quae, molestiae dolore ducimus nobis omnis autem tempore in corporis nesciunt voluptates! Vel hic assumenda accusamus dignissimos ipsam! Incidunt maiores obcaecati iste atque tempora fuga hic repudiandae ducimus possimus veritatis. Maiores dolorum quo aliquam vel voluptates id expedita, sunt sequi fugiat cumque adipisci quis quasi corporis, hic ipsa tempore quam perferendis a inventore labore incidunt laudantium dolorem at? Voluptas qui obcaecati omnis molestias ullam? Repellendus perferendis, aliquam quia odit repellat laborum vitae corporis in nisi maiores vel eveniet quis est consequatur, illum reprehenderit laboriosam ipsam! Odio minus ex magni et tempore natus saepe inventore, eius dolorum, officiis laborum, magnam commodi. Aliquid pariatur enim, mollitia dolorum sint fugiat quae deserunt magni quam! Aut autem alias reprehenderit culpa illum eveniet facere cumque totam quasi, odit error illo accusantium sunt ratione officia molestias tempora? Repellendus eligendi alias nulla earum accusantium tempora blanditiis? Expedita non eum omnis harum ut nulla odio aliquid beatae qui temporibus architecto porro reiciendis quo necessitatibus, consequatur officia velit atque earum quam dolor vel suscipit repudiandae?</p>
    </div>

    <div class="products">
        <h2>Nos Productions</h2>

    </div>

</section>




<?php
include("templates/footer.php");

?>