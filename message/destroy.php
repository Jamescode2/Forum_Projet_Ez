<?php
session_start();
$dbhost = 'localhost';
$dbname = 'forum_users';
$dbuser = 'root';
$dbpass = '';

try {
    $bdd = new PDO( 'mysql:host='.$dbhost.';dbname='.$dbname.'', $dbuser, $dbpass );
} catch( Exception $e ) {
    die( 'Erreur : ' . $e->getMessage() );
}

$id='';
$requete = $bdd->prepare( 'SELECT * FROM message WHERE pseudo=:pseudo AND id=:id' );
$requete->bindParam( ':pseudo',$_SESSION['loginPostForm']);
$requete->bindParam(':id',$_POST[ 'id' ]);
$requete->execute();

while ( $data = $requete->fetch() )
{
    $id = $data[ 'id' ];
}
$requete->closeCursor();

if ( $id == '' )
{
    echo 'Impossible de supprimer les données. Le message de ce membre n\'est pas enregistré dans la base, ou le message n\appartient pas au membre.';
	header("refresh:1;url=../accueil.php");
    $requete->closeCursor();
    }
    else
    {
        $requete=$bdd->prepare('DELETE FROM message WHERE id = :id') or die (print_r($bdd->errorInfo()));
        $requete->bindParam(':id',$id);
        $requete->execute();
        echo 'Les informations concernant le topic de ce membre ont bien été supprimées de la base.';

	    $requete->closeCursor();
}
?>