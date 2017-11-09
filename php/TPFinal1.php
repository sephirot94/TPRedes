<?php
include './Constants.php'
$db=new mysqli("localhost", "grupo3", "invitado3", "grupo3") or die('Could not connect');

$result = $db->query("SELECT * from Alumnos") or die('Could not query');

$json = array();

if(mysql_num_rows($result)){
    $row=mysql_fetch_assoc($result);
while($row=mysql_fetch_row($result)){

    $json['testData'][]=$row;
}
var_dump($json);
die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <button type="text" id="poblar">Poblar</button>
    <button type="text" id="limpiar">Limpiar</button>
    <table>
        <thead>
            <th id="nombre">Nombre</th>
            <th id="apellido">Apellido</th>
            <th id="dni">DNI</th>
            <th id="edad">Edad</th>
            <th id="fecha_nacimiento">Fecha de Nacimiento</th>
            <th id="aprobado">Aprobado</th>
        </thead>
        <tbody id="tbody">
            
        </tbody>
    </table>
</body>
</html>