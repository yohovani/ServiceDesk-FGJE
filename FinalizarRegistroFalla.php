<?php
include "conexion.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set('America/Mexico_City');
$fecha = date("y:m:d");
$hora_fin = date("H:i:s");

//Obteneemos el Id mediante el metodo POST
$id = $_POST['idServicio'];
//Ejecutamos el procedimiento almacenado FinalizarServicio para actualizar el estaus del servicio
$sql = "CALL FinalizarServicio('".$id."','".$hora_fin."','".$fecha."')";
//Hacemos la petición al servidor
$ejecutar =  mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
//Redireccionamos una vez que ya se realizo la consulta hacia el index 
header('Location: index.php');