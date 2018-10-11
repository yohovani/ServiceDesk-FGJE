<?php
	include "conexion.php";
	session_start();
	$user = $_SESSION['user'];
	$area = $_SESSION['area'];
	date_default_timezone_set('America/Mexico_City');
	$fecha = date("y:m:d");
	$idUser = $_SESSION['idUser'];
	$articulo = $_POST['articulo'];
	$dictamen = $_POST['dictamen'];
	$planeacion = $_POST['planeacion'];
	
	if(!preg_match("[^A-Za-z0-9,]", $articulo) && !preg_match("[^A-Za-z0-9,]", $dictamen) && !preg_match("[^A-Za-z0-9,]", $planeacion)){
		$sqlRegistroCompra = "CALL RegistrarCompra('".$fecha."','".$area."','".$articulo."','".$dictamen."','".$planeacion."')";
		$insertar = mysqli_query($conexion,$sqlRegistroCompra) or die(mysqli_error($conexion));
		mysqli_free_result($insertar);
		mysqli_close($conexion);
		unset($insertar,$conexion);
		include "conexion.php";
		$sqlSelectCompras = "CALL SelectCompras()";
		$select = mysqli_query($conexion,$sqlSelectCompras) or die(mysqli_error($conexion));
		while($b = mysqli_fetch_array($select)){
			$idCompra = $b['idCompras'];
		}
		mysqli_free_result($select);
		mysqli_close($conexion);
		unset($select,$conexion);
		include "conexion.php";
		$sqlRelacion = "CALL RelacionComprasUsuarios('".$idUser."','".$idCompra."')";
		$relacion = mysqli_query($conexion,$sqlRelacion) or die(mysqli_error($conexion));
		mysqli_free_result($relacion);
		mysqli_close($conexion);
		unset($relacion,$conexion);
		header('Location: /ServiceDesk/index.php');
	}else{
		echo "<script>
		alert('ocurrio un error con tu petici&oacute;n verifica que los datos sean correctos y no introduzcas caracteres especiales');</script>";
		header('Location: /ServiceDesk/index.php');
	}