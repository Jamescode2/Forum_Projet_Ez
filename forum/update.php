<?php
session_start();
$retour = '';
$erreur = false;

function secure_donnee( $donnee ) {
    if ( ctype_digit( $donnee ) ) {
        return intval( $donnee );
    } else {
        return addslashes( $donnee );
    }
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

if ( !$erreur ) {
    if ( isset( $_POST[ 'modifTopic' ] ) && $_POST[ 'modifTopic' ] != '' ) {
        $longueur_chaine = strlen( $_POST[ 'modifTopic' ] );
        if ( $longueur_chaine <= 8 ) {
            $erreur = true;
            $retour .= 'La référence recherchée doit comporter 8 caractères.<br />';
        }
        $exp = '/[a-zA-Z]/';
        if ( !preg_match( $exp, $_POST[ 'modifTopic' ] ) ) {
            $erreur = true;
            $retour .= "La référence saisie n'est pas valide.<br />";
        }

    } else {
        $erreur = true;
        $retour .= "Veuillez renseigner le champ 'Référence recherchée'.<br />";
    }
}

if ( !$erreur ) {
    $modifTopic = htmlentities( secure_donnee( $_POST[ 'modifTopic' ] ) );
    $sql = 'UPDATE topic SET topic = :topic WHERE pseudo = :pseudo AND id= :id';
    $requete = $bdd->prepare( $sql );
    $requete->bindParam( ':topic',  $modifTopic );
    $requete->bindParam( ':pseudo',  $_SESSION[ 'loginPostForm' ] );
    $requete->bindParam( ':id',  $_POST[ 'id' ] );
    if ( $requete->execute() ) {
        $retour .= 'Le topic a été modifier avec succès.<br />';
        header( 'Location:../accueil.php' );
    } else {
        $retour .= 'Une erreur est apparue lors de la modification du topic.<br />';
        header( 'Location:../accueil.php' );
    }
    $requete->closeCursor();
}

if ( $retour != '' ) {
    echo '<p>'.$retour.'</p>';
}

?>