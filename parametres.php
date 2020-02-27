<?php session_start();  ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Création d'un chat ligne avec réponse en temps réel après envoie de la réponse (bouton submit). ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Chat en ligne - login</title>
</head>

<body>
    <div class="container-fluid">
        <div class="container" id="formContent">
            <div class="header-container d-flex">
                <a href="index.php" class="bullesMsg"></a>
                <h1 class="text-white">Chat en ligne</h1> <a href="logout.php" class="my-auto deconnection">
                </a>
            </div>
            <?php
                $userBdd = 'root';
                $pass = '';
                //Connexion à la BDD en PDO
                try {
                    $dbh = new PDO('mysql:host=localhost;dbname=chat', $userBdd, $pass);
                    // print 'connexion bdd ok'; //juste pour voir si il se connecte correctement

                } catch (PDOException $e) {
                    print "Erreur !: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sqlProfil = "SELECT * FROM user ";
                $reqProfil = $dbh->query($sqlProfil);
                // ON SAUVEGARDE LES RESULTAT DANS UN TABLEAU
                $resProfil = $reqProfil->fetch(PDO::FETCH_ASSOC);
                ?>
            <div class="setProfil ">
                <div class="d-flex flex-row justify-content-center"><a href="" class="my-auto " title="Modifier photo de profil"><img src="<?php echo $resProfil['img_user']; ?>" alt="img profil" title="modifier" width="30" height="30" ></a>
                    <h2 class="text-center text-white ">Profil de <?php echo $resProfil['pseudo']; ?></h2>
                    <!--Pseudo-->
                </div>
                <form action="" method="POST" class="modifPseudo mt-20">
                    <div class="labelContainer"> <label for="pseudo" class="text-white widthLabel">Pseudo :</label></div>
                    <input type="text" id="pseudo" name="pseudo" placeholder="<?php echo $resProfil['pseudo']; ?>">
                    <button type="submit" class="btnModif text-white">Modifier</button>
                </form>
                <form action="" method="POST" class="modifPwd mt-20">
                    <div class="labelContainer"> <label for="pwd" class="text-white widthLabel">Mot de passe :</label></div>
                    <input type="password" id="pwd" name="pwd" placeholder="*********">
                    <!--Comparer les 2 mots de passe-->
                    <input type="password" id="pseudoVerif" name="pseudoVerif" placeholder="confirmation du password">
                    <button type="submit" class="btnModif text-white">Modifier</button>
                </form>
                <form action="" method="POST" class="modifEmail mt-20">
                    <div class="labelContainer"><label for="email" class="text-white widthLabel">E-mail :</label></div>
                    <input type="email" id="email" name="pwd" placeholder="<?php echo $resProfil['email']; ?>">
                    <!--Comparer les 2 mots de passe-->
                    <input type="email" id="emailVerif" name="emailVerif" placeholder="confirmation de l'e-mail">
                    <button type="submit" class="btnModif text-white">Modifier</button>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
<?php 
    $profilId = $resProfil['id'];
    if (!empty($_POST['pseudo'])){
        $pseudo = $_POST['pseudo'];
    $tab = array(
        'id' => '',
        'pseudo' => $pseudo,
        'password' => '',
        'email' => '',
        'img_user' => '');
        $sqlPseudo = "SELECT pseudo FROM user";
        $reqPseudo = $dbh->query($sqlPseudo);
            while($resPseudo=$reqPseudo->fetch(PDO::FETCH_ASSOC)){
            if($resPseudo['pseudo'] == $pseudo){
                echo "<p class='text-center text-red mt-20'>Le pseudo ".$pseudo." existe déja</p>";
            } else{
                $sqlAjoutPseudo = "UPDATE user SET pseudo='".$pseudo."' WHERE id=1";
                //UPDATE user SET pseudo='Chloe' WHERE id=1
            }
        }
    }
    if (!empty($_POST['email'])){
        $tab = array(
            'id' => '',
            'pseudo' => '',
            'password' => '',
            'email' => $_POST['email'],
            'img_user' => '');
            $sqlEmail = "SELECT email FROM user";
            $reqEmail = $dbh->query($sqlEmail);
                while($resEmail=$reqEmail->fetch(PDO::FETCH_ASSOC)){
                if($resPseudo['pseudo'] == $_POST['email']){
                    echo "<p class='text-center text-red mt-20'>Le pseudo ".$_POST['email']." existe déja</p>";
                } else{
                    $sqlAjoutPseudo = "VALUES(:id, :pseudo, :password, :email,  :img_user)";
                }
            }
        }

?>