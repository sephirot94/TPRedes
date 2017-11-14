<?php
session_start(); 

if (!isset($_SESSION['idSession'])) { 

	header('Location:./formularioDeLogin.html'); 
	exit; 
}
session_destroy();
header('Location:./formularioDeLogin.html');
die;
?>
