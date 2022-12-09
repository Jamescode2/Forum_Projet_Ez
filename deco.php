<?php 
session_start(); 

function deconnect() {
	session_destroy();
	unset($_SESSION);
	header('Location:index.php');
	exit();
}

deconnect();

?>