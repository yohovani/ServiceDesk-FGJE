<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['password'])){
	RegistroTecnicos();
}else{
	RegistroUsuarios();
}

function RegistroUsuarios(){
	include "conexion.php";
	$name = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$usuario = $_POST['user'];
	$area = $_POST['area'];
	//Verificamos con la función preg_match que el nombre solo contenga letras y no caracteres especiales 
	if(!preg_match("[A-Za-z]", $name) && !preg_match("[A-Za-z]", $apellidos) && !preg_match("[A-Za-z]", $usuario)){
		//Utilizamos llamar el procedimiento almacenado RegistrarUsuario
		//Utilizamos procedimientos almacnados por que de esta manera conseguimos un poco mas de seguridad en el sitio
		$mysqli = "Call RegistrarUsuario('".$name."','".$apellidos."','".$usuario."')";
		//Realizamos la petición al servidor
		$insertar = mysqli_query($conexion,$mysqli) or die(mysqli_error($conexion));
		//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
		//El resultado del procedimiento almacenado lo almacenamos en la variable $user
		$user = "CALL SeleccionarUsuario('".$usuario."')";
		//Realizamos la petición al servidor
		$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
		//verificamos que la variable $user no este vacia para verificar si el registro se realizo de manera correcta
		while ($b= mysqli_fetch_array($resultado)){
			if (($b['usuario']==$usuario)){
				$nombre = $b['nombre'];
				$apellidos = $b['apellidos'];
				$encontrado=1;
				$id=$b['idUsuarios'];
				break;
			}
		}
		
		if($encontrado==1){
			mysqli_free_result($resultado);
			mysqli_close($conexion);
			unset($resultado,$conexion);
			include "conexion.php";
			//Insertamos el area
			$areaSQL = "Call RegistrarAreaUsuarios('".$id."','".$area."')";
			//Ejecutamos La petición al servidor
			$insertar = mysqli_query($conexion,$areaSQL) or die(mysqli_error($conexion));
			//Recuperamos el area del usuario
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
		}

	}
}
function RegistroTecnicos(){
	include "conexion.php";
	$name = $_POST['nombre'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	
	//Comparamos las Contraseñas
	if($password == $password2){
		//Pequeño filtrado anti SQL
		if(!preg_match("[A-Za-z0-9]", $name) && !preg_match("[A-Za-z0-9]", $password)){
			//Filtro anti-XSS
			$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
			$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047", "&#49","&#39","&#32","&#79","&#82","&#32","&#39","&#49","&#39","&#61","&#39","&#49");
			$name = str_replace($caracteres_malos, $caracteres_buenos, $name);
			$password = str_replace($caracteres_malos, $caracteres_buenos, $password);
			//Utilizamos llamar el procedimiento almacenado RegistrarUsuario
			//Utilizamos procedimientos almacnados por que de esta manera conseguimos un poco mas de seguridad en el sitio
			$mysqli = "Call RegistrarTecnico('".$name."','".$password."')";
			//Realizamos la petición al servidor
			$insertar = mysqli_query($conexion,$mysqli) or die(mysqli_error($conexion));
			//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
			//El resultado del procedimiento almacenado lo almacenamos en la variable $user
			$user = "CALL SeleccionarTecnico('".$name."','".$password."')";
			//Realizamos la petición al servidor
			$insertar = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
			//verificamos que la variable $user no este vacia para verificar si el registro se realizo de manera correcta
			while ($b = mysqli_fetch_array($resultado)){
				if (($b['nombre']==$name)){
					$encontrado=1;
					break;
			 	}
			}
			
			if($encontrado == 1){
				echo "<script> alert('Registro Exitoso'); </script>";
			}else{
				echo "<script> alert('Ocurrio un error inesperado, vuelve a intentarlo'); </script>')";
			}
			header('Location: index.php');
		}
	}
}