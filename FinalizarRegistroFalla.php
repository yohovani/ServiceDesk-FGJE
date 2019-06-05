<?php
    include "conexion.php";

    //0 par afinalizar 1 para no finalizar

    date_default_timezone_set('America/Mexico_City');
    $fecha = date("Y-m-d");
    $hora_fin = date("H:i:s");

    //Obteneemos el Id mediante el metodo POST
    $id = $_POST['idServicio'];
    echo $fecha;
    //Ejecutamos el procedimiento almacenado FinalizarServicio para actualizar el estaus del servicio
    $sql = "UPDATE `servicios` SET `fecha_fin` = '".$fecha."' ,`horaFin`= '".$hora_fin."' ,`finalizado`= 1 WHERE  `idServicios` = '".$id."'";
    //$sql = "CALL FinalizarServicio('".$id."','".$hora_fin."','".$fecha."')";
    //Hacemos la petición al servidor
    $ejecutar =  mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
//Redireccionamos una vez que ya se realizo la consulta hacia el index 
header('Location: index.php');