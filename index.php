<!DOCTYPE html>
<html lang="en">
	<head>
		<title>FGJE Unidad de Inform&aacute;tica</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="scripts.js"></script>
	</head>
	<body>
		<nav class="navbar" style="background-color:#494983;">

			<?php
				session_start();
				if(isset($_SESSION['user'])){
					if(isset($_SESSION['apellidos']))
						echo "<strong style='color: white;'>FGJE - ".$_SESSION['nombre']." ".$_SESSION['apellidos']."</strong>";
					else
						echo "<strong style='color: white;'>FGJE - ".$_SESSION['nombre']."</strong>";
				}else{
					echo "<strong style='color: white;'>FGJE - Visitante</strong>";
				}
				
			?>
			<?php
				if(!isset($_SESSION['user']))
					echo "<div id='contenedor' style='align-content: flex-end'>
						<button style='color:white' class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbar'>
							Registrarse
						</button>
						<button style='color:white' class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbar2'>
							Iniciar Sesion
						</button>
					</div>";
				else{
					if(isset($_SESSION['admin'])){
						if($_SESSION['admin'] == true){
							echo"<button style='color:white' class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbarRT'>
								Registrar T&eacute;cnicos
							</button>";
						}
					}
					echo "<form class='form-horizontal' action='cerrarSesion.php' method='post'>
								<center><button style='color:white' class='navbar-toggler' data-toggle='collapse type='submit' >Cerrar Sesi&oacute;n</button></center>
							</form>";
				}
			?>

			<!-- Modal para Registrarse Usuarios Comunes-->
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">

							<h4 class="modal-title">Registro</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="Registro.php" method="post">
								<!- Nombre->
								<div class="form-group">
									<label class="control-label col-sm-2" >Nombre:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required id="nombre" onKeyUp="nameUser()">
									</div>
								</div>
								<!- Apellidos->
								<div class="form-group">
									<label class="control-label col-sm-2" >Apellidos:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="apellidos" placeholder="Apellidos" id="apellidos" onKeyUp="nameUser()">
									</div>
								</div>
								<!- Usuario->
								<div class="form-group">
									<label class="control-label col-sm-2" id="usuario">Usuario:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="user" placeholder="Nombre de usuario" id="user">
									</div>
								</div>
								<!- Area->
								<div class="form-group">
									<label class="control-label col-sm-2" id="area">Area:</label>
									<div class="col-sm-10">
										<select class="form-control" name="area" id="area">
											<?php
												include "conexion.php";
												//Utilizamos el metodo almacenado para seleccionar las areas
												$mysqli = "Call SelectAreas()";
												//Ejecutamos la petición al servidor
												$resultado = mysqli_query($conexion,$mysqli) or die(mysqli_error($conexion));
												while ($area= mysqli_fetch_array($resultado)){
													echo "<option value='".$area['idArea']."' size>".utf8_encode($area['nombre'])."</option>";
												}
											?>
										</select>

									</div>
								</div>
								<!-Botón enviar->
								<div class="form-group"> 
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default">Enviar</button>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">

						</div>
					</div>
				</div>
			</div>
			
			<!-- Modal para Registrarse Usuarios Técnicos-->
			<div class="collapse navbar-collapse" id="collapsibleNavbarRT">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">

							<h4 class="modal-title">Registro</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="Registro.php" method="post">
								<!- Nombre->
								<div class="form-group">
									<label class="control-label col-sm-2" >Nombre de usuario:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nombre" placeholder="Nombre de usuario" required id="nombre" onKeyUp="nameUser()">
									</div>
								</div>
								<!- Password->
								<div class="form-group">
									<label class="control-label col-sm-2" id="pass">Contrase&ntilde;a:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" name="password" placeholder="Contrase&ntilde;a" id="password" >
									</div>
								</div>
								<!-Confirmación del Password->
								<div class="form-group">
									<label class="control-label col-sm-2" id="pass">Confirma Contrase&ntilde;a:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" name="password2" placeholder="Repite la Contrase&ntilde;a" id="password2" onKeyUp="verificarPassword()">
										<input type="text" class="form-control" id="resultado">
									</div>
								</div>
								<!-Botón enviar->
								<div class="form-group"> 
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" id="btnEnviar">Enviar</button>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">

						</div>
					</div>
				</div>
			</div>
			<!-- Modal para Iniciar Sesion-->
			<div class="collapse navbar-collapse" id="collapsibleNavbar2">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Iniciar Sesi&oacute;n</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="InicioSesion.php" method="post">
								<div class="form-group">
									<label class="control-label col-sm-2" >Usuario Normal:</label>
									<div class="col-sm-10">
                                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapsibleNavbar4">Iniciar Sesi&oacute;n</button>
      
										<!--<input type="text" class="form-control" name="user" id="usuario" placeholder="Usuario" required>-->
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Administrador:</label>
									<div class="col-sm-10"> 
                                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapsibleNavbar3">Iniciar Sesi&oacute;n</button>

										<!--<input type="password" class="form-control" name="password" id="pass" placeholder="Contrase&ntilde;a" required>-->
									</div>
								</div>
								<!--<div class="form-group"> 
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default">Iniciar Sesi&oacute;n</button>
									</div>
								</div>-->
							</form>
						</div>
					</div>
				</div>
			</div>
            <!-- Modal para Iniciar Sesion Admin-->
            <div class="collapse navbar-collapse" id="collapsibleNavbar3">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Iniciar Sesi&oacute;n Técnico</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="InicioSesion.php" method="post">
								<div class="form-group">
									<label class="control-label col-sm-2" >Usuario:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="user" id="usuario" placeholder="Usuario" required>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Contrae&ntilde;a:</label>
									<div class="col-sm-10"> 
										<input type="password" class="form-control" name="password" id="pass" placeholder="Contrase&ntilde;a" required>
									</div>
								</div>
								<div class="form-group"> 
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default">Iniciar Sesi&oacute;n</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
            <!-- Modal para Iniciar Sesion Normal-->
            <div class="collapse navbar-collapse" id="collapsibleNavbar4">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Iniciar Sesi&oacute;n Normal</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="InicioSesion.php" method="post">
								<div class="form-group">
									<label class="control-label col-sm-2" >Usuario:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="user" id="usuario" placeholder="Usuario" required>
									</div>
								</div>
								<!--<div class="form-group">
									<label class="control-label col-sm-2">Contrae&ntilde;a:</label>
									<div class="col-sm-10"> 
										<input type="password" class="form-control" name="password" id="pass" placeholder="Contrase&ntilde;a" required>
									</div>
								</div>-->
								<div class="form-group"> 
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default">Iniciar Sesi&oacute;n</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<br>
		
		<!-- Modal para logout-->
		<div id="logout" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Salir</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="cerrarSesion.php" method="post">
							<center><button type="submit" class="btn btn-default">Salir</button></center>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="container">
			<?php
				//Adminsitradores
				if(isset($_SESSION['admin'])){
					if($_SESSION['admin'] == true){
					echo " <div> 
					<center>
					<h2>Reportes</h2>
					<!-- Trigger the modal with a button -->
					<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#Reportes'>Ver</button>
					</center></div>";
					}
				}else{
					if(isset($_SESSION['user'])){
						echo "<center>";
						echo"<table class='table table-hover'>
								<thead>
									<tr>
										<th>
											<div> 
												<!-- Trigger the modal with a button -->
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#RegistroFallas'>Reportar Fallas</button>
											</div>
										</th>
										<th>
											<div> 
												<!-- Trigger the modal with a button -->
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#RegistroPrestamo'>Solicitar Prestamos</button>
											</div>
										</th>
										<th>
											<div> 
												<!-- Trigger the modal with a button -->
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#RegistroCompras'>Compras relacionadas con tecnolog&iacute;a</button>
											</div>
										</th>
									</tr>
								</thead>
							</table>";
						echo "</center>";
					}
				}
			?>
		</div>

		<!-- Container (Portfolio Section) -->
		<?php
		if(!isset($_SESSION['user'])){
			echo"<div id='portfolio' class='container-fluid text-center bg-grey'>
				<div id='myCarousel' class='carousel slide text-center' data-ride='carousel'>
					<!-- Indicators -->
					<ol class='carousel-indicators'>
						<li data-target='#myCarousel' data-slide-to='0' class='active'></li>
						<li data-target='#myCarousel' data-slide-to='1'></li>
						<li data-target='#myCarousel' data-slide-to='2'></li>
					</ol>
					<!-- Wrapper for slides -->
					<div class='carousel-inner' role='listbox'>";		
			echo"<img src='img/logo.png'>";
			echo"<a class='left carousel-control' href='#myCarousel' role='button' data-slide='prev'>
					<span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
					<span class='sr-only'>Anterior</span>
				</a>
				<a class='right carousel-control' href='#myCarousel' role='button' data-slide='next'>
					<span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
					<span class='sr-only'>Siguiente</span>
				</a>
			</div>
		</div>
	</div>";
		}
					?>
		
		
