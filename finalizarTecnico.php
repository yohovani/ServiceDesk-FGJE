<?php
if(!preg_match("[']",$_POST['solucionServicioTecnico']) && !preg_match('["]',$_POST['solucionServicioTecnico']) && !preg_match('[<]',$_POST['solucionServicioTecnico']) && !preg_match('[>]',$_POST['solucionServicioTecnico'])){
	include 'conexion.php';
	$sql = "UPDATE `servicios` SET `finalizadoTecnico`=true,`solucion`='".$_POST['solucionServicioTecnico']."',`mostrar`=true WHERE `idServicios` = '".$_POST['idServicio']."'";
	$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	header('Location: index.php');
}else{
	ob_start();
		header('refresh:3; url=index.php');
		echo 'por seguridad no se permiten caracteres especiales';
	ob_end_flush();
}