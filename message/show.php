<?php
$dbhost = 'localhost';
$dbname = 'forum_users';
$dbuser = 'root';
$dbpass = '';
try {

    $bdd = new PDO( 'mysql:host='.$dbhost.';dbname='.$dbname.'', $dbuser, $dbpass );
} catch( Exception $e ) {
    die( 'Erreur : ' . $e->getMessage() );
}
$sql = 'SELECT * FROM `message` WHERE topic = :topic';
$requete = $bdd->prepare($sql);
$requete->bindParam( ':topic', $_POST['topic'] );
if($requete->execute()){
$all = $requete->fetchAll( PDO::FETCH_ASSOC );
echo json_encode( $all, JSON_PRETTY_PRINT );
}

?>