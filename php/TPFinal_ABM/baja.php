<!--baja.php-->
<?php
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

$id = $_GET['ID'];
?>
<html>
<head>
<title>Script de baja</title>
</head>

<body>

<div class="contenedor">
<?php

		$sql = "delete from alumnos where ID='$id';";

		echo "<br>" . $sql;
		$result = mysqli_query($conn,$sql);
		
		if ($result==1) {
		echo "<h5>Baja realizada correctamente</h5>";
		}
		else {
		echo "<h5>ERROR en la sentencia de Baja</h5>";
		}
		

mysqli_close($conn);

?>

<button onClick="location.href='./index.php'">Volver</button>

</div>

</body>
</html>


