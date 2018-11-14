<?php

include 'conexion.php';
if(!preg_match("[^A-Za-z0-9]",$_POST['nombre'])){
	$nombre = $_POST['nombre'];
	$nombre = strtolower($nombre);
	do{
		$SQL =  "SELECT usuario FROM usuarios WHERE usuario = '".$nombre."'";
		$resultado = mysqli_query($conexion,$SQL) or die(mysqli_error($conexion));
		if(mysqli_num_rows($resultado) != 0){
			$nombre .= randomText(1)."";
		}
	}while(mysqli_num_rows($resultado) != 0);
	echo '<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Nombre de usuario:</strong> <label id="nameUsuario">'.$nombre.'</label>
		</div>
		<div class="col-sm-10">
			<input type="text" readonly class="form-control" required name="user" placeholder="Nombre de usuario" id="user" value="'.$nombre.'">
		</div>';
	

}

function randomText($length) { 
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
	$key="";
    for($i = 0; $i < $length; $i++) { 
        $key .= $pattern{rand(0, 35)}; 
    } 
    return $key; 

}  