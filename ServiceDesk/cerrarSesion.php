<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$redireccionamiento;
if(isset($_SESSION['admin'])){
	$redireccionamiento = 1;
}else{
	$redireccionamiento = 2;
}
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
if($redireccionamiento == 1){
	header('Location: SesionTecnicos.php');
}else
	header('Location: index.php');
