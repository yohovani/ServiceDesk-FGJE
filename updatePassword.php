<?php
	session_start();
	if(isset($_SESSION['admin'])){
		include 'conexion.php';
		$sql = "UPDATE `tecnicos` SET `password`='".$_POST['Newpassword']."' WHERE `idTecnicos` = '".$_SESSION['idUser']."'";
		$resultado=mysqli_query($conexion,$sql)or die(mysqli_error($conexion));
		header('Location: index.php');
	}
