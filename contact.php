<?php
include("templates/header.php");
?>

<div class="contactPage">
<div class="flowerPicture">

</div>

    <form action="" method="post">
        <h1>Contactez-nous</h1>

<hr>

        <div class="form-group">
            <label for="inputNom">Nom :</label>
            <input type="nom" name="nom" id="inputNom">
        </div>
        <div class="form-group">
            <label for="inputPrenom">Prénom :</label>
            <input type="prenom" name="prenom" id="inputPrenom">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" name="email" id="inputEmail">
        </div>
        <div class="form-group">
            <label for="inputTel">Télephone :</label>
            <input type="tel" name="tel" id="inputTel">
        </div>
        <div class="form-group">
            <label for="inputObjet">Objet :</label>
            <input type="text" name="objet" id="inputObjet">
        </div>
        <div class="form-group">
            <label for="inputMessage">Message :</label>
           <textarea name="message" id="inputMessage" cols="30" rows="10"></textarea>
        </div>

        <input type="submit" class="submit" value="Envoyer">
    </form>



</div>

<?php
include("templates/footer.php");
?>