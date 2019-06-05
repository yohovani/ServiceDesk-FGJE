<?php

include 'conexion.php';
$sql = "UPDATE `servicios` SET `mostrar`=false, `finalizadoTecnico`=false WHERE `idServicios` = '".$_POST['idServicio']."'";
$ejecutar =  mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
//Redireccionamos una vez que ya se realizo la consulta hacia el index 
header('Location: index.php');
