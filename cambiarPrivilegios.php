<?php
	if(isset($_POST['admin'])){
		cambiarAdmin();
	}else{
		cambiarRecepcion();
	}
	
function cambiarAdmin(){
	include "conexion.php";
	$admin = 0;
	if($_POST['admin'] == true){
		$admin = 0;
	}else{
		$admin = 1;
	}
	$sqlAdmin = "UPDATE `tecnicos` SET `admin`='".$admin."' WHERE tecnicos.idTecnicos = '".$_POST['idTecnico']."'";
	//$sqlAdmin = "CALL cambiarAdmin('".$_POST['idTecnico']."','".!$_POST['admin']."')";
	$cambio = mysqli_query($conexion,$sqlAdmin) or die(mysqli_error($conexion));
	mysqli_free_result($cambio);
	mysqli_close($conexion);
	unset($cambio,$conexion);
	header('Location: index.php');
}

function cambiarRecepcion(){
	include "conexion.php";
	$recepcion = 0;
	if($_POST['recepcion'] == true){
		$recepcion = 0;
	}else{
		$recepcion = 1;
	}
	$sqlRecepcion = "UPDATE `tecnicos` SET `recepcion`='".$recepcion."' WHERE tecnicos.idTecnicos = '".$_POST['idTecnico']."'";
//	$sqlRecepcion = "CALL cambiarRecepcion('".$_POST['idTecnico']."','".!$_POST['recepcion']."')";
	$cambio = mysqli_query($conexion,$sqlRecepcion) or die(mysqli_error($conexion));
	mysqli_free_result($cambio);
	mysqli_close($conexion);
	unset($cambio,$conexion);
	header('Location: index.php');
}