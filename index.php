<?php
session_start();
$userBdd ='root';
$pass ='';
//Connexion à la BDD en PDO
try {
    $dbh = new PDO('mysql:host=localhost;dbname=chat', $userBdd, $pass);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
};
if(!isset($_SESSION["id"])) {
    header("Location:login.php");
    }

    // header("Location:index.php?#basZoneChat");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Création d'un chat ligne avec réponse en temps réel après envoie de la réponse (bouton submit). ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Chat en ligne</title>
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <div class="header-container d-flex">
                <!-- <img src="img-chloe.png" alt="img-chloe" class="" width="60" height="60"> -->
                <h1 class="text-white">Chat en ligne</h1> <a href="logout.php"><img src="img/deconnection.svg" class="my-auto" alt="déconnexion" width="40" height="40"></a>
            </div>
            <div class="zone-chat" id="messages">
            <div class="question">
                    <div class="affichage-question ">
                    <?php  
                   $sessionId =$_SESSION["id"];
                    $sqlChat ="SELECT * FROM message 
                    INNER JOIN user
                    ON message.id_user = user.id
                    ORDER BY message.id_message ASC ";
                        $reqChat = $dbh->query($sqlChat);
                        while($resChat=$reqChat->fetch(PDO::FETCH_ASSOC)){
                           if($resChat['id']!= $sessionId){
                            echo'<div class="reponse-autres">
                                    <div class="d-flex"><img src="'.$resChat['img_user'].'" alt="" width="30" height="30" class="">
                                        <h3 class="mt-auto">'.$resChat['pseudo'].'</h3>
                                        <span class="mt-auto date-heure"> '.$resChat['date'].' '.$resChat['heure'].' </span>
                                    </div>
                                    <p id="'.$resChat['id_message'].'" class="message">'. $resChat['message_user'].'</p><br />
                                </div>                        
                                <div class="clear"></div>';
                           } else if($resChat['id']== $sessionId){
                            echo '<div class="reponse-idSession text-white" >
                                    <div class="d-flex"> <img src="'.$resChat['img_user'].'" alt="" width="30" height="30" class="">
                                        <h3 class="mt-auto">'.$resChat['pseudo'].'</h3> <span class="mt-auto date-heure"> '.$resChat['date'].' '.$resChat['heure'].' </span>
                                    </div>
                                    <p id="'.$resChat['id_message'].'" class="message affichage-reponse">'. $resChat['message_user'].'</p>
                                </div>
                                <div class="clear"></div>';
                           }

                        };//fin de la boucle
                        ?> 
                        <div id="basZoneChat"></div>
                    </div> 
                </div>
            </div><!--fin zone de chat-->
            <div class="input-visiteur">
                    <form action="functions.php" method="POST" id="myForm" class="">
                        <div class="d-flex justify-content-end">
                        <?php if(isset($_SESSION["name"])) {
                        $valeurchamp = $_SESSION["name"];
                        $valeurchampId = $_SESSION["id"];
                        echo "<span class='utilisateurDit text-white'>". $valeurchamp." dit : </span>";
                    } else {
                        $valeurchamp = "";
                        $valeurchampId = "";
                    } ?>
                        <input hidden type="text" name="pseudo" id="pseudo" value="<?php echo $valeurchamp; ?>" disabled="disabled" /><br />
                        <input hidden type="text" name="identifiant" id="identifiant" value="<?php echo $valeurchampId; ?>"/><br />
                        <textarea type="text" name="message" id="message" placeholder=" votre message"></textarea>
                        </div>
                        <button type="submit" name="submit" id="envoi" class="float-right text-white">Envoyer</button> 
                        <!-- <textarea type="text" name="texteVisiteur" placeholder="votre message"></textarea> -->
                        <!-- <button type="submit" name="submit" onclick="reponseVisiteur()">Envoyer</button>  -->
                        <div class="clear"></div>
                    </form>
                    <!-- <div class="clear"></div> -->
                </div>
        </div>
    </div>

    <script>
        //mafonction Ajax fonctionne, mais n'est pas terminée
// function reponseVisiteur() {
//     //desactiver le rechargeement de la page, mais n'envoie plus les paramètres à functions.php, c'est ajax qui as les données
//     event.preventDefault("submit");
//     var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//         document.getElementById("rep-visiteur").innerHTML = this.responseText;
//         };
//     };
//     xhttp.open("GET", "functions.php", true);
//     xhttp.send();
//     console.log(document.getElementById("rep-visiteur"));
//     //effacer ce qui est dans textarea après envoie
//     document.querySelector('textarea').value = '';
// };
//Scroll en bas de la zone de chat
element = document.getElementById('messages');
element.scrollTop = element.scrollHeight;
//JQUERY !!!
//fonction en envoie message à ajax et à la page de taitement
$('#envoi').click(function(e){
    e.preventDefault(); // on empêche le bouton d'envoyer le formulaire
    element = document.getElementById('messages');
    element.scrollTop = element.scrollHeight;  
    var pseudo = encodeURIComponent( $('#pseudo').val() ); // on sécurise les données
    var message = encodeURIComponent( $('#message').val() );
    var identifiant = encodeURIComponent( $('#identifiant').val() );

    if(pseudo != "" && message != ""){ // on vérifie que les variables ne sont pas vides
        $.ajax({
            url : "functions.php", // on donne l'URL du fichier de traitement
            type : "POST", // la requête est de type POST
            data : "pseudo=" + pseudo + "&message=" + message + "&id_user=" + identifiant // et on envoie nos données
        });
        document.querySelector('textarea').value = '';
    //    $('#messages').append("<p>" + pseudo + " dit : " + message + "</p>"); // on ajoute le message dans la zone prévue
    }
});

function charger(){
    setTimeout( function(){
        //quand un message arrive, la fenêtre descent automatiquement au dernier message

        var premierID = $('#messages p:last').attr('id'); // on récupère l'id le plus récent, donc le dernier de tous mes p générés
		//alert (premierID);
        $.ajax({
            url : "charger.php?id=" + premierID, // on passe l'id le plus récent au fichier de chargement
            type : "GET",
            success : function(html){
                $('#messages').append(html); //append permet d'inséré le nouvelle enregistrement après le dernier
            }
        });
        //effacer ce qui est dans textarea après envoie
        charger();
    }, 100);// les messages se rechargent toutes les 100 millisecondes
}
charger();
</script>

</body>
</html>