<!-- Modal para ver Reportes-->
	<div id='Reportes' class='modal fade' role='dialog'>
		<div class='modal-dialog modal-lg'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<h4 class='modal-title'>Monitoreo de Reportes</h4>
				</div>
				<div class='modal-body'>
					<?php
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
						?>
				</div>
				<div class='modal-footer'>
				    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
				</div>
			</div>
		</div>
	</div>

<!-- Modal para registrar Prestamos-->
	<div id='RegistroPrestamo' class='modal fade' role='dialog'>
		<div class='modal-dialog'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<h4 class='modal-title'>Prestamos</h4>
				</div>
				<div class='modal-body'>
					<?php
						echo "<form class='form-horizontal' action='fallas.php' method='post'>
							<!- Descripcion->
							<div class='form-group'>
								<label class='control-label col-sm-2' >Descripción:</label>
								<div class='col-sm-10'>
									<textarea class='form-control' rows='5' id='descripcion' placeholder='Ejemplo: Laptop con cargador'></textarea>
								</div>
							</div>
							<!- Motivo->
							<div class='form-group'>
								<label class='control-label col-sm-2' id='pass'>Motivo:</label>
								<div class='col-sm-10'>
									<textarea class='form-control' rows='5' id='motivo' placeholder='Ejemplo: Prestamo'></textarea>
								</div>
							</div>
							<!-Botón enviar->
							<div class='form-group'> 
								<div class='col-sm-offset-2 col-sm-10'>
									<button type='submit' class='btn btn-default' id='btnEnviar'>Enviar</button>
								</div>
							</div>
						</form>";
						?>
				</div>
				<div class='modal-footer'>
				    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
				</div>
			</div>
		</div>
	</div>

