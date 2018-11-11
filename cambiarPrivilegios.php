<?php
	if(isset($_POST['admin'])){
		cambiarAdmin();
	}else{
		cambiarRecepcion();
	}
	
function cambiarAdmin(){
	include "conexion.php";
	$sqlAdmin = "CALL cambiarAdmin('".$_POST['idTecnico']."','".!$_POST['admin']."')";
	$cambio = mysqli_query($conexion,$sqlAdmin) or die(mysqli_error($conexion));
	mysqli_free_result($cambio);
	mysqli_close($conexion);
	unset($cambio,$conexion);
	header('Location: index.php');
}

function cambiarRecepcion(){
	include "conexion.php";
	$sqlRecepcion = "CALL cambiarRecepcion('".$_POST['idTecnico']."','".!$_POST['recepcion']."')";
	$cambio = mysqli_query($conexion,$sqlRecepcion) or die(mysqli_error($conexion));
	mysqli_free_result($cambio);
	mysqli_close($conexion);
	unset($cambio,$conexion);
	header('Location: index.php');
}