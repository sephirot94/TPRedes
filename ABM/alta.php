<?php
include("../ctes.inc");
$mysqli = new mysqli(SERVER,USUARIO,PASS,BD);
if($mysqli->connect_errno) {
    echo "error";
}
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$um = $_POST['um'];
$fvenc = $_POST['fvenc'];
$stock = $_POST['stock'];
if($mysqli->query("insert into articulos (Descrip, idCategoria, um, fechaVenc, Stock) values('$descripcion','$categoria','$um','$fvenc','$stock')"))
echo "<h1>Articulo dado de alta correctamente!";
else echo "Error ".$mysqli->error;
$mysqli->close();
?>
<br/><button onClick="location.href='./index.php'">Volver</button>