<!-- Modal para registrar Fallas-->
	<div id='RegistroFallas' class='modal fade' role='dialog'>
		<div class='modal-dialog'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<h4 class='modal-title'>Reporte de Fallas</h4>
				</div>
				<div class='modal-body'>
					<?php
						echo "<form class='form-horizontal' action='fallas.php' method='post'>
								<!- Area->
								<div class='form-group'>
									<label class='control-label col-sm-2' >Area:</label>
									<div class='col-sm-10'>
										<input type='text' class='form-control' name='area' placeholder='Area' value='".$_SESSION['area']."' required id='nombre'>
									</div>
								</div>
								<!- Tipo de problema->
								<div class='form-group'>
									<label class='control-label col-sm-2' id='pass'>Tipo de problema:</label>
									<div class='col-sm-10'>
										<select class='form-control' name='tipo' id='tipo'>
											<option value='Internet'>Internet</option>
											<option value='Impresora'>Impresora</option>
											<option value='Word'>Word</option>
											<option value='Excel'>Excel</option>
											<option value='Permisos de Red'>Permisos de Red</option>
											<option value='Conectividad'>Conectividad</option>
											<option value='Otro'>Otro</option>
										</select>
									</div>
								</div>
								<!-Descripcion de la falla->
								<div class='form-group'>
									<label class='control-label col-sm-2' id='pass'>Descripci&oacute;n de la falla:</label>
									<div class='col-sm-10'>
										<textarea class='form-control' rows='5' id='descripcion' name='descripcion'></textarea>
									</div>
								</div>
								<!-Botón enviar->
								<div class='form-group'> 
									<div class='col-sm-offset-2 col-sm-10'>
										<button type='submit' class='btn btn-default' id='btnEnviar'>Enviar</button>
									</div>
								</div>
							</form>";
					?>
				</div>
				<div class='modal-footer'>
				    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<!-- Modal para registrar Compras-->
	<div id='RegistroCompras' class='modal fade' role='dialog'>
		<div class='modal-dialog'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<h4 class='modal-title'>Reporte de Compra</h4>
				</div>
				<div class='modal-body'>
					<?php
						echo "<form class='form-horizontal' action='fallas.php' method='post'>
								<!- Articulo->
								<div class='form-group'>
									<label class='control-label col-sm-2' >Articulo:</label>
									<div class='col-sm-10'>
										<textarea class='form-control' rows='5' id='Articulo' placeholder='Ejemplo: Tarjeta de red inalambrica'></textarea>
									</div>
								</div>
								<!- Planeaciión->
								<div class='form-group'>
									<label class='control-label col-sm-2' id='pass'>Planeaci&oacute;n:</label>
									<div class='col-sm-10'>
										<textarea class='form-control' rows='5' id='motivo' placeholder='Ejemplo: 1 mes'></textarea>
									</div>
								</div>
								<!-Botón enviar->
								<div class='form-group'> 
									<div class='col-sm-offset-2 col-sm-10'>
										<button type='submit' class='btn btn-default' id='btnEnviar'>Enviar</button>
									</div>
								</div>
							</form>";
					?>
				</div>
				<div class='modal-footer'>
				    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<?php
		if(isset($_SESSION['user'])){
			 echo "<div class='text-center'>
						<h2>Reportes no resueltos</h2>
						<h4></h4>
					</div>
					<div class='row slideanim'>";
		Include 'conexion.php';
		$sql="CALL SelectServiciosUsuario('".$_SESSION['idUser']."')";
		$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
		while ($b = mysqli_fetch_array($resultado)){
			echo"<div class='col-sm-4 col-xs-12'>
					<div class='panel panel-default text-center'>
						<div class='panel-heading'>
							<h1>".$b['tipoServicio']."</h1>
						</div>
						<div class='panel-body'>
							<p><strong>Fecha: </strong> ".$b['fecha']."</p>
							<p><strong>Descripci&oacute;n</strong> ".$b['descripcion']."</p>
							<p><strong>Area: </strong> ".$b['ubicacion']."</p>
							<p><strong>Estatus: </strong>No Finalizado</p>";

							$idRegistro = $b['idServicios'];

			echo "</div>
					<div class='panel-footer'>
						<form action='FinalizarRegistroFalla.php' method='post'>
							<input type='submit' class='btn btn-lg' value='Terminado' />
							<input type='hidden' name='idServicio' id='idServicio' value='$idRegistro'/>
					</form>";
			echo "</div>
					</div>
				</div> ";
		}
		}
	?>

<! Ver registros no finalizados ->
<?php
	Include 'conexion.php';
	
	if(isset($_SESSION['admin'])){
		if($_SESSION['admin'] == true){
			$registros = "CALL SelectServiciosNoFinalizados()";
			$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
		}else{
			$registros = "CALL SelectServiciosNoFinalizadosIndividuales('".$_SESSION['idUser']."')";
			$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
		}
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
		}
				echo"</tbody>
			</table>";
	}
	?>

<footer class="container-fluid text-center" style="background-color:gold;">
  <p style='color:white'>WebDesign By Servicio Social</p>
</footer>
	</body>
</html>