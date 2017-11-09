<?php
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}

$sql = "select * from aprobados";
$resultado = $mysqli->query($sql);
if($resultado){
    while($row = $resultado->fetch_object()) {
        $miArray[] = $row;
    }
    $jsonArray = json_encode($miArray);
    $miJSON = '{"aprobados":' . $jsonArray . '}';
}
echo $miJSON
?>