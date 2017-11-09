<?php
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}

#Seleccion de alumnos:
$sqlAlumnos="select * from alumnos where ID=$identificador";

$resultadoAlumnos=mysqli_query($conn,$sqlAlumnos);

$fila=mysqli_fetch_assoc($resultadoAlumnos);

#Lista de Aprobados:
$sqlAprobados="select * from Aprobados";
$resultadoAprobados=mysqli_query($conn,$sqlAprobados);

?>

<html>
<head>
<title>Formulario para modificaciones</title>

<script>
/*Funciones*/

function inicio() {
	document.getElementById("ID").readOnly=true;
	document.getElementById("DNI").disabled=true; 
	document.getElementById('btModificar').disabled=true;
	document.getElementById('btReset').disabled=false;
}

function todoListo() {
	if(objApellido.checkValidity()&&objNombre.checkValidity()){
	document.getElementById("btModificar").disabled=false;
	document.getElementById("btReset").disabled=false;
	}
	else if((objApellido.value!="")||(objNombre.value!="")) {
	document.getElementById("btModificar").disabled=true;
	document.getElementById("btReset").disabled=false;
	}
	else {
	document.getElementById("btModificar").disabled=true;
	document.getElementById("btReset").disabled=true;
	}
}

function blanquear() {
	if(confirm("¿Esta seguro de blanquear?")) {
		document.getElementById("apellido").value="";
		document.getElementById("nombre").value="";
		document.getElementById("DNI").focus();
		document.getElementById("btModificar").disabled=true;
		document.getElementById("btReset").disabled=true;
	}
}

function modificacion() {
if(confirm("¿Está seguro de modificar registro?")) {
document.getElementById("fAbm").action='modificacion.php';
document.getElementById("fAbm").submit();
}
}

</script>

</head>

<body onLoad="inicio()">

<div class="ficha">

<h1>Modificaciones de usuario</h1>

<form id="fAbm" action="" method="get"> 
<table>
<tr>
<td>ID de Alumno: </td><td><input type="text" id="ID" name="ID" value="<?php echo $fila['ID']; ?>" required></input></td>
</tr>

<tr>
<td>nombre: </td><td><input type="text" id="nombre" name="nombre"  value="<?php echo $fila['nombre']; ?>" required></input></td>
</tr>

<tr>
<td>Apellido: </td><td><input type="text" id="apellido" name="apellido"  value="<?php echo $fila['apellido']; ?>" required></input></td>
</tr>

<tr>
<td>
Aprobado: 
</td>
<td>
<select id="aprobado" name="aprobado">
<?php
while($filaAprobado=mysqli_fetch_assoc($resultadoAprobados)) {
if ($filaAprobado['ID']==$fila['aprobado']) {
echo "<option value='" . $filaAprobado['ID'] . "' selected='selected'>" . $filaAprobado['ID'] . "&nbsp;" . $filaAprobado['aprobado'] . "</option>";
}
else {
echo "<option value='" . $filaAprobado['ID'] . "'>" . $filaAprobado['ID'] . "&nbsp;" . $filaAprobado['aprobado'] . " </option>";
}
}
?>
</select>

</td>
</tr>

<tr>
<td>Fecha Nacimiento: </td><td><input type="date" name="fNac" id="fNac" value="<?php echo $fila['fNac']?>"></input></td>
</tr>


</table>
</form>

<button id="btReset">Blanquear</button>
<button id="btModificar">Modificar</button>
<button id="btVolver">Volver</button>
</div>


<script>

/*Objetos*/
var objId = document.getElementById("id");
var objApellido = document.getElementById("apellido");
var objLoginDeUsuario = document.getElementById("loginDeUsuario");
var objnombre = document.getElementById("nombre");
var objaprobado = document.getElementById("aprobado");
var objClave = document.getElementById("clave");
var objfNac = document.getElementById("fNac");

/*Eventos*/

objApellido.onkeyup = function() {
todoListo();
}

objLoginDeUsuario.onkeyup = function() {
todoListo();
}

objnombre.onkeyup = function() {
todoListo();
} 

objaprobado.onchange = function() {
todoListo();
} 


objfNac.onchange = function() {
todoListo();
} 

document.getElementById("btReset").onclick = function() {
blanquear();
}


document.getElementById("btModificar").onclick = function() {
modificacion();
}

document.getElementById("btVolver").onclick = function() {
history.back();
}

</script>

</body>
</html>
