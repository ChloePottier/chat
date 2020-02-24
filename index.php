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
                <div class="question d-flex">
                    <img src="img-chloe2.png" alt="miniature" width="30" height="30">    
                    <p class="affichage-question"></p>  
                </div>
                <div class="reponse-visiteur d-flex">
                    <img src="img-visiteur.png" alt="miniature" width="30" height="30">    
                    <p class="affichage-reponse"></p>  
                </div>
            </div>
            <div class="input-visiteur">
                    <form action="" method="post">
                        <input type="text" placeholder="votre réponse">
                        <button type="submit">Envoyer</button>
                    </form>
                    <div class="clear"></div>
             </div>
        </div>
    </div>
</body>
</html>