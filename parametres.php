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
                <div class="d-flex flex-row justify-content-center"><a href="" class="my-auto " title="Modifier photo de profil"><img src="<?php echo $resProfil['img_user']; ?>" alt="img profil" title="modifier" width="30" height="30"></a>
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
                    <input type="password" id="pwdVerif" name="pwdVerif" placeholder="confirmation du password">
                    <button type="submit" class="btnModif text-white">Modifier</button>
                </form>
                <form action="" method="POST" class="modifEmail mt-20">
                    <div class="labelContainer"><label for="email" class="text-white widthLabel">E-mail :</label></div>
                    <input type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,8}$" placeholder="<?php echo $resProfil['email']; ?>">
                    <!--Comparer les 2 mots de passe-->
                    <input type="email" id="emailVerif" name="emailVerif" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,8}$" placeholder="confirmation de l'e-mail">
                    <button type="submit" class="btnModif text-white">Modifier</button>
                </form>
                <?php
                $profilId = $resProfil['id'];
                //Pseudo
                if (!empty($_POST['pseudo'])) {
                    $pseudo = htmlspecialchars($_POST['pseudo']);
                    $tab = array(
                        'id' => '',
                        'pseudo' => $pseudo,
                        'password' => '',
                        'email' => '',
                        'img_user' => ''
                    );
                    $reqpseudo = $dbh->prepare("SELECT pseudo FROM user WHERE pseudo = ?");
                    $reqpseudo->execute(array($pseudo));
                    $pseudoexist = $reqpseudo->rowCount();
                        if ($pseudoexist > 0) {
                            echo "<p class='text-center text-red mt-20'>Le pseudo " . $pseudo . " existe déja</p>";
                        } else {
                            $sqlModifPseudo = "UPDATE user SET pseudo='" . $pseudo . "' WHERE id=" . $_SESSION['id'] . "";
                            //UPDATE user SET pseudo='Chloe' WHERE id=1
                            $reqModifPseudo = $dbh->prepare($sqlModifPseudo);
                            $reqModifPseudo->execute($tab);
                            if ($reqModifPseudo == true) {
                                // header("Location: index.php");
                                echo "<p class='text-center  text-white mt-20'>Nouveau pseudo enregistré !</p>";
                                die();
                            } else {
                                echo "<p class='text-center  text-red mt-20'>Modification impossible</p>";
                                die();
                            }
                        }
                    
                }
                //password
                if (!empty($_POST['pwd']) && !empty($_POST['pwdVerif'])) {
                    $pwd = $_POST['pwd'];
                    if(strlen($pwd)<8){
                        echo "<p class='text-center text-red mt-20'>Mot de passe trop court, il faut au moins 8 caractères. <br />Votre mot de passe ne contient que ".strlen($pwd)." caractères</p>";
                    }else{
                    if ($pwd != $_POST['pwdVerif']) {
                        echo "<p class='text-center text-red mt-20'>Les mots de passes sont différents !</p>";
                    } else {
                        $tab = array(
                            'id' => '',
                            'pseudo' => '',
                            'password' => $pwd,
                            'email' => '',
                            'img_user' => ''
                        );
                        $sqlModifPwd = "UPDATE user SET password='" . $pwd . "' WHERE id=" . $profilId . "";
                        $reqModifPwd = $dbh->prepare($sqlModifPwd);
                        $reqModifPwd->execute($tab);
                        if ($reqModifPwd == true) {
                            echo "<p class='text-center  text-white mt-20'>Nouveau mot de passe enregistré !</p>";
                            die();
                        } else {
                            echo "<p class='text-center  text-red mt-20'>Modification impossible</p>";
                            die();
                        }
                        }
                    }
                }
                
                // Email
                if (!empty($_POST['email'])) {
                    $email = $_POST['email'];
                    if ($_POST['email'] != $_POST['emailVerif']) {
                        echo "<p class='text-center text-red mt-20'>Les emails sont différents !</p>";
                    } else {
                        $tab = array(
                            'id' => '',
                            'pseudo' => '',
                            'password' => '',
                            'email' => $email,
                            'img_user' => ''
                        );
                    $reqEmail = $dbh->prepare("SELECT email FROM user WHERE email = ?");
                    $reqEmail->execute(array($email));
                    $emailExist = $reqEmail->rowCount();
                        if ($emailExist > 0) {
                                echo "<p class='text-center text-red mt-20'>Le mail " . $email . " existe déja</p>";
                                die();
                            } else {
                                $sqlModifEmail = "UPDATE user SET email='" . $email . "' WHERE id=" . $profilId . "";
                                $reqModifEmail = $dbh->prepare($sqlModifEmail);
                                $reqModifEmail->execute($tab);
                                if ($reqModifEmail == true) {
                                    echo "<p class='text-center  text-white mt-20'>Nouveau email enregistré !</p>";
                                    die();
                                } else {
                                    echo "<p class='text-center  text-red mt-20'>Modification impossible</p>";
                                    die();
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>