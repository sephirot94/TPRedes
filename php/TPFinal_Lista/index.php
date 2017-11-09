<?php 
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
if (!($conn)) {
	exit("Error de conexión al motor de base de datos");
}

$sqlString="select * from Alumnos";

$resultado=mysqli_query($conn,$sqlString);

$json='{"Alumnos": [';
while($fila=mysqli_fetch_assoc($resultado)) {
	$json=$json . '{';
	$json=$json . '"ID":"' . $fila['ID'] . '",';	
	$json=$json . '"Apellido":"' . $fila['Apellido'] . '",';
	$json=$json . '"Nombre":"' . $fila['Nombre'] . '",';
	$json=$json . '"DNI":"' . $fila['DNI'] . '",';
	$json=$json . '"fechaNac":"' . $fila['FechaNac'] . '"';	
	$json=$json . '},';
}
$json=$json . '{"ID":"FIN", "Apellido":"FIN","Nombre":"FIN","DNI":"FIN","fechaNac":"FIN"}';
$json=$json . ']}';

$cantidadAlumnos = $resultado->num_rows; 
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta charset="utf-8" /> 

<style>

table {
border-style:solid;
border-width:1px;
border-collapse:collapse; 
width:80%; 
margin:auto;
table-layout:fixed;
}

th {
border-style:solid;
border-width:1px;
background-color:blue;
color:white;
}

td {
border-style:solid;
border-width:1px;
overflow: auto;
}

tr{
background-color: lightblue;
}

tr:hover {
background-color: yellow;
cursor:pointer;
}

col#id {
width:10%;
}

col#apellido {
width:15%;	
}

col#nombre {
width:15%;	
}

col#DNI {
width:15%;	
}

col#fechaNac {
width:15%;	
}

</style>

</head>
<body>
<table id="miTabla">

<thead>

<th id="id">ID</th><th id="apellido">Apellido</th><th id="nombres">Nombre</th><th id="DNI">DNI</th><th id="fechaNac">Fecha de Nacimiento</th>
</thead>
<tbody id="datos">	
</tbody>
</table>

<h1>Cantidad de Alumnos: <?php echo $cantidadAlumnos; ?></h1>

<button id="btPoblarTabla">
Poblar tabla
</button>

<button id="btVaciarTabla">
Vacíar tabla
</button>

<script>

objTabla = document.getElementById("miTabla");
objdatos=document.getElementById("datos");

texto='<?php echo $json;?>';

var listaDeObjetos=JSON.parse(texto);

//Funciones
function poblarTabla() {
	
	if(objdatos.childNodes.length<=1) {
		listaDeObjetos.Alumnos.forEach(function(argValor,argIndice) {
		var objTr = document.createElement("tr");
		var objTd=document.createElement("td");
		objTd.innerHTML=argValor.ID;
		objTr.appendChild(objTd);
		var objTd=document.createElement("td");
		objTd.innerHTML=argValor.Apellido;
		objTr.appendChild(objTd);
		var objTd=document.createElement("td");
		objTd.innerHTML=argValor.Nombre;
		objTr.appendChild(objTd);
		var objTd=document.createElement("td");
		objTd.innerHTML=argValor.DNI;
		objTr.appendChild(objTd);
		var objTd=document.createElement("td");
		objTd.innerHTML=argValor.fechaNac;
		objTr.appendChild(objTd);

		objdatos.appendChild(objTr);
		}	
		);
	} 
} 

function vaciaTabla() {
	while(objdatos.childNodes.length!=0){
		objdatos.removeChild(objdatos.firstChild);
	}

}

document.getElementById("btPoblarTabla").onclick = function() {
poblarTabla();
}

document.getElementById("btVaciarTabla").onclick = function() {
vaciaTabla();
}

</script>

</body>
</html>

<?php
$conn->close();
?>