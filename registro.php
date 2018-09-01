<?php
include "conexion.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$name = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$usuario = $_POST['user'];

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
	$insertar = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
	//verificamos que la variable $user no este vacia para verificar si el registro se realizo de manera correcta

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