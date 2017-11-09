<?php
include("../ctes.inc");
$mysqli = new mysqli(SERVER,USUARIO,PASS,BD);
if($mysqli->connect_errno) {
    echo "error";
}
$idArticulo = $_GET['idArticulo'];
if($mysqli->query("delete from articulos where idArticulo='$idArticulo'")) echo "<h1>Registro borrado correctamente!";
else echo "Error ".$mysqli->error;
$mysqli->close();
?>
<br/><button onClick="location.href='./index.php'">Volver</button>