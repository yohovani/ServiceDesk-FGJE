<?php
	include "conexion.php";
	$finalizarSQL = "CALL finalizarEquipo('".$_POST['idEquipo']."')";
	$resultadoTecnicoIds = mysqli_query($conexion,$finalizarSQL) or die(mysqli_error($conexion));
	header('Location: /ServiceDesk/index.php');