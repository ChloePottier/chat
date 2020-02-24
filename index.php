<?php
$userBdd ='root';
$pass ='';
//Connexion à la BDD en PDO
try {
    $dbh = new PDO('mysql:host=localhost;dbname=chat', $userBdd, $pass);
    // print 'connexion bdd ok'; //juste pour voir si il se connecte correctement
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Création d'un chat ligne avec réponse en temps réel après envoie de la réponse (bouton submit). ">
    <link rel="stylesheet" href="style.css">
    <title>Chat en ligne</title>
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <div class="header-container d-flex">
                <img src="img-chloe.png" alt="img-chloe" class="" width="60" height="60">
                <h1>Chat en ligne</h1>
            </div>
            <div class="zone-chat">
                <?php $sqlChat ="SELECT * FROM discussion WHERE id = 1;";
                        $reqChat = $dbh->query($sqlChat);
                        while($resChat=$reqChat->fetch(PDO::FETCH_ASSOC)){
                    ?>
                <div class="question" id="question">
                   
                    <img src="img-chloe2.png" alt="miniature" width="30" height="30" class="float-left">    
                    <p class="affichage-question float-left d-fle">
                        <!-- Questions : via BDD -->
                        <?php
                            echo $resChat['question'];
                            echo" <br /></p>                        
                                <div class='clear'></div> 
                                </div>";
                        };//fin de la boucle
            ?> 
                <div class="reponse-visiteur d-flex" id="rep-visiteur">
                    <img src="img-visiteur.png" alt="miniature" width="30" height="30">    
                    <p class="affichage-reponse">
                            <?php
                            include 'functions.php';
                            echo $GLOBALS['reponse-visiteur'];
                            ?>
                    </p>  
                </div>
            </div>
            <div class="input-visiteur">
                    <form action="" method="GET">
                        <input type="text" name="reponse-visiteur" placeholder="votre réponse">
                        <button type="submit" onclick="reponseVisiteur()">Envoyer</button>
                    </form>
                    <div class="clear"></div>
             </div>
        </div>
    </div>

    <script>
function reponseVisiteur() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("rep-visiteur").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "functions.php", true);
  xhttp.send();
}
</script>
</body>
</html>