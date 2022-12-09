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
//test erreur
if(!$erreur){
    if (isset($_POST['createMessage']) && $_POST['createMessage'] != '') {
        $longueur_chaine = strlen($_POST['createMessage']);
        if($longueur_chaine <= 8 || $longueur_chaine > 256){
            $erreur = true;
            $retour .= "La référence recherchée doit comporter 8 et 256 caractères.<br />";
        }
        $exp = "/[a-zA-Z0-9]/";
        if(!preg_match($exp, $_POST['createMessage'])){
            $erreur = true;
            $retour .= "La référence saisie n'est pas valide.<br />";
        }

    }else{
        $erreur = true;
        $retour .= "Veuillez renseigner le champ 'Référence recherchée'.<br />";
    }
    if (isset($_POST['topicAssocie']) && $_POST['topicAssocie'] != '') {
        $longueur_chaine = strlen($_POST['topicAssocie']);
        if($longueur_chaine <= 8){
            $erreur = true;
            $retour .= "La référence recherchée doit comporter 8 caractères.<br />";
        }
        $exp = "/[a-zA-Z]/";
        if(!preg_match($exp, $_POST['topicAssocie'])){
            $erreur = true;
            $retour .= "La référence saisie n'est pas valide.<br />";
        }

    }else{
        $erreur = true;
        $retour .= "Veuillez renseigner le champ 'Référence recherchée'.<br />";
    }
}

if(!$erreur){
    $createMessage = htmlentities(secure_donnee($_POST['createMessage']));
    echo $createMessage;
    $topicAssocie = htmlentities(secure_donnee($_POST['topicAssocie']));
    $requete = $bdd->prepare("INSERT INTO `message` VALUES(NULL,:pseudo,:msg,:topic,NULL)");
    $requete->bindParam( ':pseudo',  $_SESSION['loginPostForm']);
    $requete->bindParam( ':msg',  $createMessage);
    $requete->bindParam( ':topic',  $topicAssocie);
    $requete->execute();
    $requete->closeCursor();

}
if ( $retour != '' ) {
    echo '<p>'.$retour.'</p>';
}
// header('Location:../index.php');
?>