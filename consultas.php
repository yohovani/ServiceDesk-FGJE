<?php
echo ":v";
if($_POST['funcion'] == 1){
	verReportes();
}

function verReportes(){
	Include 'conexion.php';
	$registros = "CALL selectRegistrosServicios()";
	$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));

	echo"<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Fecha</th>
					<th>Fecha Fin</th>
					<th>Hora Inicio</th>
					<th>Hora Fin</th>
					<th>Tipo de Servicio</th>
					<th>Descripci&oacute;n</th>
					<th>Area</th>
					<th>Tecnico</th>
					<th>Finalizado</th>
				</tr>
			</thead>
			<tbody>";
	while($b= mysqli_fetch_array($resultado)){
		if($b['finalizado'] == false){
			echo"<tr>
					<td>".$b['idServicios']."</td>
					<td>".$b['fecha']."</td>
					<td>".$b['fecha_fin']."</td>
					<td>".$b['horaInicio']."</td>
					<td>".$b['horaFin']."</td>
					<td>".$b['tipoServicio']."</td>
					<td>".$b['descripcion']."</td>
					<td>".$b['ubicacion']."</td>
					<td>".$b['nombre']."</td>
					<td bgcolor='#FD8A00'>No</td>
				";
		}else{
			echo"<tr>
					<td>".$b['idServicios']."</td>
					<td>".$b['fecha']."</td>
					<td>".$b['fecha_fin']."</td>
					<td>".$b['horaInicio']."</td>
					<td>".$b['horaFin']."</td>
					<td>".$b['tipoServicio']."</td>
					<td>".$b['descripcion']."</td>
					<td>".$b['ubicacion']."</td>
					<td>".$b['nombre']."</td>
					<td bgcolor='#16F409'>Si</td>
				";
		}
	}
			echo"</tbody>
		</table>";
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

