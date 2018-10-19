<?php
	
	/*$conectar=@mysql_connect("localhost","root","");
	if(!$conectar){
		echo"No Se Pudo Conectar Con El Servidor";
	}else{
		$base=mysql_select_db('servicedesk');
		if(!$base){
			echo"No Se Encontro La Base De Datos";			
		}
	}
	*/
	include "conexion.php";
	$pregunta=$_POST['p'];
	$respuesta=$_POST['r'];
	$sql="INSERT INTO `preguntas`(`pregunta`,`respuesta`) VALUES ('".$pregunta."','".$respuesta."')";
	$ejecutar=mysqli_query($conexion,$sql)or die(mysqli_error($conexion));
	header('Location: /ServiceDesk/index.php');
/*
	if(!$ejecutar){
		echo"Hubo Algun Error";
	}else{
		echo"Datos Guardados Correctamente<br><a href='index.php'>Volver</a>";
	}
	*/
	mysqli_close($conexion)
	
     
?>