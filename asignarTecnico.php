<?php

	if($_POST['tipo'] == 1){
		servicios();
	}else{
		equipos();
	}

	function servicios(){
		include 'conexion.php';
		$relacionSQL = "CALL relacionServiciosTecnicos('".$_POST['idServicio']."','".$_POST['tecnicoId']."')";
		$resultadoTecnicoIds = mysqli_query($conexion,$relacionSQL) or die(mysqli_error($conexion));
		header('Location: index.php');
	}

	function equipos(){
		include 'conexion.php';
		$relacionSQL = "CALL relacionEquiposTecnicos('".$_POST['idEquipo']."','".$_POST['tecnicoId']."')";
		$resultadoTecnicoIds = mysqli_query($conexion,$relacionSQL) or die(mysqli_error($conexion));
		header('Location: index.php');
	}