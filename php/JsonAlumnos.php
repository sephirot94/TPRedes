<?php
session_start();
if (!isset($_SESSION['idSession'])) {
	header('Location: ./ingresoalsistema.php');
}
include("Constants.php");
if (isset($_POST['orden'])) { 
	$orden=$_POST['orden'];
}
else {
	$orden="ID";
}

$mysqli = mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if($mysqli->connect_errno) {
    echo "error";
}

if (isset($_POST['fapellido']) || isset($_POST['fDNI']) || isset($_POST['fnombre']) || isset($_POST['fFechaNac']) || isset($_POST['fAprobados'])) {
    $sql="select * from alumnos where apellido like '%" . $_POST['fapellido'] . "%' and DNI like '%" . $_POST['fDNI'] . "%' and nombre like '%" . $_POST['fnombre'] . "%' and FechaNac like '%" . $_POST['fFechaNac'] . "%' and aprobado like '%" . $_POST['fAprobados'] . "%' order by " . $orden;
}
else {
    $sql = "select * from alumnos order by " . $orden;
}

$resultado = $mysqli->query($sql); 

// $cantidadArticulos = $resultado->num_rows;

$miArray = array();
if($resultado){
    while($row = $resultado->fetch_object()) {
        $miArray[] = $row;
    }
    $jsonArray = json_encode($miArray);
    $miJSON = '{"alumnos":' . $jsonArray . '}';
}
echo $miJSON
?>