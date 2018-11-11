<?php
	Include "conexion.php";
	
	date_default_timezone_set('America/Mexico_City');
	$fecha = date("y:m:d");
	$idPrestamo = $_POST['idprestamo'];
	$sql = "CALL FinalizarPrestamo('".$idPrestamo."','".$fecha."')";
	
	$Peticion =  mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	//Redireccionamos una vez que ya se realizo la consulta hacia el index 
	header('Location: index.php');