<?php
include("../ctes.inc");
$mysqli = new mysqli(SERVER,USUARIO,PASS,BD);
if($mysqli->connect_errno) {
    echo "error";
}
$idArticulo = $_POST['idArticulo'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$um = $_POST['um'];
$fvenc = $_POST['fvenc'];
$stock = $_POST['stock'];
$query = "update articulos set Descrip='$descripcion',idCategoria='$categoria',um='$um',fechaVenc='$fvenc',Stock='$stock' where idArticulo='$idArticulo';";
if($mysqli->query($query)) echo "<h1>Registro actualizado correctamente!";
else echo "Error ".$mysqli->error;
$mysqli->close();
?>
<br/><button onClick="location.href='./index.php'">Volver</button>