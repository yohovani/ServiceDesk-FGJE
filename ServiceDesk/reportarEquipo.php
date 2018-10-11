<?php
	include "conexion.php";
	session_start();

	date_default_timezone_set('America/Mexico_City');
	$fecha = date("y:m:d");
	$idUser = $_SESSION['idUser'];
	$area = $_SESSION['area'];
	$movil = $_POST['emovil'];
	$servicio = $_POST['descripcionServ'];
	$equipo = $_POST['descripcionEquipo'];
	
	if(!preg_match("[^A-Za-z0-9,]", $movil) && !preg_match("[^A-Za-z0-9,]", $servicio) && !preg_match("[^A-Za-z0-9,]", $equipo)){
		$registrarEquipo = "CALL RegistrarEquipo('".$fecha."','".$area."','".$movil."','".$servicio."','".$equipo."')";
		$insertar = mysqli_query($conexion,$registrarEquipo) or die(mysqli_error($conexion));
		mysqli_free_result($insertar);
		mysqli_close($conexion);
		unset($insertar,$conexion);
		include "conexion.php";
		$seleccionarEquipo = "CALL SelectEquipos()";
		$seleccionar = mysqli_query($conexion,$seleccionarEquipo) or die(mysqli_error($conexion));
		while($b = mysqli_fetch_array($seleccionar)){
			$idEquipo = $b['idEquipo'];
		}
		mysqli_free_result($seleccionar);
		mysqli_close($conexion);
		unset($seleccionar,$conexion);
		include "conexion.php";
		$relacionEU = "CALL RelacionEquipoUsuarios('".$idEquipo."','".$idUser."')";
		$relacion = mysqli_query($conexion,$relacionEU) or die(mysqli_error($conexion));
		mysqli_free_result($seleccionar);
		mysqli_close($conexion);
		unset($seleccionar,$conexion);
		header('Location: /ServiceDesk/index.php');
	}else{
		echo "<script>
		alert('ocurrio un error con tu petici&oacute;n verifica que los datos sean correctos y no introduzcas caracteres especiales');</script>";
		header('Location: /ServiceDesk/index.php');
	}
