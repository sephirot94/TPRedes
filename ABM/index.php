<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"/>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../estilos.css"/>
    </head>
<script src="../jquery.js"></script>
<?php
include("../ctes.inc");
$orden = "idArticulo";
$mysqli = new mysqli(SERVER,USUARIO,PASS,BD);
if($mysqli->connect_errno) {
    echo "error";
}
$sql = "select * from articulos";
$resultado = $mysqli->query($sql);
$cantidadArticulos = $resultado->num_rows; 
?>

<body>    
    Orden: <input type="text" name="orden" id="orden" readonly value="<?php echo $orden?>">
	<button id="botonAplicarFiltros">Aplicar filtros</button> 
	<button id="botonLimpiarFiltros">Limpiar filtros</button> 	
	<button onClick="location.href='./fichaAlta.php'">ALTA</button>     
    <table id="miTabla">
        <thead>        
        <th id="thIdArticulo">idArticulo</th>
        <th id="thDescripcion">Descripcion</th>
        <th id="thIdCategoria">idCategoria</th>
        <th id="thUm">Unidad de medida</th>
        <th id="thFVenc">Fecha de vencimiento</th>
        <th id="thStock">Stock</th>
		<th>Modif</th>
		<th>Baja</th>
		<tr>
			<td></td>
			<td><input type="text" id="filtroDesc" name="filtroDesc"></input></td>
			<td><select id="filtroCat" name="filtroCat"><option></option></select></td>
			<td><input type="text" id="filtroUM" name="filtroUM"></input></td>
			<td></td><td></td><td></td><td></td>
		</tr>
        </thead>
    <tbody id="tbDatos"></tbody> 
    </table>
<h2>Cantidad de articulos: <?php echo $cantidadArticulos; ?></h2>
</body>
    
<script type="text/javascript">

objTabla = document.getElementById("miTabla");
objTbDatos=document.getElementById("tbDatos");

function cargaTabla() {
    $("#tbDatos").empty();
    var objAjax = $.ajax({
			type:"post", 
			url: "../JsonArticulos.php",
			data: { orden: $("#orden").val(), filtroDescripcion: $("#filtroDesc").val(), filtroCategoria: $("#filtroCat").val(), filtroUM: $("#filtroUM").val() },
			success: function(respuestaDelServer,estado) {  
						$("#tbDatos").empty();
						listaDeObjetos = JSON.parse(respuestaDelServer);						
						var objTbDatos = document.getElementById("tbDatos");
						listaDeObjetos.articulos.forEach(function(argValor,argIndice) {  
							var objTr= document.createElement("tr");						
						    var objTd=document.createElement("td");
							objTd.innerHTML=argValor.idArticulo;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Descrip;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.idCategoria;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.um;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.fechaVenc;
							objTr.appendChild(objTd);
							objTbDatos.appendChild(objTr);
							var objTd=document.createElement("td");
							objTd.innerHTML=argValor.Stock;
							objTr.appendChild(objTd);

							var objTd=document.createElement("td");
								objTd.innerHTML="<button>M</button>";
								objTd.onclick=function() {
									var idArticulo = "?idArticulo=" + argValor.idArticulo;
									location.href = "./fichaModif.php" + idArticulo;
								}
								objTr.appendChild(objTd);

								var objTd=document.createElement("td");
								objTd.innerHTML="<button>B</button>";
								objTd.onclick=function() {
									var idArticulo = "?idArticulo=" + argValor.idArticulo;
									if(confirm("Desea dar de baja el articulo?")) {
										location.href = "./baja.php" + idArticulo;				
									}	
									
								}
								objTr.appendChild(objTd);
					
						});
			} 
	});   
}

function cargarCategorias() {			
			var objAjax = $.ajax({
			type:"post", 
			url: "../JsonCategorias.php",		
			success: function(respuestaDelServer,estado) { 
						var objFiltroCat = document.getElementById("filtroCat");
						listaDeObjetos = JSON.parse(respuestaDelServer);				
						listaDeObjetos.categorias.forEach(function(argValor,argIndice) { 
							var objOption = document.createElement("option");
							objOption.setAttribute("value", argValor.idCategoria);
							objOption.innerHTML = argValor.idCategoria + argValor.Descripcion;
							objFiltroCat.appendChild(objOption);							
						});						
				} 
		}); 
}

function limpiarFiltros() {
	document.getElementById("filtroDesc").value="";
	document.getElementById("filtroCat").value="";
	document.getElementById("filtroUM").value="";
}  

$(document).ready(function() {
	$("#thIdArticulo" ).click(function() {
		$("#orden").val("idArticulo"); 
		cargaTabla();
	});	
});

$(document).ready(function() {
	$("#thDescripcion" ).click(function() {
		$("#orden").val("Descrip"); 
		cargaTabla();
	});	
}); 

$(document).ready(function() {
	$("#thIdCategoria" ).click(function() {
		$("#orden").val("idCategoria"); 
		cargaTabla();
	});	
}); 

$(document).ready(function() {
	$("#thUm" ).click(function() {
		$("#orden").val("um");
		cargaTabla();
	});
}); 

$(document).ready(function() {
	$("#thFVenc" ).click(function() {
		$("#orden").val("fechaVenc");
		cargaTabla();
	});	
}); 

$(document).ready(function() {
	$("#thStock" ).click(function() {
		$("#orden").val("stock");
		cargaTabla();
	});	
}); 

$(document).ready(function() {
window.onload = function() {
$("#orden").val("idArticulo");
cargarCategorias();
cargaTabla();
}
});

$(document).ready(function() {
	$( "button#botonAplicarFiltros" ).click(function() {		
		cargaTabla();
	});
});


$(document).ready(function() {
	$( "button#botonLimpiarFiltros" ).click(function() {
		limpiarFiltros();			
		cargaTabla();
	});
});

</script>
</html>
<?php
$mysqli->close();
?>