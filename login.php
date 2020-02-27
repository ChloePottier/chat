<?php
session_start();
$message="";
//connection à la BDD
try {
	
$connection = new PDO('mysql:host=localhost;dbname=chat', 'root', '');
}
 catch (PDOException $e) {
print "Erreur !: " . $e->getMessage() . "<br/>";
die();
}

// ON VERIFIE QU'IL Y AI AU MOINS UN POSTE REMPLI SINON ON VA AVOIR UNE ERREUR DE VARIABLE NON DEFINIE
if(count($_POST)>0) {
		
// JE CREE MA REQUETTE
$sql="SELECT * FROM user WHERE pseudo='" . $_POST["user_name"] . "' and password = '". $_POST["password"]."'";

// ON L'EXECUTE
$req = $connection->query($sql);
// ON SAUVEGARDE LES RESULTAT DANS UN TABLEAU
$row=$req->fetch(PDO::FETCH_ASSOC);

// ON VERIFIE ET EFFECTUE L'ACTION SI C'EST UN TABLEAU
if(is_array($row)) {
	// ON CREE NOS VARIABLE DE SESSION
	$_SESSION["id"] = $row['id'];
	$_SESSION["name"] = $row['pseudo'];
	} 
		else {
		echo  "<p class='text-center'>Identifiant ou mot de passe invalide</p>";
		}
}
$connection = null;
//SI LA SESSION EST REMPLI ALORS ON REDIRIGE
if(isset($_SESSION["id"])) {
header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Création d'un chat ligne avec réponse en temps réel après envoie de la réponse (bouton submit). ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Chat en ligne - login</title>
</head>
<body>
  <div class="container-fluid">
    <div class="container" id="formContent">
      <!-- Tabs Titles -->
      <p class="mt-20 text-center text-white">Merci de vous identifier pour accéder à notre site</p>
      <!-- Login Form -->
      <form method="post" class="d-flex flex-column mx-auto mt-20" id=formConnection>
        <input type="text" id="login" class="d-flex mb-5" name="user_name" placeholder="Identifiant">
        <input type="password" id="password" class="d-flex mb-5" name="password" placeholder="Mot de passe">
        <input type="submit" class="d-flex text-white" value="Connexion" id="btnConnexion">
      </form>
    </div>
  </div>
</body>
</html>



