<?php
include("../TPFinal_Sesion/ingresoalsistema.php")
$respuestaAprobados = "../jsonAprobados.php";

$respuestaAlumnos = "../jsonAlumnos.php";
// echo '<pre>';
// var_dump($respuestaAlumnos);
// echo '</pre>';
// die;
// orden default:
$orden="ID";

include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}


$sqlAlumnos = "select * from alumnos where Nombre like '%" . $filtroNombre . "%' and Apellido like '%" . $filtroApellido . "%' and DNI like '%" . $filtroDNI . "%' order by " . $orden;

$sqlAprobados = "select * from aprobados";

$resultadoAlumnos = $conn->query($sqlAlumnos);

$resultadoAprobados = $conn->query($sqlAprobados);

$cantidadAlumnos = $resultadoAlumnos->num_rows; 

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

tr {
background-color: #f2f2a2
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

<header>
<h1>ABMs</h1>
</header>

<div class="parte">
Orden: <input type="text" name="orden" id="orden" value="<?php echo $orden?>">
</div>
<div class="parte">
<button id="cmdFiltrar">
Aplicar filtro
</button>
</div>
<div class="parte">
<button id="cmdLimpiaFiltros">
Limpiar filtros
</button>
</div>
<div class="limpiaFloats"></div>
<p><a href='./destruirsesion.php'><h2>Cerrar sesion</h2></a></p>

<table>
<thead>

<colgroup>
<col id="ID" >
<col id="nombre" >
<col id="apellido" >
<col id="DNI" >
<col id="FechaNac" >
<col id="aprobado" >
</colgroup>  

<th id="thId">ID de Alumno</th><th id="thNombre">Nombre</th><th id="thApellido">Apellido</th><th id="thDNI">DNI</th><th id="thFechaNac">Fecha de Nacimiento</th><th id="thAprobado">Aprobado</th><th id="thEdicion" style="width:50px">Modificacion</th><th id="thBajas" style="width:50px">Baja</th>

<tr>
<td></td><td><input type="text" id="f_nombre" name="f_nombre"</td><td><input type="text" id="f_apellido" name="f_apellido"></input></td><td><input type="text" id="f_DNI" name="f_DNI"></input></td><td><select id="f_FechaNac" name="f_FechaNac"><option></option></select></td>
</tr>



</thead>
<tbody id="tbDatos">	
</tbody>
</table>
<footer>
<h1>Cantidad de Alumnos: <?php echo $cantidadAlumnos; ?></h1>
</footer>

<script>

objTabla = document.getElementById("miTabla");
objTbDatos=document.getElementById("tbDatos");

function llenaAprobados() {
			
			var objAjax = $.ajax({
			type:"get", 
			url: "../jsonAprobados.php",
			success: function(respuestaDelServer,estado) {  
						// var objF_apellido = document.getElementById("f_Apellido");
						listaDeObjetos = JSON.parse(respuestaDelServer);
						listaDeObjetos.aprobados.forEach(function(argValor,argIndice) { 
							var objOption= document.createElement("option");
							objOption.setAttribute("value", argValor.ID);
							objOption.innerHTML=argValor.ID + argValor.Aprobado;
							
						});
						
			} 
	}); 
}

function limpiarFiltros() {
	document.getElementById("f_apellido").value="";
	document.getElementById("f_nombre").value="";
	document.getElementById("f_DNI").value="";
}

function pueblaTabla() {
	$("#tbDatos").empty();

	var objAjax = $.ajax({
			type:"get", 
			url: "../jsonAlumnos.php",
			data: { fapellido: $("#f_apellido").val(), fnombre:$("#f_nombre").val(), fDNI: $("#f_DNI").val(), orden: $("#orden").val() },
			success: function(respuestaDelServer,estado) { 
						$("#tbDatos").empty();
						listaDeObjetos = JSON.parse(respuestaDelServer);
						
						// genero las filas:
						var objTbDatos = document.getElementById("tbDatos");
						listaDeObjetos.alumnos.forEach(function(argValor,argIndice) { 
							var objTr= document.createElement("tr");
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.ID;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Nombre;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Apellido;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.DNI;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.FechaNac;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Aprobado;
							objTr.appendChild(objTd);

							/*Nuevo para abm*/
							var objTd=document.createElement("td");
								objTd.innerHTML="<button>M</button>";
								objTd.onclick=function() {
									var cadenaDePaso="?ID="+argValor.ID;
									location.href="./fichaAbm.php"+cadenaDePaso;
								}
								objTr.appendChild(objTd);

								var objTd=document.createElement("td");
								objTd.innerHTML="<button>B</button>";
								objTd.onclick=function() {
									var cadenaDePaso="?ID="+argValor.ID;
									location.href="./baja.php"+cadenaDePaso;
								}
								objTr.appendChild(objTd);

						});
			} 
	});
} 

//Ordenamiento

$(document).ready(function() {
	$("#thId" ).click(function() {
		$("#orden").val("ID"); 
		pueblaTabla();
	});	
}); 

$(document).ready(function() {
	$("#thApellido" ).click(function() {
		$("#orden").val("apellido"); 
		pueblaTabla();
	});	
}); 

$(document).ready(function() {
	$("#thNombre" ).click(function() {
		$("#orden").val("nombre");
		pueblaTabla();
	});
}); 

$(document).ready(function() {
	$("#thDNI" ).click(function() {
		$("#orden").val("DNI");
		pueblaTabla();
	});	
});

$(document).ready(function() {
window.onload = function() {
$("#orden").val("ID");
llenaAprobados();
pueblaTabla();
}
});

//Filtrar
$(document).ready(function() {
	$( "button#cmdFiltrar" ).click(function() {
		pueblaTabla();
	});	
}); 

document.getElementById("cmdLimpiaFiltros").onclick=function() {
limpiarFiltros();	
pueblaTabla();
}

</script>

</body>
</html>

<?php
$conn->close();
?>