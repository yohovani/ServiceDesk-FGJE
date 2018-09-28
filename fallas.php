<?php
include "conexion.php";
session_start();
date_default_timezone_set('America/Mexico_City');

$area = $_POST['area'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];
$fecha = date("y:m:d");
$hora_inicio = date("H:i:s");

//Verificamos con la función preg_match que el nombre solo contenga letras y no caracteres especiales 
if(!preg_match("[A-Za-z]", $area) && !preg_match("[A-Za-z]", $tipo) && !preg_match("[A-Za-z]", $descripcion)){
	$sqlSelectTecnico = "Call SeleccionarTecnicoFalla()";
	$resultado = mysqli_query($conexion,$sqlSelectTecnico) or die(mysqli_error($conexion));
	$b = mysqli_fetch_array($resultado);
	$tecnico = $b['idTecnicos'];
	//Liberamos el buffer generado por la consulta sql
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$sqlFalla = "CALL RegistrarFalla('".$fecha."','".$hora_inicio."','".$tipo."','".$descripcion."','".$area."')";
	$resultado = mysqli_query($conexion,$sqlFalla) or die(mysqli_error($conexion));
	//Liberamos el buffer generado por la consulta sql
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$sqlSeleccionarFallas = "CALL SeleccionarFallas()";
	$resultado = mysqli_query($conexion,$sqlSeleccionarFallas) or die(mysqli_error($conexion));
	while($b= mysqli_fetch_array($resultado)){
		$id = $b['idServicios'];
	}
	//Liberamos el buffer generado por la consulta sql
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$sqlRelacionSU = "CALL RelacionServiciosUsuarios('".$_SESSION['idUser']."','".$id."')";
	$resultado = mysqli_query($conexion,$sqlRelacionSU) or die(mysqli_error($conexion));
	//Liberamos el buffer generado por la consulta sql
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$sqlRelacionST = "CALL RelacionServiciosTecnicos('".$id."','".$tecnico."')";
	$resultado = mysqli_query($conexion,$sqlRelacionST) or die(mysqli_error($conexion));
	header('Location: /ServiceDesk/index.php');
}