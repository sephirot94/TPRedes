<?php
$identificador=$_GET['ID'];
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}

$sqlAprobados="select * from aprobados";
$resultadoAprobado=mysqli_query($conn,$sqlAprobados);

?>

<html>
<head>
<title>Formulario para altas</title>

<script>
/*Funciones con nombres*/

function inicio() {
document.getElementById("ID").readOnly=true; 
document.getElementById('btAlta').disabled=true;
document.getElementById('btReset').disabled=true;
}

function todoListo() { 
if(objApellido.checkValidity()&&objNombre.checkValidity()&&objDNI.checkValidity()&&objFechaNac.checkValidity()){
document.getElementById("btAlta").disabled=false;
document.getElementById("btReset").disabled=false;
}
else if((objDNI.value!="")||
(objApellido.value!="")||
(objNombre.value!="")||
(objFechaNac.value!="")) {
document.getElementById("btAlta").disabled=true;
document.getElementById("btReset").disabled=false;
}
else {
document.getElementById("btAlta").disabled=true;
document.getElementById("btReset").disabled=true;
}
}

function blanquear() {
if(confirm("¿Esta seguro de blanquear?")) {
document.getElementById("apellido").value="";
document.getElementById("loginDeUsuario").value="";
document.getElementById("nombre").value="";
document.getElementById("FechaNac").value="";
document.getElementById("apellido").focus();
document.getElementById("btAlta").disabled=true;
document.getElementById("btReset").disabled=true;
}
}

function alta() {
confirm("¿Está seguro?");
document.getElementById("fAbm").action='./alta.php';
document.getElementById("fAbm").submit();
}

</script>

</head>

<body onLoad="inicio()">

<div class="ficha">

<h1>Alta de Alumno</h1>

<form id="fAbm" action="" method="get"> 
<table>
<tr>
<td>ID de alumno: </td><td><input type="text" id="ID" name="ID" readonly></input></td>
</tr>

<tr>
<td>Apellido: </td><td><input type="text" id="apellido" name="apellido"  required></input></td>
</tr>

<tr>
<td>nombre: </td><td><input type="text" id="nombre" name="nombre" required></input></td>
</tr>

<tr>
<td>DNI: </td><td><input type="text" id="DNI" name="DNI" required></input></td>
</tr>


<tr>
<td>
Aprobado:
</td>
<td>
<select id="Aprobado" name="Aprobado">
<?php
while($fila=mysqli_fetch_assoc($resultadoAprobado)) {
if ($fila['ID']==$filtroAprobado) {
echo "<option value='" . $fila['ID'] . "' selected='selected'>" . $fila['aprobado'] . "</option>";
}
else {
echo "<option value='" . $fila['ID'] . "'>" . $fila['ID'] . "&nbsp;" . $fila['aprobado'] . " </option>";
}
}
?>
</select>

</td></tr>


<tr>
<td>Fecha de Nacimiento: </td><td><input type="password" name="FechaNac" id="FechaNac" required></input></td>
</tr>




</table>
</form>

<button id="btReset">Blanquear</button>
<button id="btAlta">Alta</button>
<button id="btVolver">Volver</button>
</div>


<script>

/*Objetos*/
var objId = document.getElementById("id");
var objApellido = document.getElementById("apellido");
var objDNI = document.getElementById("loginDeUsuario");
var objNombre = document.getElementById("nombre");
var objAprobado = document.getElementById("Aprobado");
var objFechaNac = document.getElementById("FechaNac");

/*Eventos*/

objApellido.onkeyup = function() {
todoListo();
}

objDNI.onkeyup = function() {
todoListo();
}

objNombre.onkeyup = function() {
todoListo();
} 

objFechaNac.onkeyup = function() {
todoListo();
} 

objAprobado.onchange = function() {
todoListo();
} 

document.getElementById("btReset").onclick = function() {
blanquear();
}

document.getElementById("btAlta").onclick = function() {
alta();
}

document.getElementById("btVolver").onclick = function() {
history.back();
}

</script>

</body>
</html>
