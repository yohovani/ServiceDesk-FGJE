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

function verTecnicos(){
	Include 'conexion.php';
	$usuarios = "CALL SelectTecnicos()";
	$resultado = mysqli_query($conexion,$usuarios) or die(mysqli_error($conexion));

	echo"<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Password</th>
					<th>Administrador</th>
					<th>Cambiar priivilegios</th>
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
				echo "<td><form action='cambiarAdmin.php' method='post'>
						<input type='hidden' value='".$b['idTecnicos']."' name='isUsuario' id='name='isUsuario'>
						<input type='submit'class='btn btn-lg'  value='Cambiar'>	
					</form>
				</td>	
			</tr>";
	}
			echo"</tbody>
		</table>";
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
					<th>Eliminar</th>
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
				<td><form action='eliminarUsuario' method='post'>
						<input type='hidden' value='".$b['idUsuarios']."' name='isUsuario' id='name='isUsuario'>
						<input type='submit'class='btn btn-lg'  value='Eliminar'>	
					</form>
				</td>	
			</tr>";
	}
			echo"</tbody>
		</table>";
}