<?php
session_start();
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=chat', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

if(!empty($_GET['id'])){ // on vérifie que l'id est bien présent et pas vide

    $id = (int) $_GET['id']; // on s'assure que c'est un nombre entier

    // on récupère les messages ayant un id plus grand que celui donné
    $requete = $bdd->prepare('SELECT * FROM message 
    INNER JOIN user
    ON message.id_user = user.id
    WHERE message.id_message>'.$_GET['id'].'
    ORDER BY message.id_message ASC');
    $sessionId =$_SESSION["id"];
    $requete->execute(array("id_message" => $id));
    $messages = null;
    // on inscrit tous les nouveaux messages dans une variable
    while($donnees = $requete->fetch()){
        // $messages .= '<div class="reponse-autres">
        //                 <div class="d-flex"><img src="'.$donnees['img_user'].'" alt="" width="30" height="30" class="">
        //                     <h3 class="mt-auto">'.$donnees['pseudo'].'</h3>
        //                     <span class="mt-auto date-heure"> '.$donnees['date'].' '.$donnees['heure'].' </span>
        //                 </div>
        //                 <p id="'.$donnees['id_message'].'" class="message">'. $donnees['message_user'].'</p><br />
        //             </div>                        
        // <div class="clear"></div>';
        //Si l'id de celui qui envoie le message == id de session alorzs afficher à droite sinon afficher à gauche
        if($donnees['id']!= $sessionId){
            $messages .='<div class="reponse-autres">
                    <div class="d-flex"><img src="'.$donnees['img_user'].'" alt="" width="30" height="30" class="">
                        <h3 class="mt-auto">'.$donnees['pseudo'].'</h3>
                        <span class="mt-auto date-heure"> '.$donnees['date'].' '.$donnees['heure'].' </span>
                    </div>
                    <p id="'.$donnees['id_message'].'" class="message">'. $donnees['message_user'].'</p><br />
                </div>                        
                <div class="clear"></div>';
           } else if($donnees['id']== $sessionId){
            $messages .= '<div class="reponse-idSession text-white" >
                    <div class="d-flex"> <img src="'.$donnees['img_user'].'" alt="" width="30" height="30" class="">
                        <h3 class="mt-auto">'.$donnees['pseudo'].'</h3> <span class="mt-auto date-heure"> '.$donnees['date'].' '.$donnees['heure'].' </span>
                    </div>
                    <p id="'.$donnees['id_message'].'" class="message affichage-reponse">'. $donnees['message_user'].'</p>
                </div>
                <div class="clear"></div>';
           }
    }
    echo $messages; // enfin, on retourne les messages à notre script JS

}

?>
