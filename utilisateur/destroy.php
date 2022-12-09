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
$requete = $bdd->prepare( 'SELECT * FROM utilisateurs WHERE pseudo=:pseudo' );
$requete->bindParam( ':pseudo',$_SESSION['loginPostForm']);
$requete->execute();

while ($data = $requete->fetch())
{
    $id = $data[ 'id' ];
}
$requete->closeCursor();

if ( $id == '' )
{
    echo 'Impossible de supprimer les données. Le nom de ce membre n\'est pas enregistré dans la base.';
}
else
{
    $requete=$bdd->prepare('DELETE FROM utilisateurs WHERE id = :id') or die (print_r($bdd->errorInfo()));
    $requete->bindParam(':id',$id);
    $requete->execute();
    $requete->closeCursor();
    $query=$bdd->prepare('DELETE FROM topic WHERE pseudo=:pseudo') or die (print_r($bdd->errorInfo()));
    $query->bindParam(':pseudo',$_SESSION['loginPostForm']);
    $query->execute();
    $query->closeCursor();
    $ez=$bdd->prepare('DELETE FROM message WHERE pseudo=:pseudo') or die (print_r($bdd->errorInfo()));
    $ez->bindParam(':pseudo',$_SESSION['loginPostForm']);
    $ez->execute();
    $ez->closeCursor();
    echo 'Les informations concernant le nouveau membre ont bien été supprimées de la base.';
}
function deconnect() {
	session_destroy();
	unset($_SESSION);
	header('Location:index.php');
	exit();
}

deconnect();
?>