<?php
session_start();
if (!isset($_SESSION['idSession'])) {
	header('Location: ./ingresoalsistema.php');
}
include("../Constants.php");
$conn=mysqli_connect(HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($conn->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}
$id= $_GET['ID'];
#Seleccion de alumnos:
$sqlAlumnos="select * from alumnos where ID=$id";

$resultadoAlumnos=mysqli_query($conn,$sqlAlumnos);

$fila=mysqli_fetch_assoc($resultadoAlumnos);

#Lista de Aprobados:
$sqlAprobados="select * from Aprobados";
$resultadoAprobados=mysqli_query($conn,$sqlAprobados);

?>

<html>
<head>
<title>Formulario para modificaciones</title>

</head>

<body>

<div class="ficha">

<h1>Modificaciones de usuario</h1>

<form id="fAbm" action="./modificacion.php" method="get"> 
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
<td>DNI: </td><td><input type="text" id="DNI" name="DNI"  value="<?php echo $fila['DNI']; ?>" required></input></td>
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
<td>Fecha Nacimiento: </td><td><input type="date" name="FechaNac" id="FechaNac" value="<?php echo $fila['FechaNac']?>"></input></td>
</tr>


</table>
</form>

<button id="reset">Reset</button>
<button id="alta">Modificar</button>
<button onClick="location.href='./index.php'">Volver</button>
</div>
<script>
		function enviar(arg) {
			if(confirm("Desea modificar el alumno?")) {
				arg.submit();				
			}			
		}
		function resetear(arg) {
			arg.reset();
			document.getElementById("alta").disabled = true;
			document.getElementById("reset").disabled = true;
		}
		function validar(objNombre,objApellido,objDNI, objFechaNac) {	
			document.getElementById("reset").disabled = false;		
			if(objApellido.checkValidity() && objNombre.checkValidity() && objDNI.checkValidity() && objFechaNac.checkValidity()) {
				document.getElementById("alta").disabled = false;
				document.getElementById("reset").disabled = false;
			}
			else{
				document.getElementById("alta").disabled = true;				
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
	var objreset = document.getElementById("reset");
	objreset.onclick = function() {resetear(objformulario);}
	objApellido.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}
	objNombre.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}
	objDNI.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}
	objFechaNac.onkeyup = function() { validar(objApellido,objNombre,objDNI,objFechaNac);}	
	document.getElementById("alta").onclick = function() {enviar(objformulario)};
</script>
</html>

<script>
function cargarCategorias() {			
			var objAjax = $.ajax({
			type:"post", 
			url: "../JsonCategorias.php",		
			success: function(respuestaDelServer,estado) { 
						var objCategorias = document.getElementById("categoria");
						listaDeObjetos = JSON.parse(respuestaDelServer);				
						listaDeObjetos.categorias.forEach(function(argValor,argIndice) { 
							var objOption = document.createElement("option");
							objOption.setAttribute("value", argValor.idCategoria);
							objOption.innerHTML = argValor.Descripcion;
							objCategorias.appendChild(objOption);							
						});						
				} 
		}); 
}
</script>
</body>
</html>
