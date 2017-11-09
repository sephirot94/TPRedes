<!-- Alta.php -->
<?php
include("../Constants.php");
$conn=conn_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}

?>

<html>
<head>
<title>Script de altas</title>
</head>

<body >

<div class="contenedor">

<?php

echo "<h5>Datos recibidos: </h5>"; 
echo "<ul style='text-align:left'>";
echo "<li>ID= " . $_GET['ID'];
echo "<li>Nombre= " . $_GET['nombre'];
echo "<li>Apellido= " . $_GET['apellido'];
echo "<li>DNI= " . $_GET['DNI'];
echo "<li>Fecha Nacimiento= " . $_GET['fNac'];
echo "<li>Aprobado= " . $_GET['Aprobado'];
echo "</ul>";



$ID = $_GET['ID'];
$apellido = $_GET['apellido'];
$nombre = $_GET['nombre'];
$dni = $_GET['DNI'];
$aprobado = $_GET['Aprobado'];
$fechaNac = $_GET['fNac'];

$sql="insert into alumnos (ID,Nombre,Apellido,DNI,Fecha de Nacimiento,Aprobado) values (" .$ID . "," . $nombre . "," . $apellido . "," . $dni . "," . $fechaNac . "," . $aprobado . ");"

$resultado = $conn->query($sql);

if ($resultado) {
	echo "<h5>Base de datos actualizada correctamente</h5>"
}

conn_close($conn);

?>
<br />
<button onClick="location.href='./index.php'">Volver</button>

</div>
</body>
</html>


