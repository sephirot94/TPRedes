<?php
#Carga de variables del modulo

//script de respuesta al evento de click en registro:
$respuestaFicha = "<h1>id: " . $_GET['id'] . "</h1>";
$respuestaAlumnos = "../jsonAlumnos.php"
$respuestaAprobados = "../jsonAprobados.php"
// orden default:
$orden="id";

include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

$sqlAlumnos = "select * from alumnos where Nombre like '%" . $filtroNombres . "%' and Apellido like '%" . $filtroApellido . "%' and DNI like '%" . $filtroDNI . "%' order by " . $orden;

$sqlAprobados = "select * from aprobados";

$resultadoAlumnos = $conn->query($sqlAlumnos); //Devuelve un objeto $resultado

$resultadoAprobados = $conn->query($sqlAprobados);

$cantidadAlumnos = $resultadoAlumnos->num_rows; //devuelve un entero

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
<h1>Listado para ABMs -- Con filtros</h1>
</header>

<div class="parte">
Orden: <input type="text" name="orden" id="orden" readonly value="<?php echo $orden?>">
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


<table>
<thead>

<colgroup>
<col id="id" >
<col id="apellido" >
<col id="nombre" >
<col id="DNI" >
<col id="Aprobado" >
<col id="fechaNac" >
</colgroup>  

<th id="thId">idAlumno</th><th id="thApellido">apellido</th><th id="thNombre">nombre</th><th id="thDNI">DNI</th><th id="thAprobado">Aprobado</th><th id="thFechaNac">Fecha de Nacimiento</th>
<!-- Filtros: -->
<tr>
<td></td><td></td><td><input type="text" id="f_apellido" name="f_apellido"></input></td><td><input type="text" id="f_nombre" name="f_nombre"></input></td><td><select id="f_DNI" name="f_DNI"><option></option></select></td>
</tr>



</thead>
<tbody id="tbDatos">	
</tbody>
</table>
<footer>
<h1>Pie</h1>
<h1>Nro de alumnos: <?php echo $cantidadAlumnos; ?></h1>
</footer>


<script>


//Inicializacion de Variables java script
objTabla = document.getElementById("miTabla");
objTbDatos=document.getElementById("tbDatos");


function llenaAreas() {
			//alert("Aqui");
			var objAjax = $.ajax({
			type:"post", 
			url: "<?php echo $respuestaAprobado ?>",
			//data: { fapellido: $("#f_apellido").val(), fnombres:$("#f_nombre").val(), farea: $("#f_DNI").val(), orden: $("#orden").val() },
			
			success: function(respuestaDelServer,estado) {  //La funcion de callback que se ejecutara cuando el req. sea completado.
						var objf_DNI = document.getElementById("f_DNI");
						listaDeObjetos = JSON.parse(respuestaDelServer);
						listaDeObjetos.aprobados.forEach(function(argValor,argIndice) { 
							var objOption= document.createElement("option");
							objOption.setAttribute("value", argValor.id);
							objOption.innerHTML=argValor.idArea + argValor.aprobado;
							objf_DNI.appendChild(objOption);
							
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
			url: "<?php echo $respuestaAlumnos ?>",
			data: { fapellido: $("#f_apellido").val(), fnombres:$("#f_nombre").val(), farea: $("#f_DNI").val(), orden: $("#orden").val() },
			success: function(respuestaDelServer,estado) {  
						$("#tbDatos").empty();
						
						listaDeObjetos = JSON.parse(respuestaDelServer);

						var objTbDatos = document.getElementById("tbDatos");

						listaDeObjetos.usuarios.forEach(function(argValor,argIndice) {  
							var objTr= document.createElement("tr");
							objTr.onclick=function(){
							var cadenaDePaso="?idUsuario="+argValor.idUsuario;
							location.href="<?php echo $respuestaFicha;?>"+cadenaDePaso;
							} //cierra onclick
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
							objTd.innerHTML=argValor.FNac;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Aprobado;
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
	$("#thNombres" ).click(function() {
		$("#orden").val("nombre");
		pueblaTabla();
	});	
}); 

$(document).ready(function() {
	$("#thArea" ).click(function() {
		$("#orden").val("DNI");
		pueblaTabla();
	});
}); 

$(document).ready(function() {
window.onload = function() {
$("#orden").val("id");
llenaAreas();
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