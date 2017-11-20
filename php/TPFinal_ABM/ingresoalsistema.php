<?php
if (!empty($_POST)) {
	$log=$_POST['username'];
	$cl=$_POST['password'];
}

if (!autenticacion($log,$cl)) { 
	
	header('Location: ./formularioDeLogin.html');
	exit;

}

session_start();

echo "<h1>Acceso permitido</h1>";

$_SESSION['idSession'] = session_id();	

$_SESSION['login']=$log;
// var_dump($_SESSION);
// die;
echo "<h2>Sus parametros de sesion son los siguientes: </h2>";
infoDeSesion();

echo "<p><button onClick=\"location.href='./index.php'\">Ingrese a la aplicacion</button><p>";

function autenticacion($arg1,$arg2) {

	$loginDeUsuario = $arg1;
	$clave = $arg2;
	$claveEncriptada = sha1(trim($_POST['password']));

	include("../Constants.php");
	$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	
	if ($conn->connect_errno) {
		echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	}	

	$sql="select * from usuarios where username='$loginDeUsuario';";
	
	$resultado=mysqli_query($conn,$sql);
	$campos=mysqli_fetch_array($resultado);
		
	if (($campos['username']==$loginDeUsuario)&&($campos['username']<>"")) {
		if ($campos['password']==$claveEncriptada) {
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
	echo "<h1>Informacion de Sesion</h1>";
	echo "<h2> Identificativo de sesion: " . $_SESSION['idSession'] . "</h2>";
	echo "<h2> Login de usuario: " . $_SESSION['login'] . "</h2>";
	echo "</div>";
}

?>