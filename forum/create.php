<?php
session_start();
$retour = '';
$erreur = false;
function secure_donnee($donnee){
    if(ctype_digit($donnee)){
        return intval($donnee);
    }else{
        return addslashes($donnee);
    }
}
if (!isset($_POST)) {
    $erreur = true;
}
$dbhost = 'localhost';
$dbname = 'forum_users';
$dbuser = 'root';
$dbpass = '';
try {

    $bdd = new PDO( 'mysql:host='.$dbhost.';dbname='.$dbname.'', $dbuser, $dbpass );
} catch( Exception $e ) {
    die( 'Erreur : ' . $e->getMessage() );
}

if(!$erreur){
if (isset($_POST['createTopic']) && $_POST['createTopic'] != '') {
    $longueur_chaine = strlen($_POST['createTopic']);
	if($longueur_chaine <= 8){
		$erreur = true;
		$retour .= "La référence recherchée doit comporter 8 caractères.<br />";
	}
	$exp = "/[a-zA-Z]/";
	if(!preg_match($exp, $_POST['createTopic'])){
		$erreur = true;
		$retour .= "La référence saisie n'est pas valide.<br />";
	}

}else{
	$erreur = true;
	$retour .= "Veuillez renseigner le champ 'Référence recherchée'.<br />";
}
}

if(!$erreur){
    $createTopic = htmlentities(secure_donnee($_POST['createTopic']));
    //verif présence
    $requete = $bdd->prepare("SELECT * FROM topic WHERE topic = :topic");
    $requete->bindParam(":topic", $createTopic);
    $requete->execute();
    foreach($requete->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $retour .= "La référence saisie est déjà utilisée !<br />";
        $erreur = true;
        break;
    }
    
    if ( !$erreur ) {
        //créer topic
        $requete = $bdd->prepare("INSERT INTO topic VALUES(NULL,:pseudo,:topic,NULL)");
        $requete->bindParam( ':topic',  $createTopic);
        $requete->bindParam( ':pseudo',  $_SESSION['loginPostForm']);
        $requete->execute();
        $requete->closeCursor();
    }

}
if ( $retour != '' ) {
    echo '<p>'.$retour.'</p>';
}
header('Location:../index.php');
?>