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
	$name = strtolower($name);
	//Verificamos que el usuario solo contenga letras y numeros
	if(!preg_match("[^A-Za-z0-9]",$name)){
		//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
		//El resultado del procedimiento almacenado lo almacenamos en la variable $user
		$user = 
		$user = "SELECT * FROM `usuarios` WHERE lower(`usuario`) = lower('".$name."')";
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
		if($encontrado>0){
			mysqli_free_result($resultado);
			mysqli_close($conexion);
			unset($resultado,$conexion);
			include "conexion.php";
			$userArea = "CALL SelectAreaUsuario('".$id."')";
			//Ejecutamos la petición al servidor
			$resultado = mysqli_query($conexion,$userArea) or die(mysqli_error($conexion));
			while($b= mysqli_fetch_array($resultado)){
				$area = $b['nombre'];
			}
			//Iniciamos la sesión con la que se va a trabajar
			session_start();
			//Las varables de sesión son utilizadas para poder hacer cambios en la base de datos con un usuario
			$_SESSION['idUser'] = $id;
			$_SESSION['user'] = $name;
			$_SESSION['nombre'] = $nombre;
			$_SESSION['apellidos'] = $apellidos;
			$_SESSION['area'] = $area;
			//Asignamos una cookie se sesión con una duración de 1 hora, dicha cookie sera valida en todo el sistema y solo sera visible mediante una conexión segura
			session_set_cookie_params(3600, "http://localhost/ServiceDesk/");
			//Guardamos la cookie en una variable de sesión para verificar que esta no se cambie y asi obtener un poco mas de seguridad
			$_SESSION['coockie'] = session_get_cookie_params();
			//Redireccionamos al index con la sesión ya iniciada
			header('Location: index.php');
		}else{
			header('Location: index.php');
		}
	}
}

function inicioSesionTecnico(){
	include "conexion.php";
	$name = $_POST['user'];
	$password = $_POST['password'];
	$name = strtolower($name);
	//Verificamos que el usuario solo contenga letras y numeros
	if(!preg_match("[^A-Za-z0-9]",$name) && !preg_match("[^A-Za-z0-9]",$password)){
		$encontrado = 0;
		//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
		//El resultado del procedimiento almacenado lo almacenamos en la variable $user
		$user = "SELECT * FROM `tecnicos` WHERE lower('".$name."') = lower(`nombre`) AND password = '".$password."'";
		//Ejecutamos la petición al servidor
		$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
		while ($b= mysqli_fetch_array($resultado)){
			if (($b['nombre']==$name)){
				$nombre = $b['nombre'];
				$encontrado = 1;
				$id = $b['idTecnicos'];
				$admin = $b['admin'];
				$recepcion = $b['recepcion'];
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
			$_SESSION['recepcion'] = $recepcion;
			//Asignamos una cookie se sesión con una duración de 1 hora, dicha cookie sera valida en todo el sistema y solo sera visible mediante una conexión segura
			//Guardamos la cookie en una variable de sesión para verificar que esta no se cambie y asi obtener un poco mas de seguridad
			$_SESSION['coockie'] = session_get_cookie_params();
			//Redireccionamos al index con la sesión ya iniciada
			header('Location: index.php');
			
		}else{
			echo '<div class="alert alert-danger ">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Error:</strong> Tus credenciales son erroneas.
			</div>';
		}
	}
}
?>

