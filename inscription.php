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

if (!empty($_POST['pseudo'])  and !empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['pwd-verif'])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $pwd2 = $_POST['pwd-verif'];
    $imgUser = '';
    $tab = array(
        'id' => '',
        'pseudo' => $pseudo,
        'password' => $pwd,
        'email' => $email,
        'img_user' => $imgUser
    );
    $sqlEmail = "SELECT email FROM user";
    $reqEmail = $dbh->prepare($sqlEmail);
    $reqEmail->execute(array($sqlEmail));
    if ($reqEmail == $email) {
        echo "cet email existe déja";
    } else {
        $sqlUser = "SELECT pseudo FROM user";
        $reqUser = $dbh->prepare($sqlUser);
        $reqUser->execute(array($sqlUser));
        if ($reqUser == $pseudo) {
            echo "<p class='text-center'>cet email existe déja</p>";
        } else {
            if ($pwd != $pwd2) {
                echo "<p class='text-center'>Mots de passes différents</p>";
            } else {
                if (strlen($pwd) < 8) {
                    echo "<p class='text-center'>Mot de passe trop court, il faut au moins 8 caractères. Ici votre mot de passe ne contient que " . strlen($pwd) . " caractères</p>";
                } else {
                    // $pwd3 = password_hash($pwd, 20);
                    $sql2 = "INSERT INTO user  VALUES(:id, :pseudo, :password, :email,  :img_user)";
                    $req = $dbh->prepare($sql2);
                    $req->execute($tab);
                    if ($req == true) {
                        // header("Location: index.php");
                        echo "Inscription réussit !";
                        echo '<meta http-equiv="Refresh" content="10;URL=login.php"> ';
                    } else {
                        echo "<p class='text-center '>Inscription impossible</p>";
                    }
                }
            }
        }
    }
} else {
    echo "<p class='text-center'>Merci de renseigner tous les champs</p> ";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>

<body>
    <div class="container-fluid">
        <div class="container">
            <div class="header-container d-flex">
                <a href="index.php" class="bullesMsg"></a>
                <h1 class="text-white">Chat en ligne</h1> <a href="logout.php" class="my-auto deconnection"></a>
            </div>
            <form method="POST" action="" class="d-flex flex-column mx-auto mt-20 inscription text-white">
                <label for="pseudo">Votre pseudo</label>
                <input id="pseudo" name="pseudo" type="text" class="mb-16" required />
                <!-- MOT DE PASSE -->
                <label for="password">Votre mot de passe</label>
                <input id="password" name="password" type="password" class="mb-16" required />
                <!-- MOT DE PASSE VERIFICATION-->
                <label for="password">Vérification du mot de passe</label>
                <input id="pwd-verif" name="pwd-verif" type="password" class="mb-16" required />
                <label for="email">Votre email</label>
                <input id="email" name="email" type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,8}$" class="mb-16" required />
                <button type="submit" value="submit" name="inscription" id="btnInscription" class="text-white">S'inscrire</button>
            </form>
            <!-- Si identifiant existe déja alors mettre un messsage echo "Ce nom d'utilisateur est déjà utilisé.";
            Il faut crypter les passwords
            Mettre une limite :
                - mot de passe : min 10 carac, lettre , chiffre, majuscule. Si trop court : "mot de passe trop court"
                - identifiant : min 6 charac -->
        </div>
    </div>

</body>

</html>