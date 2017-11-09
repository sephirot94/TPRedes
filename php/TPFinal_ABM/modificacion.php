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
echo "<li>id de alumno= " . $_GET['ID'];
echo "<li>nombre= " . $_GET['nombre'];
echo "<li>Apellido= " . $_GET['apellido'];
echo "<li>DNI= " . $_GET['DNI'];
echo "<li>Fecha de Nacimiento= " . $_GET['FechaNac'];
echo "<li>Aprobado= " . $_GET['aprobado'];
echo "</ul>";


//Carga datos recibidos en variables
$id=$_GET['ID'];
$nombre=$_GET['nombre'];
$apellido=$_GET['apellido'];
$dni=$_GET['DNI'];
$aprobado=$_GET['aprobado'];
$fechaNac=$_GET['FechaNac'];

$sql= "update alumnos set apellido='$apellido', nombre='$nombre', DNI='$dni', aprobado='$aprobado', FechaNac='$fechaNac' where ID='$id';";

$resultado = $conn->query($sql);

if ($resultado) {
	echo "<h5>Base de datos actualizada correctamente</h5>";
}

mysqli_close($conn);

?>
<br />
<button onClick="location.href='./index.php'">Volver</button>

</div>
</center>
</body>
</html>


