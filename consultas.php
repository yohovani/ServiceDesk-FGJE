<?php

switch ($_POST['funcion']){
	case 1:{
		verReportes();
		break;
	}
	case 2:{
		verUsuarios();
		break;
	}
	case 3:{
		verTecnicos();
		break;
	}
	case 4:{
		verEquipos();
		break;
	}
	case 5:{
		verCompras();
		break;
	}
	case 6:{
		verPrestamos();
		break;
	}
	case 8:{
		verAreas();
		break;
	}
}

function verReportes(){
	Include 'conexion.php';
	$registros = "SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,t.nombre,s.finalizado,a.nombre as area
	FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t INNER JOIN areas a INNER JOIN servicioarea sa ON s.idServicios = st.fk_idServicios 
	AND t.idTecnicos = st.fk_idTecnicos AND s.idServicios = sa.fk_idServicio AND a.idArea = sa.fk_idArea WHERE 1 ORDER BY s.idServicios";
	$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
	echo "<div class='container'>";
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
					<td>".$b['area']."</td>
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
					<td>".$b['area']."</td>
					<td>".$b['nombre']."</td>
					<td bgcolor='#16F409'>Si</td>
				";
		}
	}
			echo"</tbody>
		</table>
	</div>";
}

function verTecnicos(){
	Include 'conexion.php';
	$usuarios = "CALL SelectTecnicos()";
	$resultado = mysqli_query($conexion,$usuarios) or die(mysqli_error($conexion));
	echo "<div class='container'>";
	echo"<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Password</th>
					<th>Administrador</th>
					<th>Recepci&oacute;n</th>
					<th>Cambiar Administrador</th>
					<th>Cambiar Recepci&oacute;n</th>
				</tr>
			</thead>
			<tbody>";
	while($b= mysqli_fetch_array($resultado)){
		echo"<tr>
				<td>".$b['idTecnicos']."</td>
				<td>".$b['nombre']."</td>
				<td>".$b['password']."</td>";
		if($b['admin'] == false){
			echo"<td>No</td>";
		}else{
			echo"<td>Si</td>";
		}
		if($b['recepcion'] == false){
			echo"<td>No</td>";
		}else{
			echo"<td>Si</td>";
		}
			echo"<td>
					<form action='cambiarPrivilegios.php' method='post'>
						<input type='hidden' value='".$b['idTecnicos']."' name='idTecnico'>
						<input type='hidden' value='".$b['admin']."' name='admin'>
						<input type='submit'class='btn btn-lg'  value='Cambiar'>	
					</form>
				</td>	
				<td>
					<form action='cambiarPrivilegios.php' method='post'>
						<input type='hidden' value='".$b['idTecnicos']."' name='idTecnico'>
						<input type='hidden' value='".$b['recepcion']."' name='recepcion'>
						<input type='submit'class='btn btn-lg'  value='Cambiar'>	
					</form>
				</td>	
		</tr>";
		
	}
			echo"</tbody>
		</table>";
	echo "<div>";
}

function verUsuarios(){
	Include 'conexion.php';
	$usuarios = "CALL selectUsuarios()";
	$resultado = mysqli_query($conexion,$usuarios) or die(mysqli_error($conexion));

	echo"<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Apellidos</th>
					<th>Nombre de Usuario</th>
					<th>Area</th>
				</tr>
			</thead>
			<tbody>";
	while($b= mysqli_fetch_array($resultado)){
		echo"<tr>
				<td>".$b['idUsuarios']."</td>
				<td>".$b['nombre']."</td>
				<td>".$b['apellidos']."</td>
				<td>".$b['usuario']."</td>
				<td>".$b['area']."</td>
			</tr>";
	}
			echo"</tbody>
		</table>";
}

