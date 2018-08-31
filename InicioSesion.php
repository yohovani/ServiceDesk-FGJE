<?php
include "conexion.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$name = $_POST['usuario'];
$pass = $_POST['password'];

//Verificamos que el usuario solo contenga letras y numeros
if(!preg_match("[^A-Za-z0-9]",$name)){
	//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
	//El resultado del procedimiento almacenado lo almacenamos en la variable $user
	$user = "CALL SeleccionarUsuario('".$name."','".$pass."')";
	//Ejecutamos la petición al servidor
	$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
		while ($b= mysqli_fetch_array($resultado)){
			if (($b['nombre_usuario']==$usuario)&&($b['password']==$pass)) {
				$encontrado=1;
				$id=$b['idusuario'];
				break;
			}
		}
		if($encontrado==1){
			//Iniciamos la sesión con la que se va a trabajar
			session_start();
			//Las varables de sesión son utilizadas para poder hacer cambios en la base de datos con un usuario
			$_SESSION['idUser'] = $id;
			$_SESSION['user'] = $name;
			$_SESSION['password'] = $pass;
			//Asignamos una cookie se sesión con una duración de 1 hora, dicha cookie sera valida en todo el sistema y solo sera visible mediante una conexión segura
			session_set_cookie_params(3600, "http://localhost/ServiceDesk/");
			//Guardamos la cookie en una variable de sesión para verificar que esta no se cambie y asi obtener un poco mas de seguridad
			$_SESSION['coockie'] = session_get_cookie_params();
			//Redireccionamos al index con la sesión ya iniciada
			header('Location: /ServiceDesk/index.php');
		}else{
			//Dado que quien esta ingresando no es un usuario verificamos si este es un técnico
			
		}
		
}


