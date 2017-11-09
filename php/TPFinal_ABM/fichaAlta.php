<?php
// $identificador=$_GET['ID'];
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
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
</head>

<body>

<div class="ficha">

<h1>Alta de Alumno</h1>

<form id="fAbm" action="./alta.php" method="get"> 
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
<select id="aprobado" name="Aprobado" required>
<?php
while($fila=mysqli_fetch_assoc($resultadoAprobado)) {
if ($fila['ID']==$filtroAprobado) {
echo "<option value='" . $fila['ID'] . "' selected='selected'>" . $fila['aprobado'] . "</option>";
}
else {
echo "<option value='" . $fila['ID'] . "'>" . $fila['aprobado'] . " </option>";
}
}
?>
</select>

</td></tr>


<tr>
<td>Fecha de Nacimiento: </td><td><input type="date" name="FechaNac" id="FechaNac" required></input></td>
</tr>




</table>
</form>

<button id="btReset" disabled>Reset</button>
<button id="btAlta" disabled>Alta</button>
<button onClick="location.href='./index.php'">Volver</button>
</div>


<script>
		function enviar(arg) {
			if(confirm("Desea dar de alta el alumno?")) {
				arg.submit();				
			}			
		}
		function resetear(arg) {
			arg.reset();
			document.getElementById("btAlta").disabled = true;
			document.getElementById("btReset").disabled = true;
		}
		function validar(objNombre,objApellido,objDNI, objFechaNac) {	
			document.getElementById("btReset").disabled = false;		
			if(objApellido.checkValidity() && objNombre.checkValidity() && objDNI.checkValidity() && objFechaNac.checkValidity()) {
				document.getElementById("btAlta").disabled = false;
				document.getElementById("btReset").disabled = false;
			}
			else{
				document.getElementById("btAlta").disabled = true;				
			}		
		}
</script>
<script>
	var objformulario = document.getElementById("fAbm");
	var objApellido = document.getElementById("apellido");
	var objNombre = document.getElementById("nombre");
    var objDNI = document.getElementById("DNI");
    var objFechaNac = document.getElementById("FechaNac");
    var objAprobado = document.getElementById("aprobado");
	var objreset = document.getElementById("btReset");
	objreset.onclick = function() {resetear(objformulario);}
	objApellido.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}
	objNombre.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}
	objDNI.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}
	objFechaNac.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}	
	document.getElementById("btAlta").onclick = function() {enviar(objformulario)};
</script>
</html>

</body>
</html>