function verEquipos(){
	Include 'conexion.php';
	$usuarios = "CALL selectEquipoAdmin()";
	$resultado = mysqli_query($conexion,$usuarios) or die(mysqli_error($conexion));

	echo "<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Fecha</th>
					<th>Fecha Entrega</th>
					<th>Area</th>
					<th>Ext. Movil</th>
					<th>Servicio</th>
					<th>Equipo</th>
					<th>Finalizado</th>
					<th>Entregado</th>
					<th>Usuario</th>
					<th>Tecnico</th>
				</tr>
			</thead>
			<tbody>";
	while($b= mysqli_fetch_array($resultado)){
		echo"<tr>
				<td>".$b['idEquipo']."</td>
				<td>".$b['fecha']."</td>
				<td>".$b['fechaEntrega']."</td>
				<td>".$b['area']."</td>
				<td>".$b['extencionMovil']."</td>
				<td>".$b['descripcionSrv']."</td>
				<td>".$b['descripcionEquipo']."</td>";
				if($b['finalizado'] == true){
					echo "<td bgcolor='#16F409'>Si</td>";
				}else{
					echo "<td bgcolor='#FD8A00'>No</td>";
				}
				if($b['entregado'] == true){
					echo "<td bgcolor='#16F409'>Si</td>";
				}else{
					echo "<td bgcolor='#FD8A00'>No</td>";
				}
				echo "<td>".$b['usuario']."</td>"
					. "<td>".$b['nombre']."</td>";
		echo "</tr>";
	}
			echo"</tbody>
		</table>";
}

function verCompras(){
	Include 'conexion.php';
	$usuarios = "CALL selectComprasAdmin()";
	$resultado = mysqli_query($conexion,$usuarios) or die(mysqli_error($conexion));

	echo "<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Fecha</th>
					<th>Area</th>
					<th>Articulo</th>
					<th>Dictamen</th>
					<th>Planeaci&oacute;n</th>
					<th>Usuario</th>
					<th>Resuelto</th>
				</tr>
			</thead>
			<tbody>";
	while($b= mysqli_fetch_array($resultado)){
		echo"<tr>
				<td>".$b['idCompras']."</td>
				<td>".$b['fecha']."</td>
				<td>".$b['area']."</td>
				<td>".$b['articulo']."</td>
				<td>".$b['dictamen']."</td>
				<td>".$b['planeacion']."</td>
				<td>".$b['usuario']."</td>";
				if($b['resuelto'] == true){
					echo "<td bgcolor='#16F409'>Si</td>";
				}else{
					echo "<td bgcolor='#FD8A00'>No</td>";
				}
		echo "</tr>";
	}
			echo"</tbody>
		</table>";
}

function verPrestamos(){
	Include 'conexion.php';
	$usuarios = "CALL selectPrestamosAdmin()";
	$resultado = mysqli_query($conexion,$usuarios) or die(mysqli_error($conexion));

	echo "<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Fecha de Prestamo</th>
					<th>Descripci&oacute;n</th>
					<th>Motivo</th>
					<th>Fecha de Entrega</th>
					<th>Area</th>
					<th>Usuario</th>
					<th>Resuelto</th>
				</tr>
			</thead>
			<tbody>";
	while($b= mysqli_fetch_array($resultado)){
		echo"<tr>
				<td>".$b['idPrestamo']."</td>
				<td>".$b['fechaActual']."</td>
				<td>".$b['descripcion']."</td>
				<td>".$b['motivo']."</td>
				<td>".$b['fechaEntrega']."</td>
				<td>".$b['nombre']."</td>
				<td>".$b['area']."</td>";
				if($b['entregado'] == true){
					echo "<td bgcolor='#16F409'>Si</td>";
				}else{
					echo "<td bgcolor='#FD8A00'>No</td>";
				}
		echo "</tr>";
	}
			echo"</tbody>
		</table>";
}

function verAreas(){
	include "conexion.php";
	//Utilizamos el metodo almacenado para seleccionar las areas
	$mysqli = "Call SelectAreas()";
	//Ejecutamos la petición al servidor
	$resultado = mysqli_query($conexion,$mysqli) or die(mysqli_error($conexion));
	while ($area= mysqli_fetch_array($resultado)){
		echo "<option value='".$area['idArea']."' size>".utf8_encode($area['nombre'])."</option>";
		$i=$area['idArea'];
	}
	while ($area= mysqli_fetch_array($resultado)){
		echo "<label> ".($area['nombre'])."</label>";
	}
}