<?php

//http://localhost/monsite/index.php?ressource=utilisateur&action=show

if(!isset($_GET['ressource'])){
	$ressource = false;
	$action = 'accueil';	
}else{
	$ressource = $_GET['ressource'];
	$action = $_GET['action'];
}

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'forum_users';
$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$connection->set_charset('utf8');

echo "<!Doctype html>
<html>\n
<head>\n
<title>Forum</title>\n
<meta charset=\"utf8\">\n
</head>\n
<body>\n
";

switch ($action) {
	case 'accueil':
		include 'accueil.php';
		break;
	
	case 'show':
		include $ressource.'/'.'show.php';
		break;

	case 'index':
		include $ressource.'/'.'index.php';
		break;

	case 'create':
		include $ressource.'/'.'create.php';
		break;

	case 'edit':
		include $ressource.'/'.'edit.php';
		break;

	case 'store':
		include $ressource.'/'.'store.php';
		break;

	case 'update':
		include $ressource.'/'.'update.php';
		break;

	case 'destroy':
		include $ressource.'/'.'destroy.php';
		break;

	
	default:
		echo 'OUPS!';
		break;
}

echo "</body>\n
</html>";