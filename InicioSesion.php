<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['password'])){
	inicioSesionTecnico();
}else{
	inicioSesionUsuario();
}

function inicioSesionUsuario(){
	include "conexion.php";
	$name = $_POST['user'];

	//Verificamos que el usuario solo contenga letras y numeros
	if(!preg_match("[^A-Za-z0-9]",$name)){
		//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
		//El resultado del procedimiento almacenado lo almacenamos en la variable $user
		$user = "CALL SeleccionarUsuario('".$name."')";
		//Ejecutamos la petición al servidor
		$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
		while ($b= mysqli_fetch_array($resultado)){
			if (($b['usuario']==$name)){
				$nombre = $b['nombre'];
				$apellidos = $b['apellidos'];
				$encontrado=1;
				$id=$b['idUsuarios'];
				break;
			}
		}
		if($encontrado==1){
			//Iniciamos la sesión con la que se va a trabajar
			session_start();
			//Las varables de sesión son utilizadas para poder hacer cambios en la base de datos con un usuario
			$_SESSION['idUser'] = $id;
			$_SESSION['user'] = $name;
			$_SESSION['nombre'] = $nombre;
			$_SESSION['apellidos'] = $apellidos;
			//Asignamos una cookie se sesión con una duración de 1 hora, dicha cookie sera valida en todo el sistema y solo sera visible mediante una conexión segura
			session_set_cookie_params(3600, "http://localhost/ServiceDesk/");
			//Guardamos la cookie en una variable de sesión para verificar que esta no se cambie y asi obtener un poco mas de seguridad
			$_SESSION['coockie'] = session_get_cookie_params();
			//Redireccionamos al index con la sesión ya iniciada
			header('Location: /ServiceDesk/index.php');
		}
	}
}

function inicioSesionTecnico(){
	include "conexion.php";
	$name = $_POST['user'];
	$password = $_POST['password'];
	
	//Verificamos que el usuario solo contenga letras y numeros
	if(!preg_match("[^A-Za-z0-9]",$name) && !preg_match("[^A-Za-z0-9]",$password)){
		//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
		//El resultado del procedimiento almacenado lo almacenamos en la variable $user
		$user = "CALL SeleccionarTecnico('".$name."','".$password."')";
		//Ejecutamos la petición al servidor
		$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
		while ($b= mysqli_fetch_array($resultado)){
			if (($b['nombre']==$name)){
				$nombre = $b['nombre'];
				$encontrado = 1;
				$id = $b['idUsuarios'];
				$admin = $b['admin'];
				break;
			}
		}
		if($encontrado==1){
			//Iniciamos la sesión con la que se va a trabajar
			session_start();
			//Las varables de sesión son utilizadas para poder hacer cambios en la base de datos con un usuario
			$_SESSION['idUser'] = $id;
			$_SESSION['user'] = $name;
			$_SESSION['nombre'] = $nombre;
			$_SESSION['admin'] = $admin;
			$_SESSION['password'] = $password;
			//Asignamos una cookie se sesión con una duración de 1 hora, dicha cookie sera valida en todo el sistema y solo sera visible mediante una conexión segura
			session_set_cookie_params(3600, "http://localhost/ServiceDesk/");
			//Guardamos la cookie en una variable de sesión para verificar que esta no se cambie y asi obtener un poco mas de seguridad
			$_SESSION['coockie'] = session_get_cookie_params();
			//Redireccionamos al index con la sesión ya iniciada
			header('Location: /ServiceDesk/index.php');
		}
	}
}
