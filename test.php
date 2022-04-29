
                <?php
                 $req = $db->query("SELECT picture FROM photos ");
                 while($photo = $req->fetch()) {
                     echo "<img src='./products/".$photo["picture"]."' width='300px' ><br>"; 
                 }
                ?>



<img src="<?=HOST?>/assets/img/products/<?= !empty($photo["picture"]) ? $photo ["picture"] : "minion.jpg" ?>" alt="">



<img src="/assets/img/products/<?=$$modify = trim(strip_tags($_POST["modify"]));
photo["picture"]?>" alt=" <?= $photo["title"] ?>">

$query = $db->query("SELECT * FROM products ORDER BY id LIMIT 10,32");







