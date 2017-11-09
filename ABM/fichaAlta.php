
<html>
<head>
	<meta charset="utf-8"/>
    <title>ALTA</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css"/>
</head>
<script src="../jquery.js"></script>
<body>
<div class="contenedor">    
    <form method="post" id="miform" action="./alta.php" class="contacto">
    <h1>Alta de artículo</h1>
    <ul>
        <li>
            <label>Descripción:</label><input type="text" id="descripcion" name="descripcion" required />
        </li>
        <li>
            <label>Categoría:</label><select id="categoria" name="categoria" required></select>
        </li>
        <li>
            <label>Unidad de medida:</label><input type="text" id="um" name="um" maxlength="3" required/>
        </li>
        <li>
            <label>Fecha de vencimiento:</label> <input type="date" id="fvenc" name="fvenc" required/>
        </li>
        <li>
            <label>Stock:</label> <input type="number" id="stock" name="stock" required/>
        </li>     
        <li>
            <button id="alta" disabled >Alta</button>	
            <button id="reset" disabled >Reset</button>  
        </li>
    </ul>    
	</form>	
</div>
</body>
<script>
		function enviar(arg) {
			if(confirm("Desea dar de alta el articulo?")) {
				arg.submit();				
			}			
		}
		function resetear(arg) {
			arg.reset();
			document.getElementById("alta").disabled = true;
			document.getElementById("reset").disabled = true;
		}
		function validar(objnombre,objapellido,objsaldo) {	
			document.getElementById("reset").disabled = false;		
			if(objdescripcion.checkValidity() && objum.checkValidity() && objstock.checkValidity()) {				
				document.getElementById("alta").disabled = false;
				document.getElementById("reset").disabled = false;
			}
			else{
				document.getElementById("alta").disabled = true;				
			}		
		}
</script>
<script>
	var objformulario = document.getElementById("miform");
	var objdescripcion = document.getElementById("descripcion");
	var objum = document.getElementById("um");
    var objstock = document.getElementById("stock");
	var objreset = document.getElementById("reset");
	objreset.onclick = function() {resetear(objformulario);}
	objdescripcion.onkeyup = function() { validar(objdescripcion,objum,objstock);}
	objum.onkeyup = function() { validar(objdescripcion,objum,objstock);}
	objstock.onkeyup = function() { validar(objdescripcion,objum,objstock);}	
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

$(document).ready(function() {
window.onload = function() {
cargarCategorias();
}
});
</script>