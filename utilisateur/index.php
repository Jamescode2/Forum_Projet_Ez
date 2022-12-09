<?php
require_once __DIR__.'/Utilisateur.php';
$dbhost = 'localhost';
$dbname = 'forum_users';
$dbuser = 'root';
$dbpass = '';
try {
    $bdd = new PDO( 'mysql:host='.$dbhost.';dbname='.$dbname.'', $dbuser, $dbpass );
} catch( Exception $e ) {
    die( 'Erreur : ' . $e->getMessage() );
}
$sql ='SELECT *FROM utilisateur';

$lignes_utilisateurs = $bdd->query($sql);

if ($lignes_utilisateurs->num_rows > 0) {
            while($row = $lignes_utilisateurs->fetch_assoc()) {
                $utilisateur = new Utilisateur(
                    $row['id'],
                    $row['mail'],
                    $row['pseudo'],
                    $row['mdp']
                );
                $utilisateurs[]=$utilisateur;
            }}

//faire une requête pour remplir le tableau avec des objets
//construits grâce aux résultats de cette requête

echo "<table>\n";
echo "<thead>\n";
echo "<tr>\n";
foreach(['mail','pseudo','mdp'] as $legend){
    echo "<th>${legend}</th>\n";
}
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
foreach($utilisateurs as $utilisateur){
    echo "<tr>\n";
    echo '<td>'.$utilisateur->getMail()."</td>\n";
    echo '<td>'.$utilisateur->getPseudo()."</td>\n";
    echo '<td>'.$utilisateur->getMdp()."</td>\n";
    echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";