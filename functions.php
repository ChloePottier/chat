<?php
session_start();
$userBdd ='root';
$pass ='';
//connexion BDD
try {
    $dbh = new PDO('mysql:host=localhost;dbname=chat', $userBdd, $pass);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
};
if(isset($_POST['message'])){
     echo $_POST['message'] ;
    $idSession = $_SESSION["id"];
    echo $idSession;
    $date =  date('Y-m-d') ;
    $heure = date('H:i:s');
    // $reponseVisiteur = $_POST['texteVisiteur'];
    $reponseVisiteur = $_POST['message'];
    $tab = array(
        'id_message' => '',
        'message_user'=>$reponseVisiteur,
        'date' => $date,
        'heure'=> $heure,
        'id_user' =>$idSession);
    $sqlAjoutMsg ="INSERT INTO message VALUES(:id_message, :message_user,:date,:heure,:id_user)";
    $reqAjoutMsg = $dbh->prepare($sqlAjoutMsg);
    $reqAjoutMsg ->execute($tab);
    }
// date = NOW();

?>
