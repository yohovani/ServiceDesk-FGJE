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
		$encontrado = 0;
		$user = "SELECT * FROM `usuarios` WHERE lower(`usuario`) = lower('".$name."')";
		//Ejecutamos la petición al servidor
		$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
		while ($b= mysqli_fetch_array($resultado)){
			if ((strtolower($b['usuario'])==$name)){
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
			echo '<!DOCTYPE html>
					<html lang="en">
					<head>
						<link rel="shortcut icon" href="img/logo.png">
						<title>FGJE Unidad de Inform&aacute;tica</title>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1">
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
						<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
						<script src="scripts.js"></script>
					</head>
				<body>
					<nav class="navbar" style="background-color:#212650;">';
					echo "<strong style='color: white;'>FGJE - Visitante</strong>"
			. "</nav>";
				echo '<div class="container" id="collapsibleNavbar3">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Usuario no encontrado</h4>
						</div>
						<div class="modal-body">
						<div class="alert alert-danger ">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<h5>El usuario: <strong>'.$_POST['user'].'</strong> no se encuentra registrado intenta con un usuario diferente o bien registrate para acceder</h5>
			</div>
							
							<div id="sesion">
				
						<form class="form-horizontal" action="InicioSesion.php" method="post">
							<div class="form-group">
								<label class="control-label col-sm-2" >Usuario:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="user" id="usuario" placeholder="Usuario" required>
								</div>
							</div>
							<div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit"  class="btn btn-default">Iniciar Sesi&oacute;n</button>
								</div>
								<br>
								<div class="col-sm-offset-2 col-sm-10">
									<button class="btn btn-default" type="button" data-toggle="modal" data-tooltip="tooltip" data-placement="bottom" title="Click Aqui Para Registrarte" data-target="#registro">
										Registrarse
									</button>
								</div>

							</div>
						</form>
					</div>
				</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="container-fluid text-center" style="background-color:#ad8a3e;">
				  <p style="color:white">WebDesign By Servicio Social</p>
			</footer>

		</body>
		</html>';
				
				echo '		<!-- Modal para Registrarse Usuarios Comunes-->
		<div class="modal fade" id="registro">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Registro</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="registro.php" method="post">
							<!- Area->
							<div class="form-group">
								<label class="control-label col-sm-2" >Area:</label>
								<div class="col-sm-10" id="areasUsuario">
									<select class="form-control" name="area" id="area" onchange="areas()">';
										
											include "conexion.php";
											$i;
											//Utilizamos el metodo almacenado para seleccionar las areas
											$mysqli = "Call SelectAreas()";
											//Ejecutamos la petición al servidor
											$resultado = mysqli_query($conexion,$mysqli) or die(mysqli_error($conexion));
											while ($area= mysqli_fetch_array($resultado)){
												echo "<option value='".$area["idArea"]."' size>".utf8_encode($area["nombre"])."</option>";
												$i=$area["idArea"];
											}
											while ($area= mysqli_fetch_array($resultado)){
												echo "<label> ".($area["nombre"])."</label>";
											}
											echo "<option value='Otro' size>Otro</option>";
										
									echo '</select>
									<div id="agregarAreas" hidden="true">
										<label>Agregue su Area:</label>
										<input type="text" id="newArea" name="newArea" class="form-control" placeholder="¿Cual es su area?">
										<button  class="btn btn-default" onclick="addArea()">Agregar</button>
									</div>
								</div>
							</div>
							<!- Nombre->
							<div class="form-group">
								<label class="control-label col-sm-2" >Nombre:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required id="nombre" >
								</div>
							</div>
							<!- Apellidos->
							<div class="form-group">
								<label class="control-label col-sm-2" >Apellidos:</label>
								<div class="col-sm-10">
									<input type="text" required class="form-control" name="apellidos" placeholder="Apellidos" id="apellidos" onkeyup="nameUser()">
								</div>
							</div>
							<!- Usuario->
							<div class="form-group">
								<label class="control-label col-sm-2" id="usuario" >Usuario:</label>
								<div id="resultadoNombreUsuario">
								</div>

							</div>
							
							<!-Botón enviar->
							<div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">Enviar</button>
								</div>
							</div>
						</form>
					</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
				</div>
			</div>
		</div>';
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
			if ((strtolower($b['nombre'])==$name)){
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

