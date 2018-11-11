<?php

include "conexion.php";

$name = $_POST['user'];
$password = $_POST['password'];

//Verificamos que el usuario solo contenga letras y numeros
if(!preg_match("[^A-Za-z0-9]",$name) && !preg_match("[^A-Za-z0-9]",$password)){
	$encontrado = 0;
	//Utilizamos el procedimiento almacenado para SeleccinarUsuario para validar que el registro se haya echo de manera exitosa
	//El resultado del procedimiento almacenado lo almacenamos en la variable $user
	$user = "CALL SeleccionarTecnico('".$name."','".$password."')";
	//Ejecutamos la petición al servidor
	$resultado = mysqli_query($conexion,$user) or die(mysqli_error($conexion));
	while ($b= mysqli_fetch_array($resultado)){
		if (($b['nombre']==$name)){
			$encontrado = 1;
			break;
		}
	}
	if($encontrado==1){
		echo '<br><div class="alert alert-success ">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Ahora puedes iniciar Sesión:</strong> '.$name.'.
		</div>';
	}else{
		echo '<br><div class="alert alert-danger ">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Error:</strong> Tus credenciales son erroneas.
		</div>';
	}
}
