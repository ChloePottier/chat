<?php
$userBdd ='root';
$pass ='';
try {
    $dbh = new PDO('mysql:host=localhost;dbname=chat', $userBdd, $pass);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
};
if(isset($_GET['texteVisiteur'])){
     echo $_GET['texteVisiteur'] ;
    $reponseVisiteur = $_GET['texteVisiteur'];
    $tab = array(
        'id_message' => '',
        'message_user'=>$reponseVisiteur,
        'date' =>'date("Y-m-d"); ',
        'heure'=>'date( "H:i:s")',
        'id_user' =>'1');
    $sqlAjoutMsg ="INSERT INTO message VALUES(:id_message, :message_user,:date,:heure,:id_user)";
    $reqAjoutMsg = $dbh->prepare($sqlAjoutMsg);
    $reqAjoutMsg ->execute($tab);
    }
// date = NOW();

?>
<p>TEST !!!!
   <?php $_GET['texteVisiteur'] ?>
</p>