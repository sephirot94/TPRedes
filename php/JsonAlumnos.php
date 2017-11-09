<?php
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

if (isset($_POST['filtroApellido']) || isset($_POST['filtroDNI']) || isset($_POST['filtroNombre']))
    $sql="select * from alumnos where apellido like '%" . $_POST['filtroApellido'] . "%' and DNI like '%" . $_POST['filtroDNI'] . "%' and nombre like '%" . $_POST['filtroNombre'] . "%' order by " . $orden;
else
    $sql = "select * from alumnos order by " . $orden;

$resultado = $mysqli->query($sql); 
$cantidadArticulos = $resultado->num_rows;

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