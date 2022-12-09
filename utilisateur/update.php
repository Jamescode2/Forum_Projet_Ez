<?php
session_start();
$erreurnewPseudo = false;
$erreurnewMdp = false;
function isConnect() { 
	if (isset($_SESSION) && isset($_SESSION['loginPostForm']) && isset($_SESSION['passwordPostForm'])) {
		return true;
	}else {
		return false;
	}
}
function secure_donnee($donnee){
    if(ctype_digit($donnee)){
        return intval($donnee);
    }else{
        return addslashes($donnee);
    }
}
if (!isset($_POST)) {
    $erreurnewPseudo = true;
    $erreurnewMdp = true;
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

if (isConnect()) {
    if(isset($_POST['newPseudo']) && $_POST['newPseudo'] != ''){	
        $longueur_chaine = strlen($_POST['newPseudo']);
        if($longueur_chaine < 8 || $longueur_chaine > 15){
            $erreurnewPseudo = true;
            $retour .= '<span style="color:red;">Le newPseudo doit être composé de 8 caractères minimum et ne doit pas dépasser 15 caractères.</span>';
        }
        $exp = "/[a-zA-Z0-9]/";
        if(!preg_match($exp, $_POST['newPseudo'])){
            $erreurnewPseudo = true;
            $retour .= '<span style="color:red;">La newPseudo saisie n\'est pas valide.</span>';
        }
    }
    if(!$erreurnewPseudo && isset($_POST['newPseudo'])){
        $requete = $bdd->prepare( 'UPDATE utilisateurs SET pseudo = :newPseudo WHERE pseudo = :pseudo AND  mdp = :mdp' );
        $requete->bindParam( ':newPseudo', $_POST[ 'newPseudo' ] );
        $requete->bindParam( ':pseudo', $_SESSION['loginPostForm'] );
        $requete->bindParam( ':mdp', $_SESSION['passwordPostForm']);
        $requete->execute();
        $requete->closeCursor();
        $_SESSION['loginPostForm'] = htmlspecialchars(trim(secure_donnee($_POST[ 'newPseudo' ])));
    }
}
if (isConnect()) {
    if(isset($_POST['newMdp']) && $_POST['newMdp'] != ''){	
        $longueur_chaine = strlen($_POST['newMdp']);
        if($longueur_chaine < 8 || $longueur_chaine > 20){
            $erreurnewMdp = true;
            $retour .= '<span style="color:red;">Le newMdp doit être composé de 8 caractères minimum et ne doit pas dépasser 20 caractères.</span>';
        }
        $exp = "/[a-zA-Z0-9]/";
        if(!preg_match($exp, $_POST['newMdp'])){
            $erreurnewMdp = true;
            $retour .= '<span style="color:red;">La newMdp  saisie n\'est pas valide.</span>';
        }
    }
    if(!$erreurnewMdp && isset($_POST['newMdp'])){
        $requete = $bdd->prepare( 'UPDATE utilisateurs SET mdp = :newMdp WHERE pseudo = :pseudo AND mdp = :mdp' );
        $requete->bindParam( ':newMdp', $_POST[ 'newMdp' ] );
        $requete->bindParam( ':pseudo', $_SESSION['loginPostForm'] );
        $requete->bindParam( ':mdp', $_SESSION['passwordPostForm']);
        $requete->execute();
        $requete->closeCursor();
        $_SESSION['passwordPostForm'] = htmlspecialchars(secure_donnee($_POST[ 'newMdp' ]));

    }
}

header( 'Location:../accueil.php' )
?>