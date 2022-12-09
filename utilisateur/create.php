<?php
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


if(isset($_POST['pseudo']) && $_POST['pseudo'] != ''){	
    $longueur_chaine = strlen($_POST['pseudo']);
    if($longueur_chaine < 8 || $longueur_chaine > 15){
        $erreur = true;
        $retour .= '<span style="color:red;">Le pseudo doit être composé de 8 caractères minimum et ne doit pas dépasser 15 caractères.</span>';
    }
    $exp = "/[a-zA-Z0-9]/";
    if(!preg_match($exp, $_POST['pseudo'])){
        $erreur = true;
        $retour .= '<span style="color:red;">La pseudo saisie n\'est pas valide.</span>';
    }
}
if(isset($_POST['mdp']) && $_POST['mdp'] != ''){	
    $longueur_chaine = strlen($_POST['mdp']);
    if($longueur_chaine < 8 || $longueur_chaine > 20){
        $erreur = true;
        $retour .= '<span style="color:red;">Le mot de passe doit être composé de 8 caractères minimum et ne doit pas dépasser 20 caractères.</span>';
    }
    $exp = "/[a-zA-Z0-9]/";
    if(!preg_match($exp, $_POST['mdp'])){
        $erreur = true;
        $retour .= '<span style="color:red;">La mot de passe  saisie n\'est pas valide.</span>';
    }
}
if(isset($_POST['mail']) && $_POST['mail'] != ''){	
    $longueur_chaine = strlen($_POST['mail']);
    if($longueur_chaine < 12 || $longueur_chaine > 25){
        $erreur = true;
        $retour .= '<span style="color:red;">Le mail doit être composé de 12 caractères minimum et ne doit pas dépasser 20 caractères.</span>';
    }
    $exp = "/[a-zA-Z0-9]+[@]/";
    if(!preg_match($exp, $_POST['mail'])){
        $erreur = true;
        $retour .= '<span style="color:red;">La mail  saisie n\'est pas valide.</span>';
    }
}
if(!$erreur){
    $pseudo = htmlentities(secure_donnee($_POST['pseudo']));
	$mdp = htmlentities(secure_donnee($_POST['mdp']));
	$mail = htmlentities(secure_donnee($_POST['mail']));
    $query = $bdd->prepare( 'SELECT * FROM utilisateurs WHERE pseudo = :pseudo' );
    $query->bindParam( ':pseudo', $_POST[ 'pseudo' ] );
    $query->execute();
    foreach ( $query->fetchAll( PDO::FETCH_ASSOC ) as $row ) {
        $retour .= 'La référence saisie est déjà utilisée !<br />';
        $erreur = true;
        header("refresh:1;url=../accueil.php");
        break;
    }

    if ( !$erreur ) {
        $sql = "INSERT INTO utilisateurs VALUES(NULL,:mail,:pseudo,:mdp,0)";
        $requete = $bdd->prepare( $sql );
        $requete->bindParam( ':mail',  $mail );
        $requete->bindParam( ':pseudo', $pseudo );
        $requete->bindParam( ':mdp', $mdp );
        if ( $requete->execute() ) {
            $retour .= "L'utilisateur a été ajouté avec succès.<br />";
            header("refresh:1;url=../accueil.php");
        } else {
            $retour .= "Un erreur est apparue lors de l'ajout de l'utilisateur.<br />";
            header("refresh:1;url=../accueil.php");
        }
        $requete->closeCursor();
    }
}

if ( $retour != '' ) {
    echo '<p>'.$retour.'</p>';
}

?>