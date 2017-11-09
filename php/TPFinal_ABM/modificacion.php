<?php
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}

?>
<html>
<head>
<title>Script de modificacion</title>
</head>

<body>
<div class="contenedor">

<?php

echo "<h5>Datos recibidos: </h5>"; 

echo "<ul style='text-align:left'>";
echo "<li>id de Usuario= " . $_GET['ID'];
echo "<li>Login de usuario= " . $_GET['Nombre'];
echo "<li>Apellido= " . $_GET['Apellido'];
echo "<li>Nombres= " . $_GET['DNI'];
echo "<li>Area= " . $_GET['fNac'];
echo "<li>Fecha de Nacimiento= " . $_GET['Aprobado'];
echo "</ul>";


//Carga datos recibidos en variables
$id=$_GET['ID'];
$nombre=$_GET['Nombre'];
$apellido=$_GET['Apellido'];
$dni=$_GET['DNI'];
$aprobado=$_GET['Aprobado'];
$fechaNac=$_GET['fNac'];

$sql= "update alumnos set apellido=" . $apellido . ",Aprobado=" . $aprobado . ",nombre=" . $nombre . ",DNI=" . $dni . ",fechaNac=" . $fechaNac . " where ID=" . $id . ";"

$resultado = $conn->query($sql);

if ($resultado) {
	echo "<h5>Base de datos actualizada correctamente</h5>"
}

conn_close($conn);

?>
<br />
<button onClick="location.href='./index.php'">Volver</button>

</div>
</center>
</body>
</html>


