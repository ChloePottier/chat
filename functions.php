<?php
$userBdd ='root';
$pass ='';
try {
    $dbh = new PDO('mysql:host=localhost;dbname=chat', $userBdd, $pass);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
};
if(isset($_GET['reponseVisiteur'])){
     echo $_GET['reponseVisiteur'] ;
    $reponseVisiteur = $_GET['reponseVisiteur'];
        $tab = array(
            'id' => '',
            'message'=>$reponseVisiteur);
        $sqlAjoutMsg ="INSERT INTO reponsevisiteur VALUES(:id, :message)";
        $reqAjoutMsg = $dbh->prepare($sqlAjoutMsg);
        $reqAjoutMsg ->execute($tab);
    }
// echo $_GET['reponseVisiteur'] ;
?>
