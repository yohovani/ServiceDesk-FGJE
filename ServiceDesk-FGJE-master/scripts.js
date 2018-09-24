$(document).ready(function() {
	$("#reportesModal").html('<p>Sin registros</p>');
	$("#usuariosModal").html('<p>Sin registros</p>');
	$("#usuarioTecnicos").html('<p>Sin registros</p>');
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