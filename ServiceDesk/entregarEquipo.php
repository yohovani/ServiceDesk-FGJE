<?php
	include "conexion.php";
	
	date_default_timezone_set('America/Mexico_City');
	$fecha = date("y:m:d");
	$idEquipo = $_POST['idEquipo'];
	$sqlEntrega = "CALL entregarEquipo('".$fecha."','".$idEquipo."')";
	$entrega = mysqli_query($conexion,$sqlEntrega) or die(mysqli_error($conexion));
	mysqli_free_result($entrega);
	mysqli_close($conexion);
	unset($entrega,$conexion);
	header('Location: /ServiceDesk/index.php');