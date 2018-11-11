<?php
	session_start();
	if($_POST['tipo'] == 1){
		actualizarPregunta();
	}else{
		eliminarPregunta();
	}

	function actualizarPregunta(){
		if(isset($_SESSION['admin'])){
			if($_SESSION['admin'] == true){
				include 'conexion.php';
				$sql = "UPDATE `preguntas` SET `pregunta`='".$_POST['pregunta']."',`respuesta`='".$_POST['respuesta']."' WHERE preguntas.id = '".$_POST['idPregunta']."'";
				$resultado=mysqli_query($conexion,$sql)or die(mysqli_error($conexion));
				header('Location: index.php');
			}
		}

	}
	
	function eliminarPregunta(){
		if(isset($_SESSION['admin'])){
			if($_SESSION['admin'] == true){
				include 'conexion.php';
				$sql = "DELETE FROM `preguntas` WHERE id ='".$_POST['idPregunta']."'";
				$resultado=mysqli_query($conexion,$sql)or die(mysqli_error($conexion));
				header('Location: index.php');
			}
		}

	}