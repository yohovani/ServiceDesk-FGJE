<?php
	include "conexion.php";
	
	if(!preg_match("[^A-Za-z0-9]",$_POST['newArea'])){
		$sqlNewArea = "INSERT INTO `areas`(`nombre`) VALUES ('".$_POST['newArea']."')";
		$resultado = mysqli_query($conexion,$sqlNewArea) or die(mysqli_error($conexion));
		echo 'Su area se registro correctamente';
		echo '<select class="form-control" name="area" id="area" onchange="areas()">';
			include "conexion.php";
			$i;
			//Utilizamos el metodo almacenado para seleccionar las areas
			$mysqli = "Call SelectAreas()";
			//Ejecutamos la petición al servidor
			$resultado = mysqli_query($conexion, $mysqli) or die(mysqli_error($conexion));
			while ($area = mysqli_fetch_array($resultado)) {
				echo "<option value='" . $area['idArea'] . "' size>" . utf8_encode($area['nombre']) . "</option>";
				$i = $area['idArea'];
			}
			while ($area = mysqli_fetch_array($resultado)) {
				echo "<label> " . ($area['nombre']) . "</label>";
			}
			echo "<option value='Otro' size>Otro</option>";
		echo '</select>';
	}else{
		echo 'Por seguridad No se permiten catacteres especiales';
		echo '<select class="form-control" name="area" id="area" onchange="areas()">';
			include "conexion.php";
			$i;
			//Utilizamos el metodo almacenado para seleccionar las areas
			$mysqli = "Call SelectAreas()";
			//Ejecutamos la petición al servidor
			$resultado = mysqli_query($conexion, $mysqli) or die(mysqli_error($conexion));
			while ($area = mysqli_fetch_array($resultado)) {
				echo "<option value='" . $area['idArea'] . "' size>" . utf8_encode($area['nombre']) . "</option>";
				$i = $area['idArea'];
			}
			while ($area = mysqli_fetch_array($resultado)) {
				echo "<label> " . ($area['nombre']) . "</label>";
			}
			echo "<option value='Otro' size>Otro</option>";
		echo '</select>';
	}
