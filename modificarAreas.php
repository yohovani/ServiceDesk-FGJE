<?php
	
	switch ($_POST['operacion']){
		case 1:{
			mostrarArea();
			break;
		}
		case 2:{
			modificarArea();
			break;
		}
	}
	
	function mostrarArea(){
		include 'conexion.php';
		$sqlAreaId = "SELECT * FROM areas WHERE idArea='".$_POST['idArea']."'";
		$resultado = mysqli_query($conexion, $sqlAreaId) or die(mysqli_error($conexion));
			while ($area = mysqli_fetch_array($resultado)) {
				echo '<input type="text" id="TextModificarAreaAdmin" name="TextModificarAreaAdmin" class="form-control" value="'.$area['nombre'].'">';
			}
		
	}
	
	function modificarArea(){
		include 'conexion.php';
		$name = utf8_decode($_POST['textArea']);
		$sqlModificacion = "UPDATE `areas` SET `nombre`='".$name."' WHERE `idArea` = '".$_POST['idArea']."'";
		$resultado = mysqli_query($conexion, $sqlModificacion) or die(mysqli_error($conexion));
		//echo 'La modificaci&oacute;n se realizo correctamente';
		echo '<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Actualización:</strong> La actualización se realizo de manera correcta.
			</div>';
	}