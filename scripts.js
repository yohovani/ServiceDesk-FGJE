$(document).ready(function() {
	$("#reportesModal").html('<p>Sin registros</p>');
	$("#usuariosModal").html('<p>Sin registros</p>');
	$("#usuarioTecnicos").html('<p>Sin registros</p>');
	$("#prestamosModal").html('<p>Sin registros</p>');
	$("#equiposModal").html('<p>Sin registros</p>');
	$("#comprasModal").html('<p>Sin registros</p>');
});

function verReportes(){
	var funct = $("#verReportes").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#reportesModal").html(mensaje);
		});
	}else { 
		$("#reportesModal").html("Ocurrio un error Inesperado");
	}
}

function verUsuarios(){
	var funct = $("#verUsuarios").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#usuariosModal").html(mensaje);
		});
	}else { 
		$("#usuariosModal").html("Ocurrio un error Inesperado");
	}
}

function verTecnicos(){
	var funct = $("#verTecnicos").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#tecnicosModal").html(mensaje);
		});
	}else { 
		$("#tecnicosModal").html("Ocurrio un error Inesperado");
	}
}

function verEquipos(){
	var funct = $("#verEquipos").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#equiposModal").html(mensaje);
		});
	}else { 
		$("#equiposModal").html("Ocurrio un error Inesperado");
	}
}

function verCompras(){
	var funct = $("#verCompras").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#comprasModal").html(mensaje);
		});
	}else { 
		$("#comprasModal").html("Ocurrio un error Inesperado");
	}
}

function verPrestamos(){
	var funct = $("#verPrestamos").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#prestamosModal").html(mensaje);
		});
	}else { 
		$("#prestamosModal").html("Ocurrio un error Inesperado");
	}
}

function verAreas(){
	var funct = $("#verModAreas").val();
	if (funct != "") {
		$.post("consultas.php", {funcion: funct}, function(mensaje) {
			$("#areaMod").html(mensaje);
		});
	}else { 
		$("#prestamosModal").html("Ocurrio un error Inesperado");
	}
}

function nameUser(){
	//Obtenes la información desde el index mediante el Id de los campos de registro
	var name = document.getElementById('nombre').value;
	var ap = document.getElementById('apellidos').value;
	var texto = document.getElementById('user');
	//En la variable User vamos a guardar el nombre de usuario que se genere
	var user="";
	//Separamos por " " por si tiene mas de un nombre
	nombres = name.split(" ");
	//Separamos por " " para obtener los apellidos por separado
	apellidos = ap.split(" ");
	//Recorremos todos los nombres del usuario
	for(i=0;i<nombres.length;i++){
		for(j=0;j<nombres[i].length/3;j++){
			user+=nombres[i][j];
		}
	}
	//Verificamos si el usuario ingreso los dos apellidos o solo uno, si singreso solo uno se agrega a lo que ya se hubiera generado, en caso contrario se hace una convinación con los dos apellidos
	if(apellidos.length > 1){
		for(i=0;i<apellidos[0].length/3;i++){
			user+=apellidos[0][i];
		}
		for(i=0;i<apellidos[1].length/3;i++){
			user+=apellidos[1][i];
		}
	}else{
		user+=apellidos[0];
	}
	//Mostramos el resultado en el cuadro de texto de usuario como placeholder
	texto.style.display = "block";
	texto.placeholder = " Usuario Recomendado: "+user;
}

function verificarPassword(){
	//Obtenes la información desde el index mediante el Id de los campos de registro
	var pass1 = document.getElementById('password');
	var pass2 = document.getElementById('password2');
	var btn = document.getElementById('btnEnviar');
	//Validamos que ambas contraseñas sean iguales
	if(pass1.value == pass2.value){
		//Si son iguales el fondo de los campos cambia a verde
		pass1.style.background = "#2AF20B";
		pass2.style.background = "#2AF20B";
		//se habilita el boton para hacer el registro
		btn.disabled = false;
	}else{
		//Si son iguales el fondo de los campos cambia a rojo
		pass1.style.background = "#CD5555";
		pass2.style.background = "#CD5555";
		//se desabilita el boton para hacer el registro
		btn.disabled = true;
	}
}

function excel(){
	var opcion = document.getElementById("excelOption");
	var fechaI = document.getElementById("tfi");
	var fechaF = document.getElementById("tff");
	var fecha1 = document.getElementById("fecha1");
	var fecha2 = document.getElementById("fecha2");
	var confExcel = document.getElementById("confExcel");
	
	if(opcion.value == 1){
		fechaI.style.display = "none";
		fechaF.style.display = "none";
		fecha1.style.display = "none";
		fecha2.style.display = "none";
		confExcel.value = 2;
	}else{
		fechaI.style.display = "block";
		fechaF.style.display = "block";
		fecha1.style.display = "block";
		fecha2.style.display = "block";
		confExcel.value = 1;
	}	
}

function Password(){
	//Obtenes la información desde el index mediante el Id de los campos de registro
	var pass1 = document.getElementById('passwordActual');
	var pass2 = document.getElementById('Newpassword');
	var pass3 = document.getElementById('Newpassword2');
	var actual = document.getElementById('Actual');
	var btn = document.getElementById('btnEnviarnewPassword');
	//Validamos que ambas contraseñas sean iguales
	if(pass1.value == actual.value){
		//Si son iguales el fondo de los campos cambia a verde
		pass1.style.background = "#2AF20B";
		if(pass2.value == pass3.value && pass2.value != ''){
			pass2.style.background = "#2AF20B";
			pass3.style.background = "#2AF20B";
			//se habilita el boton para hacer el registro
			btn.disabled = false;
		}else{
			//Si son iguales el fondo de los campos cambia a rojo
			pass2.style.background = "#CD5555";
			pass3.style.background = "#CD5555";
			//se desabilita el boton para hacer el registro
			btn.disabled = true;
		}

	}else{
		//Si son iguales el fondo de los campos cambia a rojo
		pass1.style.background = "#CD5555";
		pass2.style.background = "#CD5555";
		//se desabilita el boton para hacer el registro
		btn.disabled = true;
	}
}

function areas(){
	var areas = document.getElementById('area');
	var formulario = document.getElementById('agregarAreas');
	if(areas.value == "Otro"){
		formulario.hidden = false;
	}else{
		formulario.hidden = true;
	}
}

function MostrarFormAreas(){
	var areas = document.getElementById('areaMod');
	var formulario = document.getElementById('ModificarAreasFormulario');
	var areaText = document.getElementById('IdModificarAreaAdmin');
	formulario.hidden = false;
	areaText.value = areas.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("areaResultado").innerHTML = xhttp.responseText;
		}
	};
	xhttp.open("POST", "modificarAreas.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("operacion="+1+"&idArea="+areas.value+"");
}

function addArea() {
	var area = document.getElementById('newArea').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("areasUsuario").innerHTML = xhttp.responseText;
		}
	};
	xhttp.open("POST", "agregarArea.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("newArea="+area+"");
}

function ModificarAreas(){
	var areaId = document.getElementById('IdModificarAreaAdmin');
	var areaText = document.getElementById('TextModificarAreaAdmin');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("MAA").innerHTML = xhttp.responseText;
		}
	};
	xhttp.open("POST", "ModificarAreas.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("operacion="+2+"&idArea="+areaId.value+"&textArea="+areaText.value);
}

function sesionTecnicos(){
	var usuario = document.getElementById('usuario');
	var password = document.getElementById('pass');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("resultadoIS").innerHTML = xhttp.responseText;
		}
	};
	xhttp.open("POST", "validarPassword.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("user="+usuario.value+"&password="+password.value+"");
}