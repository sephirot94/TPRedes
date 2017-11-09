<?php
session_start(); 

if (!isset($_SESSION['idSession'])) { 

	header('Location:./formularioDeLogin.html'); 
	exit; 
}
function autenticacion($arg1,$arg2) {

	$loginDeUsuario = $arg1;
	$clave = $arg2;
	$claveEncriptada = sha1(trim($_POST['clave']));

	include("../Constants.php");
	$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	
	if ($conn->connect_errno) {
		echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	}	

	$sql="select * from usuarios where loginDeUsuario='$loginDeUsuario';";
	
	$resultado=mysqli_query($conn,$sql);
	$campos=mysqli_fetch_array($resultado);
		
	if (($campos['loginDeUsuario']==$loginDeUsuario)&&($campos['loginDeUsuario']<>"")) {
		if ($campos['clave']==$claveEncriptada) {
			$Aceptado=true;
		}
		else {
			$Aceptado=false;
		}
	}
	else {
	}

return $Aceptado;
}

function infoDeSesion() {

	echo "<div style='border-style:solid;border-width:thin;padding:10px'>";	
	echo "<h1>Información de Sesión</h1>";
	echo "<h2> Identificativo de sesión: " . $_SESSION['idSession'] . "</h2>";
	echo "<h2> Login de usuario: " . $_SESSION['login'] . "</h2>";
	echo "</div>";
}
session_destroy();
header('Location:./formularioDeLogin.html');
?>
