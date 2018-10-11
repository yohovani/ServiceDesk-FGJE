<?php
	Include "conexion.php";
	session_start();
	date_default_timezone_set('America/Mexico_City');

	$fecha = date("y:m:d");
	$descripcion = $_POST['descripcion'];
	$motivo = $_POST['motivo'];
	$idUser = $_SESSION['idUser'];
	$idPrestamo;
	if(!preg_match("[A-Za-z]", $motivo) && !preg_match("[A-Za-z]", $descripcion)){
		$sql = "CALL RegistrarPrestamo('".$fecha."','".$descripcion."','".$motivo."')";
		$peticion = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
		//Liberamos el buffer generado por la consulta sql
		mysqli_free_result($peticion);
		mysqli_close($conexion);
		unset($peticion,$conexion);
		include "conexion.php";
		$sql = "CALL SelectPrestamos()";
		$peticion = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
		while($b = mysqli_fetch_array($peticion)){
			$idPrestamo = $b['idPrestamo'];
		}
		//Liberamos el buffer generado por la consulta sql
		mysqli_free_result($peticion);
		mysqli_close($conexion);
		unset($peticion,$conexion);
		include "conexion.php";
		$sqlRelacion = "CALL RelacionPrestamosUsuarios('".$idUser."','".$idPrestamo."')";
		$peticion = mysqli_query($conexion,$sqlRelacion) or die(mysqli_error($conexion));
		header('Location: /ServiceDesk/index.php');
	}