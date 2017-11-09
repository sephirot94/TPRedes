<?php
sleep(1);
if (isset($_GET['orden'])) { 
	$orden=$_GET['orden'];
}
else {
	$orden="ID";
}
$filtroApellido=$_GET['apellido'];
$filtroNombre=$_GET['nombre'];
$filtroDNI=$_GET['DNI'];

//DB
include('../Constants.php')
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);


if ($conn->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}


$sql="select * from Alumnos where nombre like '%" . $filtroNombres . "%' and apellido like '%" . $filtroApellido . "%' and DNI like '%" . $filtroDNI . "%' order by " . $orden;

$resultado = $conn->query($sql); 

$cantidadAlumnos = $resultado->num_rows; 

$json_alumnos = '{"alumnos": [';
while($fila=$resultado->fetch_assoc()) {
	$json_alumnos=$json_alumnos . '{';
	$json_alumnos=$json_alumnos . '"ID":"' . $fila['id'] . '",';	
	$json_alumnos=$json_alumnos . '"apellido":"' . $fila['apellido'] . '",';
	$json_alumnos=$json_alumnos . '"nombre":"' . $fila['nombre'] . '",';
	$json_alumnos=$json_alumnos . '"DNI":"' . $fila['DNI'] . '",';
	$json_alumnos=$json_alumnos . '"fechaNac":"' . $fila['fecha_nacimiento'] . '"';	
	$json_alumnos=$json_alumnos . '},';
}
// $json_alumnos=$json_alumnos . '{"idUsuario":"FIN","loginDeUsuario":"FIN","apellido":"FIN","nombres":"FIN","area":"FIN","clave":"FIN","fechaNac":"FIN"}';
$json_alumnos=$json_alumnos . ']}';



?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta charset="utf-8" /> 

<script src="../jquery.js"></script>	


<style>

div.parte {
	float:left;
}

div.limpiaFloats {
	clear:both;
}

table {
border-style:solid;
border-width:1px;
border-collapse:collapse;
width:80%;
margin:auto;
table-layout:fixed;
}

thead {
	background-color:yellow;
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

tr:nth-child(odd) {
background-color: #f2f2a2
}

tr:nth-child(even) {
background-color: #f2f2f2
}

tr:hover {
background-color: #f5f500;
cursor:pointer;
}

col {
width:12%;
}

</style>

</head>
<body>

<table id="miTabla">
<thead>
<div class="parte">
Orden: <input type="text" name="orden" id="orden" readonly value="<?php echo $orden?>">
</div>

<div class="limpiaFloats"></div>
<colgroup>
<col id="id" >
<col id="nombre" >
<col id="apellido" >
<col id="DNI" >
<col id="aprobado" >
<col id="fechaNac" >
</colgroup>  

<th id="thId">id</th><th id="thApellido">apellido</th><th id="thNombre">nombre</th><th id="thDNI">DNI</th><th id="thAprobado">Aprobado</th><th id="thFechaNac">Fecha de Nacimiento</th>
</thead>
<tbody id="datos">	
</tbody>
</table>

<h1>Cantidad de alumnos: <?php echo $cantidadAlumnos; ?></h1>



<script>


objTabla = document.getElementById("miTabla");
objdatos=document.getElementById("datos");


function pueblaTabla() {
	$("#datos").empty(); 

	var objAjax = $.ajax({
			type:"get", 
			url: "<?php echo $url ?>",
			data: { orden: $("#orden").val() },
			
			success: function(respuestaDelServer,estado) {  
						$("#datos").empty();
						
						listaDeObjetos = JSON.parse(respuestaDelServer);
						
						//genero las filas:
						var objdatos = document.getElementById("datos");

						listaDeObjetos.usuarios.forEach(function(argValor,argIndice) {  //creacion filas
							var objTr= document.createElement("tr");
							objTr.onclick=function(){
							var cadenaDePaso="?idUsuario="+argValor.idUsuario;
							location.href="<?php echo $respuestaFicha;?>"+cadenaDePaso;
							} //cierra onclick
							objdatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.id;
							objTr.appendChild(objTd);
							objdatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.nombre;
							objTr.appendChild(objTd);
							objdatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.apellido;
							objTr.appendChild(objTd);
							objdatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.DNI;
							objTr.appendChild(objTd);
							objdatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Aprobado;
							objTr.appendChild(objTd);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.fechaNac;
							objTr.appendChild(objTd);
						});

			} 
	}); 
}

$(document).ready(function() {
	$("#thId" ).click(function() {
		$("#orden").val("id");
		pueblaTabla();
	});	

	$("#thApellido" ).click(function() {
		$("#orden").val("apellido"); 
		pueblaTabla();
	});

	$("#thNombre" ).click(function() {
		$("#orden").val("nombre");
		pueblaTabla();
	});	

	$("#thDNI" ).click(function() {
		$("#orden").val("DNI");
		pueblaTabla();
	});	

	$("#thAprobado" ).click(function() {
		$("#orden").val("aprobado");
		pueblaTabla();
	});	

	$("#thFechaNac" ).click(function() {
		$("#orden").val("fecha_nacimiento");
		pueblaTabla();
	});	
}); 

</script>

</body>
</html>

<?php
$conn->close();
?>