<?php
	include "conexion.php";
	
	$finalizarCompra = "CALL finalizarCompra('".$_POST['idCompras']."')";
	$finalizar = mysqli_query($conexion,$finalizarCompra) or die(mysqli_error($conexion));
	mysqli_free_result($finalizar);
	mysqli_close($conexion);
	unset($finalizar,$conexion);
	header('Location: /ServiceDesk/index.php');