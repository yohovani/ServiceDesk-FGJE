/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

