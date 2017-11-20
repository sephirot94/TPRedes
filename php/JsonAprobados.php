<?php
session_start();
if (!isset($_SESSION['idSession'])) {
	header('Location: ./ingresoalsistema.php');
}
include("Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
if($conn->connect_errno) {
    echo "error";
}
$sql = "select * from aprobados";
$resultado = $conn->query($sql);
if($resultado){
    while($row = $resultado->fetch_object()) {
        $miArray[] = $row;
    }
    $jsonArray = json_encode($miArray);
    $miJSON = '{"aprobados":' . $jsonArray . '}';
}
echo $miJSON
?>