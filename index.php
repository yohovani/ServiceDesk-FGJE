<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="shortcut icon" href="img/logoSD.png">
		<title>FGJE Unidad de Inform&aacute;tica</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<script src="scripts.js"></script>
	</head>
	<body>
		<nav class="navbar" style="background-color:#212650;">
			<?php
				session_start();
				if(isset($_SESSION['admin'])){
					echo "<meta http-equiv='refresh' content='60'/>";
				}
				if(isset($_SESSION['user'])){
					if(isset($_SESSION['apellidos']))
						echo "<strong style='color: white;'>FGJE - ".$_SESSION['nombre']." ".$_SESSION['apellidos']."</strong>";
					else
						echo "<button style='color:white' class='navbar-toggler' type='button' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Cambiar Contrase&ntilde;a' data-target='#cambiarPassword'>"
								. "<strong style='color: white;'>FGJE - ".$_SESSION['nombre']."</strong>"
							. "</button>";
				}else{
					echo "<strong style='color: white;'>FGJE - Visitante</strong>";
				}
			?>
			<?php
				if(!isset($_SESSION['user']))
					echo "<div id='contenedor' style='align-content: flex-end'>
						<button style='color:white' class='navbar-toggler' type='button' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Registrarte' data-target='#registro'>
							Registrarse
						</button>
						<button style='color:white' class='navbar-toggler' type='button' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Iniciar Sesi&oacute;n' data-target='#login'>
							Iniciar Sesión
						</button>
					</div>";
				else{
					if(isset($_SESSION['admin'])){
						if($_SESSION['admin'] == true){
							echo"<button style='color:white' class='navbar-toggler' type='button' data-toggle='modal' data-tooltip='tooltip' title='Click Aqui Para Registrar Tecnicos' data-target='#registroTecnicos'>
								Registrar T&eacute;cnicos
							</button>
							<button style='color:white' class='navbar-toggler' type='button' data-toggle='modal' data-tooltip='tooltip' title='Click Aqui Para Generar Archivo de Excel' data-target='#excel'>
								Generar Excel
							</button>";
						}
					}
					echo "<form class='form-horizontal' action='cerrarSesion.php' method='post'>
								<center><button style='color:white' class='navbar-toggler' data-toggle='collapse' type='submit'data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Cerrar Sesi&oacute;n' >Cerrar Sesi&oacute;n</button></center>
							</form>";
				}
			?>
		</nav>
		<!-- Modal para Registrarse Usuarios Comunes-->
		<div class="modal fade" id="registro">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Registro</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="registro.php" method="post">
							<!- Area->
							<div class="form-group">
								<label class="control-label col-sm-2" >Area:</label>
								<div class="col-sm-10" id="areasUsuario">
									<select class="form-control" name="area" id="area" onchange="areas()">
										<?php
											include "conexion.php";
											$i;
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
											echo "<option value='Otro' size>Otro</option>";
										?>
									</select>
									<div id="agregarAreas" hidden="true">
										<label>Agregue su Area:</label>
										<input type="text" id="newArea" name="newArea" class="form-control" placeholder="¿Cual es su area?">
										<button  class="btn btn-default" onclick="addArea()">Agregar</button>
									</div>
								</div>
							</div>
							<!- Nombre->
							<div class="form-group">
								<label class="control-label col-sm-2" >Nombre:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required id="nombre" >
								</div>
							</div>
							<!- Apellidos->
							<div class="form-group">
								<label class="control-label col-sm-2" >Apellidos:</label>
								<div class="col-sm-10">
									<input type="text" required class="form-control" name="apellidos" placeholder="Apellidos" id="apellidos" onkeyup="nameUser()">
								</div>
							</div>
							<!- Usuario->
							<div class="form-group">
								<label class="control-label col-sm-2" id="usuario" >Usuario:</label>
								<div id="resultadoNombreUsuario">
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
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
			</div>
				</div>
			</div>
		</div>
			
		<!-- Modal para Registrarse Usuarios Técnicos-->
		<div class="modal fade" id="registroTecnicos">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">

						<h4 class="modal-title">Registro</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="registro.php" method="post">
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
			
		<!-- Modal para Cambiar Password-->
		<div class="modal fade" id="cambiarPassword">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">

						<h4 class="modal-title">Cambiar Password</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="updatePassword.php" method="post">
							<!- Nombre->
							<div class="form-group">
								<label class="control-label col-sm-2" >Contrase&ntilde;a actual:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="passwordActual" placeholder="Contraseña actual" required id="passwordActual" onKeyUp="Password()">
									<?php
										echo "<input type='hidden' name='Actual'  id='Actual' value='".$_SESSION['password']."'>";
									?>
								</div>
							</div>
							<!- Password->
							<div class="form-group">
								<label class="control-label col-sm-2" id="pass">Contrase&ntilde;a:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="Newpassword" placeholder="Contrase&ntilde;a" id="Newpassword" >
								</div>
							</div>
							<!-Confirmación del Password->
							<div class="form-group">
								<label class="control-label col-sm-2" id="pass">Confirma Contrase&ntilde;a:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="Newpassword2" placeholder="Repite la Contrase&ntilde;a" id="Newpassword2" onKeyUp="Password()">
								</div>
							</div>
							<!-Botón enviar->
							<div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default" id="btnEnviarnewPassword" disabled="true">Enviar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">

					</div>
				</div>
			</div>
		</div>

		<!-- Modal para login-->
		<div id="login" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Iniciar Sesi&oacute;n</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
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
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit"  class="btn btn-default">Iniciar Sesi&oacute;n</button>
								</div>
							</div>
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal para Fechas Excel-->
		<div id="excel" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Configuraci&oacute;n del Archivo de Excel</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="excel.php" method="post">
							<div class="form-group">
								<h6 class="modal-title" >Delimitar Fecha:</h6>
								<div class="col-sm-10">
									<select id="excelOption" class="form-control" name="excelOption" onchange="excel()">
										<option value="2">Delimitar por fechas</option>
										<option value="1">Todos los registros</option>
									</select>
								</div>
								<center>
									<h6 class="modal-title" id="tfi">Fecha Inicio:</h6>
									<input type="date" class="datepicker" id="fecha1" name="fecha1"><br>
									<h6 class="modal-title" id="tff">Fecha Fin:</h6>
									<input type="date" class="datepicker" id="fecha2" name="fecha2"><br>
									<input type="hidden" value="1" name="confExcel" id="confExcel"> 
								</center>
							</div>
							<div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit"  class="btn btn-default">Generar Archivo</button>
								</div>
							</div>
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<?php
				//Adminsitradores
				if(isset($_SESSION['admin'])){
					if($_SESSION['admin'] == true){
						echo"<div class='container'>
							<table class='table table-hover'>
								<thead>
									<tr><center>
										<th align><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver los Reportes' data-target='#Reportes' onclick='verReportes()' value='1' name='verReportes' id='verReportes'>Ver Reportes</button></th>
										<th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver los Usuarios' data-target='#Usuarios' onclick='verUsuarios()' value='2' name='verUsuarios' id='verUsuarios'>Ver Usuarios</button></th>
										<th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver los Tecnicos' data-target='#Tecnicos' onclick='verTecnicos()' value='3' name='verTecnicos' id='verTecnicos'>Ver Tecnicos</button></th>
										<th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver los Equipos' data-target='#Equipos' onclick='verEquipos()' value='4' name='verEquipos' id='verEquipos'>Ver Equipos</button></th>
										<th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver las Compras' data-target='#Compras' onclick='verCompras()' value='5' name='verCompras' id='verCompras'>Ver Compras</button></th>
										<th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver los Prestamos' data-target='#Prestamos' onclick='verPrestamos()' value='6' name='verPrestamos' id='verPrestamos'>Ver Prestamos</button></th>
                                        <th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para preguntas' data-target='#Preguntas' onclick='verPreguntas()' value='7' name='verPreguntas' id='verPreguntas'>Preguntas</button></th>
                                        <th><button class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Modificar las Areas' data-target='#ModificarAreas' onclick='verAreas()' value='8' name='verModAreas' id='verModAreas'>Areas</button></th>
									</center><tr>
								<thead>
							</table>
							</div>";
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
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal'data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Reportar una Falla' data-target='#RegistroFallas'>Reportar Fallas</button>
											</div>
										</th>
										<th>
											<div> 
												<!-- Trigger the modal with a button -->
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Solicitar un Prestamo' data-target='#RegistroPrestamo'>Solicitar Prestamos</button>
											</div>
										</th>
										<th>
											<div> 
												<!-- Trigger the modal with a button -->
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Compras Relacionadas con la Tecnologia' data-target='#RegistroCompras'>Compras relacionadas con tecnolog&iacute;a</button>
											</div>
										</th>
										<th>
											<div> 
												<!-- Trigger the modal with a button -->
												<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Reportar un Equipo' data-target='#ReportarEquipo'>Reportar Equipo</button>
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

				<div class='carousel-inner' role='listbox'>";		
			echo"<img src='img/logo.png' width='755' height='395'>";

			echo"<a class='left carousel-control' href='#myCarousel' role='button' data-slide='prev'>
					<span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
					<span class='sr-only'>Anterior</span>
				</a>
				<a class='right carousel-control' href='#myCarousel' role='button' data-slide='next'>
					<span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
					<span class='sr-only'>Siguiente</span>
				</a>

			</div>
			<h1><strong style='color: black;'>Centro de atenci&oacute;n al usuario de la Coordinaci&oacute;n de Inform&aacute;tica</strong></h1>
			<h1>Fiscal&iacute;a General de Justicia del Estado de Zacatecas</h1>
			<h5>Te damos la bienvenida a este punto de contacto con el departamento de soporte t&eacute;cnico</h5>
		</div>
	</div>";
	
		echo"<br><center><button class='btn btn-info btn-lg' type='button' data-tooltip='tooltip' title='Click Aqui Para Descargar el Manual de usuario del sistema'>							
								<a style='color:white' href='Manual.pdf' download='Manual'>Manual de usuario</a>
							</button></center><br>";
		echo"<center><button class='btn btn-info btn-lg' type='button' data-tooltip='tooltip' title='Preguntas y soluciones frecuentes'>
		<a data-toggle='modal' data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Ver las preguntas mas frecuentes' data-target='#preguntasYrespuestas' name='verPreguntas y respuestas'>Preguntas Frecuentes</a>
		</button>
		</center><br>";
	}
	?>
		
	<!-- Modal para ver preguntas y respuestas-->
	<div id="preguntasYrespuestas" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Preguntas frecuentes</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<?php
						include('VerPreguntas.php');
					?>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Reportes-->
	<div id='Reportes' class='modal fade' role='dialog'>
		<div class='modal-dialog modal-lg'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<h4 class='modal-title'>Monitoreo de Reportes</h4>
				</div>
				<div class='table-responsive' id='reportesModal'>

				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Usuarios-->
	<div class="container">
		<div id='Usuarios' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Usuarios Registrados</h4>
					</div>
					<div class='container modal-body container' id='usuariosModal'>

					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Tecnicos-->
	<div class="container">
		<div id='Tecnicos' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Tecnicos Registrados</h4>
					</div>
					<div class='container modal-body container' id='tecnicosModal'>

					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Equipos-->
	<div class="container">
		<div id='Equipos' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Servicio de Equipos Registrados</h4>
					</div>
					<div class='table-responsive' id='equiposModal'>

					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Prestamos-->
	<div class="container">
		<div id='Prestamos' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Prestamos Registrados</h4>
					</div>
					<div class='table-responsive' id='prestamosModal'>

					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Areas-->
	<div class="container">
		<div id='ModificarAreas' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Modificar Areas</h4>
					</div>
					<div class='table-responsive' id='AreasModal'>
						<select class="form-control" name="areaMod" id="areaMod" onchange="MostrarFormAreas()">
							
						</select>
						<div id="MAA">
							
						</div>
						<div id="ModificarAreasFormulario" hidden="true">
							<table class="table">
								<br><h4>Modifique el Area:</h4>
								<thead>
									<tr>
										<th>Id</th>
										<th>Valor</th>
										<th>Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><input  disabled="true" size="" type="text" id="IdModificarAreaAdmin" name="ModificarAreaAdmin" class="form-control"></th>
										<th>
											<div id="areaResultado">

											</div>
										</th>
										<th><button  class="btn btn-default" onclick="ModificarAreas()" data-dismiss="alert" aria-label="Close">Modificar</button></th>
										<th></th>
									</tr>
								</tbody>
								
							</table>
						</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para ver Compras-->
	<div class="container">
		<div id='Compras' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Compras Registrados</h4>
					</div>
					<div class='table-responsive' id='comprasModal'>

					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- Modal para Preguntas-->
    <div class="container">
		<div id='Preguntas' class='modal fade' role='dialog'>
			<div class='modal-dialog modal-lg'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Preguntas</h4>
					</div>
					<div class='table-responsive' id='comprasModal'>
						<h4>Registrar Preguntas</h4>
                        <form action="Preguntas.php" method="post">
                        <table class="table">
                    
  <thead>
      
    <tr>
      
      <th scope="col">Pregunta</th>
      <th scope="col">Respuesta</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      
      <td><input type="text"class="form-control" name="p" id="p" /></td>
      <td><input type="text"class="form-control" name="r" id="r" /></td>
     
    </tr>
    
    
  </tbody>
                        
                    
</table>
                            <button type='submit' class='btn btn-default'>enviar</button>
                            </form>
					</div>
					<div>
						<h4>Editar/Eliminar preguntas</h4> 
						
							<?php
								if(isset($_SESSION['admin'])){
									if($_SESSION['admin'] == true){
										include 'conexion.php';
										 $sqlPreguntas = "Select * FROM preguntas";
										 $resultado=mysqli_query($conexion,$sqlPreguntas)or die(mysqli_error($conexion));
										 while($b = mysqli_fetch_array($resultado)){
											 echo '<table class="table">
													<thead>
													   <tr>
														   <th scope="col">Pregunta</th>
														   <th scope="col">Respuesta</th>
														   <th scope="col">Actulizar</th>
														   <th scope="col">Eliminar</th>
													   </tr>
												   </thead>
												   <tbody>
													   <tr><form action="actualizarPregunta.php" method="post">
																<td><input type="text" id="pregunta" name ="pregunta" class="form-control" value="'.$b['pregunta'].'"></td>
																<td><input type="text" id="respuesta" name ="respuesta" class="form-control" value="'.$b['respuesta'].'"></td>
																<input type="hidden" id="tipo" name ="tipo" value="1">
																	<input type="hidden" id="idPregunta" name ="idPregunta" value="'.$b['id'].'">
																<td><button type="submit" class="btn btn-default">Actualizar</button></td>
															</form>
															<form action="actualizarPregunta.php" method="post">
																<input type="hidden" id="tipo" name ="tipo" value="2">
																<input type="hidden" id="idPregunta" name ="idPregunta" value="'.$b['id'].'">
																<td><button type="submit" class="btn btn-default">Eliminar</button></td>
															</form>
													   </tr>
												   </tbody>
												</table>';
										 }
									}
								}
							?>
						</form>
					</div>
					<div class='modal-footer'>
                        
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
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
							echo "<form class='form-horizontal' action='prestamos.php' method='post'>
								<!- Descripcion->
								<div class='form-group'>
									<label class='control-label col-sm-2' >Descripción:</label>
									<div class='col-sm-10'>
										<textarea class='form-control' rows='5' id='descripcion' name='descripcion' placeholder='Ejemplo: Laptop con cargador'></textarea>
									</div>
								</div>
								<!- Motivo->
								<div class='form-group'>
									<label class='control-label col-sm-2' id='pass'>Motivo:</label>
									<div class='col-sm-10'>
										<textarea class='form-control' rows='5' id='motivo' name='motivo' placeholder='Ejemplo: Prestamo'></textarea>
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
											<input type='text' class='form-control' name='area' placeholder='Area' value='".  utf8_encode($_SESSION['area'])."' required id='nombre'>
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
	<!-- Modal para registrar Equipo-->
		<div id='ReportarEquipo' class='modal fade' role='dialog'>
			<div class='modal-dialog'>
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title'>Reporte de Fallas</h4>
					</div>
					<div class='modal-body'>
						<?php
							echo "<form class='form-horizontal' action='reportarEquipo.php' method='post'>
									<!- Area->
									<div class='form-group'>
										<label class='control-label col-sm-2' >Area:</label>
										<div class='col-sm-10'>
											<input type='text' class='form-control' name='area' placeholder='Area' value='".$_SESSION['area']."' required id='nombre'>
										</div>
									</div>
									<!- extencion Movil->
									<div class='form-group'>
										<label id='pass'>Extenci&oacute;n Movil:</label>
										<div class='col-sm-10'>
											<input type='text' class='form-control' name='emovil' placeholder='Extenci&oacute;n Movil' id='emovil'>
										</div>
									</div>
									<!-Descripcion de la falla->
									<div class='form-group'>
										<label id='pass'>Descripci&oacute;n de la falla:</label>
										<div class='col-sm-10'>
											<textarea class='form-control' rows='5' id='descripcionServ' placeholder='Ejemplo: El equipo no enciende' name='descripcionServ'></textarea>
										</div>
									</div>
									<!-Descripcion del equipo->
									<div class='form-group'>
										<label id='pass'>Descripci&oacute;n del equipo:</label>
										<div class='col-sm-10'>
											<textarea class='form-control' rows='5' id='descripcionEquipo' name='descripcionEquipo' placeholder='Ejemplo: LAPTOP HP NEGRA'></textarea>
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
							echo "<form class='form-horizontal' action='compras.php' method='post'>
									<!- Compra->
									<div class='form-group'>
										<label class='control-label col-sm-2' >Articulo:</label>
										<div class='col-sm-10'>
											<textarea class='form-control' rows='5' id='articulo' name='articulo' placeholder='Ejemplo: Tarjeta de red inalambrica'></textarea>
										</div>
									</div>
									<!- Dictamen->
									<div class='form-group'>
										<label class='control-label col-sm-2' id='pass'>Dictamen:</label>
										<div class='col-sm-10'>
											<textarea class='form-control' rows='5' id='dictamen' name='dictamen' placeholder='Ejemplo: No tiene, Se cambia cada x tiempo'></textarea>
										</div>
									</div>
									<!- Planeaciión->
									<div class='form-group'>
										<label class='control-label col-sm-2' id='pass'>Planeaci&oacute;n:</label>
										<div class='col-sm-10'>
											<textarea class='form-control' rows='5' id='planeacion' name='planeacion' placeholder='Ejemplo: 1 mes'></textarea>
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

	<! Seccion para que el usuario pueda ver los reportes que aun no se han resuelto->
		<?php
			if(isset($_SESSION['user']) && !isset($_SESSION['admin'])){
				include 'conexion.php';
				$sqlNotificar = "CALL selectServiciosNotify('".$_SESSION['idUser']."')";
				$resultado = mysqli_query($conexion,$sqlNotificar) or die(mysqli_error($conexion));
				if(mysqli_num_rows($resultado) > 0){
					while ($b = mysqli_fetch_array($resultado)){
						$fecha=$b['fecha'];
						$Servicio=$b['tipoServicio'];
						$idRegistro=$b['idServicios'];

						echo '<script>';
							echo'toastr.warning("¿Es correcto?<form action='."FinalizarRegistroFalla.php".' method='."post".'><input type='."hidden".' name='."idServicio".' id='."idServicio".' value='."$idRegistro".'/><input type='."submit".' data-tooltip='."'tooltip'".' data-placement='."bottom".'  class='."btn btn-lg".' value='."Si".' /></form>'
									. '<br><form action='."registroNoFinalizado.php".' method='."post".'><input type='."hidden".' name='."idServicio".' id='."idServicio".' value='."$idRegistro".'/><input type='."submit".' data-tooltip='."'tooltip'".' data-placement='."bottom".'  class='."btn btn-lg".' value='."No".' /></form>","Servicio finalizado por el tecnico en Fecha: '.$fecha.' , Tipo de servicio: '.$Servicio.'",{
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-full-width",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": 0,"extendedTimeOut": 0,
								"showEasing": "swing","hideEasing": "linear",
								"showMethod": "fadeIn","hideMethod": "fadeOut",
								"tapToDismiss": false});
							</script>';

					}
				}
				
				mysqli_free_result($resultado);
				mysqli_close($conexion);
				unset($resultado,$conexion);
				echo "<div class='text-center'>
							<h2>Reportes no resueltos</h2>
							<h4></h4>
						</div>
						<div class='row slideanim'>";
			Include 'conexion.php';
			$sql="CALL SelectServiciosUsuario('".$_SESSION['idUser']."')";
			$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			if(mysqli_num_rows($resultado) == 0){
				echo "<div class='container text-center'><h6>No se encontraron registros</h6></div>";
			}else{
				while ($b = mysqli_fetch_array($resultado)){
					echo"<div class='col-sm-4 col-xs-12'>
							<div class='panel panel-default text-center'>
								<div class='panel-heading'>
									<h1>".$b['tipoServicio']."</h1>
								</div>
								<div class='panel-body'>
									<p><strong>Fecha: </strong> ".$b['fecha']."</p>
									<p><strong>Descripci&oacute;n</strong> ".$b['descripcion']."</p>
									<p><strong>Area: </strong> ".$b['area']."</p>
									<p><strong>Estatus: </strong>No Finalizado</p>";
									$idRegistro = $b['idServicios'];
					echo "</div>
							<div class='panel-footer'>
								<form action='FinalizarRegistroFalla.php' method='post'>
									<input type='submit'data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Terminar' class='btn btn-lg' value='Terminado' />
									<input type='hidden' name='idServicio' id='idServicio' value='$idRegistro'/>
							</form>";
					echo "</div>
							</div>
						</div> ";
				}
			}
			echo "</div>";
			//Liberamos el buffer generado por la consulta sql
			mysqli_free_result($resultado);
			mysqli_close($conexion);
			unset($peticion,$conexion);
			include "conexion.php";
			echo "<div class='text-center'>
							<h2>Prestamos no resueltos</h2>
						</div>
						<div class='row slideanim'>";
			$sql="CALL SelectPrestamosIndividuales('".$_SESSION['idUser']."')";
			$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			if(mysqli_num_rows($resultado) == 0){
				echo "<div class='container text-center'><h6>No se encontraron registros</h6></div>";
			}else{
				while ($b = mysqli_fetch_array($resultado)){
					echo"<div class='col-sm-4 col-xs-12'>
							<div class='panel panel-default text-center'>
								<div class='panel-heading'>
									<h5>Prestamo #".$b['idPrestamo']."</h5>
								</div>
								<div class='panel-body'>
									<p><strong>Fecha: </strong> ".$b['fechaActual']."</p>
									<p><strong>Descripci&oacute;n</strong> ".$b['descripcion']."</p>
									<p><strong>Motivo: </strong> ".$b['motivo']."</p>
									<p><strong>Estatus: </strong>No Finalizado</p>";
							echo "</div>
							</div>
						</div> ";
				}
			}
			echo "</div>";
			//Liberamos el buffer generado por la consulta sql
			mysqli_free_result($resultado);
			mysqli_close($conexion);
			unset($peticion,$conexion);
			include "conexion.php";
			echo "<div class='text-center'>
					<h2>Equipo no resuelto</h2>
				</div>
			<div class='row slideanim'>";
			$sql="CALL SelectEquipoUsuario('".$_SESSION['idUser']."')";
			$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			if(mysqli_num_rows($resultado) == 0){
				echo "<div class='container text-center'><h6>No se encontraron registros</h6></div>";
			}else{
				while ($b = mysqli_fetch_array($resultado)){
					echo"<div class='col-sm-4 col-xs-12'>
							<div class='panel panel-default text-center'>
								<div class='panel-heading'>
									<h1>Id: ".$b['idEquipo']."</h1>
								</div>
								<div class='panel-body'>
									<p><strong>Fecha: </strong> ".$b['fecha']."</p>
									<p><strong>Descripci&oacute;n: </strong> ".$b['descripcionSrv']."</p>
									<p><strong>Equipo: </strong> ".$b['descripcionEquipo']."</p>";
									if($b['finalizado'] == false){
										echo "<p style='background-color:red;'><strong>Estatus: </strong> No Finalizado</p>";
									}else{
										echo "<p style='background-color:green;'><strong>Estatus: </strong>Finalizado puede pasar a recogerlo</p>";
									}
								echo"</div>
							</div>
						</div>";
				}
			}
			echo "</div>";
			echo "<div class='text-center'>
					<h2>Compras no resueltas</h2>
				</div>
			<div class='row slideanim'>";
				Include 'conexion.php';
				$sql="CALL SelectComprasUsuario('".$_SESSION['idUser']."')";
				$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
				if(mysqli_num_rows($resultado) == 0){
					echo "<div class='container text-center'><h6>No se encontraron registros</h6></div>";
				}else{
					while ($b = mysqli_fetch_array($resultado)){
						echo"<div class='col-sm-4 col-xs-12'>
								<div class='panel panel-default text-center'>
									<div class='panel-heading'>
										<h1>".$b['articulo']."</h1>
									</div>
									<div class='panel-body'>
										<p><strong>Fecha: </strong> ".$b['fecha']."</p>
										<p><strong>Planeaci&oacute;n: </strong> ".$b['planeacion']."</p>
										<p><strong>Estatus: </strong>No Resuelto</p>
									</div>
								</div>
							</div>";
					}


				}
			}
			echo "</div>";
		?>
	

		<! Ver registros no finalizados ->
		<div class="container">
			<?php
			Include 'conexion.php';

			if(isset($_SESSION['admin'])){
				if($_SESSION['admin'] == true  || $_SESSION['recepcion'] == true){
					$registros = "CALL SelectServiciosNoFinalizados()";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
				}else{
					$registros = "SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,t.nombre,s.finalizado,s.solucion,a.nombre as area FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t INNER JOIN areas a INNER JOIN servicioarea sa ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos AND sa.fk_idServicio = s.idServicios AND sa.fk_idArea = a.idArea WHERE s.finalizado = 0 AND t.idTecnicos = '".$_SESSION['idUser']."' AND s.mostrar = false ORDER BY s.idServicios";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
				}
				echo "<div class='text-center'>
						<h2>Reportes no resueltos</h2>
					</div>
				<div class='row slideanim'>";
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
								<th>Finalizado</th>";
				if($_SESSION['admin'] == false && $_SESSION['recepcion'] == false){
					echo"		<th>Finalizado Tecnico</th>
								<th>Soluci&oacute;n</th>
								<th>Finalizar</th>";
				}				
				
					echo"	</tr>
						</thead>
						<tbody>";
					$solucion="";
				while($b= mysqli_fetch_array($resultado)){
					if(isset($b['solucion'])){
						$solucion = $b['solucion'];
					}
					echo"<tr>
							<td>".$b['idServicios']."</td>
							<td>".$b['fecha']."</td>
							<td>".$b['fecha_fin']."</td>
							<td>".$b['horaInicio']."</td>
							<td>".$b['horaFin']."</td>
							<td>".$b['tipoServicio']."</td>
							<td>".$b['descripcion']."</td>
							<td>".$b['area']."</td>
							<td>";
								mysqli_close($conexion);
								unset($conexion);
								include "conexion.php";
								$tecnico = "CALL SelectTecnicoServicio('".$b['idServicios']."')";
								$resultadoTecnico = mysqli_query($conexion,$tecnico) or die(mysqli_error($conexion));
								if(mysqli_num_rows($resultadoTecnico) == 0){
									echo "<form action='asignarTecnico.php' method='post'>
											<input type='hidden' value='".$b['idServicios']."' name='idServicio'>
											<input type='hidden' value='1' name='tipo'>
											<select class='form-control' name='tecnicoId'>
												<option>Asignar</option>";
												mysqli_close($conexion);
												unset($conexion);
												include "conexion.php";
												$IdsTecnicos = "CALL SelectOnlyTecnicos()";
												$resultadoTecnicoIds = mysqli_query($conexion,$IdsTecnicos) or die(mysqli_error($conexion));
												while($c = mysqli_fetch_array($resultadoTecnicoIds)){
													echo "<option value='".$c['idTecnicos']."' size>".utf8_encode($c['nombre'])."</option>";
												}
											echo "</select>"
												. "<input type='submit'data-tooltip='tooltip' data-placement='bottom' title='Click Aqui Para Guardar' class='btn btn-default' value ='Guardar'>'";
									echo"</form>";
								}else{
									while($c = mysqli_fetch_array($resultadoTecnico)){
										$tecnicoName = $c['nombre'];
									}
									echo $tecnicoName;
								}
							echo"</td>";
							echo "<td bgcolor='#FD8A00'>No</td>";
							if($_SESSION['admin'] == false && $_SESSION['recepcion'] == false){
							echo "<td bgcolor='#FD8A00'>No</td>";
							echo '<form action="finalizarTecnico.php" method="post">
									<td>
									<input type="hidden" name="idServicio" value="'.$b['idServicios'].'">
										<textarea type="text"  rows="4" cols="10" name="solucionServicioTecnico" required  id="solucionTecnico"  placeholder="Escriba su soluci&oacute;n en no mas de 200 caracteres">'.utf8_encode($solucion).'</textarea>
									</td>
									<td>
										<button type="submit" class="btn btn-default">Finalizar</button>
									</td>
								</form>';	
							}

				}
						echo"</tbody>
					</table>";
				}
				echo "</div>";
			?>
		</div>
		
		<! Ver Prestamos no finalizados ->
		<div class="container">
			<?php
			Include 'conexion.php';

			if(isset($_SESSION['admin'])){
				if($_SESSION['admin'] == true  || $_SESSION['recepcion'] == true){
					$registros = "CALL SelectPrestamosNoFinalizados()";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
					echo "<div class='text-center'>
						<h2>Prestamos no resueltos</h2>
					</div>
				<div class='row slideanim'>";
					echo"<table class='table table-hover'>
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Descripci&oacute;n</th>
									<th>Motivo</th>
									<th>Usuario</th>
									<th>Area</th>
									<th>Finalizar</th>
								</tr>
							</thead>
							<tbody>";
					while($b= mysqli_fetch_array($resultado)){
						echo"<tr>
								<td>".$b['idPrestamo']."</td>
								<td>".$b['fechaActual']."</td>
								<td>".$b['descripcion']."</td>
								<td>".$b['motivo']."</td>
								<td>".$b['usuario']."</td>
								<td>".$b['nombre']."</td>
								<td><form action='finalizarPrestamo.php' method='post'>
										<input type='hidden' value='".$b['idPrestamo']."' name='idprestamo'>
										<input type='submit' class='btn btn-lg' value='Finalizar'>
									</form>
								</td>
							";
					}
							echo"</tbody>
						</table>";
				}
				echo "</div>";
			}
			?>
		</div>
		<! Ver Equipos no entregados ->
		<div class="container">
			<?php
			Include 'conexion.php';
			if(isset($_SESSION['admin'])){
				if($_SESSION['admin'] == true || $_SESSION['recepcion'] == true){
						$registros = "CALL SelectEquipoNoEntregado()";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
					echo "<div class='text-center'>
						<h2>Equipos no entregados</h2>
					</div>
				<div class='row slideanim'>";
					echo"<table class='table table-hover'>
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Usuario</th>
									<th>Area</th>
									<th>Extenci&oacute;n Movil</th>
									<th>Servicio</th>
									<th>Equipo</th>
									<th>Tecnico</th>
									<th>Estatus</th>
									<th>Entregar</th>
								</tr>
							</thead>
							<tbody>";
					while($b= mysqli_fetch_array($resultado)){
						echo"<tr>
								<td>".$b['idEquipo']."</td>
								<td>".$b['fecha']."</td>
								<td>".$b['usuario']."</td>
								<td>".$b['area']."</td>
								<td>".$b['extencionMovil']."</td>
								<td>".$b['descripcionSrv']."</td>
								<td>".$b['descripcionEquipo']."</td>
								<td>";
									mysqli_close($conexion);
									unset($conexion);
									include "conexion.php";
									$tecnico = "CALL SelectTecnicoEquipo('".$b['idEquipo']."')";
									$resultadoTecnico = mysqli_query($conexion,$tecnico) or die(mysqli_error($conexion));
									if(mysqli_num_rows($resultadoTecnico) == 0){
										echo "<form action='asignarTecnico.php' method='post'>
												<input type='hidden' value='".$b['idEquipo']."' name='idEquipo'>
												<input type='hidden' value='2' name='tipo'>
												<select class='form-control' name='tecnicoId'>
													<option>Asignar</option>";
													mysqli_close($conexion);
													unset($conexion);
													include "conexion.php";
													$IdsTecnicos = "CALL SelectOnlyTecnicos()";
													$resultadoTecnicoIds = mysqli_query($conexion,$IdsTecnicos) or die(mysqli_error($conexion));
													while($c = mysqli_fetch_array($resultadoTecnicoIds)){
														echo "<option value='".$c['idTecnicos']."' size>".utf8_encode($c['nombre'])."</option>";
													}
												echo "</select>"
													. "<input type='submit' class='btn btn-default' value ='Guardar'>'";
										echo"</form>";
									}else{
										while($c = mysqli_fetch_array($resultadoTecnico)){
											$tecnicoName = $c['nombre'];
										}
										echo $tecnicoName;
									}
								echo"</td>";
								if($b['finalizado'] == false){
									echo "<td bgcolor='#FD8A00'>No finalizado</td>";
								}else{
									echo "<td bgcolor='#16F409'>Finalizado</td>";
								}
						echo"<td><form action='entregarEquipo.php' method='post'>
										<input type='hidden' value='".$b['idEquipo']."' name='idEquipo'>
										<input type='submit' class='btn btn-lg' value='Entregar'>
									</form>
								</td>
							";
					}
							echo"</tbody>
						</table>";
				}
				echo "</div>";
			}
			?>
		</div>
		
		<! Ver Equipos no entregados individual ->
		<div class="container">
			<?php
			Include 'conexion.php';
			if(isset($_SESSION['admin'])){
				if($_SESSION['admin'] != true && $_SESSION['recepcion'] != true){
					$registros = "CALL SelectEquipoTecnicoIndividual('".$_SESSION['idUser']."')";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
					echo "<div class='text-center'>
						<h2>Equipos no entregados</h2>
					</div>
				<div class='row slideanim'>";
					echo"<table class='table table-hover'>
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Area</th>
									<th>Extenci&oacute;n Movil</th>
									<th>Servicio</th>
									<th>Equipo</th>
									<th>Estatus</th>
									<th>Finalizar</th>
								</tr>
							</thead>
							<tbody>";
					while($b= mysqli_fetch_array($resultado)){
						echo"<tr>
								<td>".$b['idEquipo']."</td>
								<td>".$b['fecha']."</td>
								<td>".$b['area']."</td>
								<td>".$b['extencionMovil']."</td>
								<td>".$b['descripcionSrv']."</td>
								<td>".$b['descripcionEquipo']."</td>
								<td bgcolor='#FD8A00'>No Fianlizado</td>
								<td>";
						echo"<form action='finalizarEquipo.php' method='post'>
										<input type='hidden' value='".$b['idEquipo']."' name='idEquipo'>
										<input type='submit' class='btn btn-lg' value='Finalizar'>
									</form>
								</td>
							";
					}
							echo"</tbody>
						</table>";
				}
				echo "</div>";
			}
			?>
		</div>
		
		
		
		<! Ver Compras no finalizadas ->
		<div class="container">
			<?php
			Include 'conexion.php';
			if(isset($_SESSION['admin'])){
				if($_SESSION['admin'] == true){
					$registros = "CALL SelectComprasNoFinalizadas()";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
					echo "<div class='text-center'>
						<h2>Compras no resueltas</h2>
					</div>
				<div class='row slideanim'>";
					echo"<table class='table table-hover'>
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Usuario</th>
									<th>Area</th>
									<th>Articulo</th>
									<th>Dictamen</th>
									<th>Planeaci&oacute;n</th>
									<th>Finalizar</th>
								</tr>
							</thead>
							<tbody>";
					while($b= mysqli_fetch_array($resultado)){
						echo"<tr>
								<td>".$b['idCompras']."</td>
								<td>".$b['fecha']."</td>
								<td>".$b['usuario']."</td>
								<td>".$b['area']."</td>
								<td>".$b['articulo']."</td>
								<td>".$b['dictamen']."</td>
								<td>".$b['planeacion']."</td>";
						echo"<td><form action='finalizarCompra.php' method='post'>
										<input type='hidden' value='".$b['idCompras']."' name='idCompras'>
										<input type='submit' class='btn btn-lg' value='Comprado'>
									</form>
								</td>
							";
					}
							echo"</tbody>
						</table>";
				}
				echo "</div>";
			}
			?>
		</div>
        <!--script para tooltip-->
		<script>
            $(document).ready(function(){
                $('[data-tooltip=tooltip]').tooltip();   
            });
        </script>
		<footer class="container-fluid text-center" style="background-color:#ad8a3e">
			<table width="100%">
				<th width="33%"></th>
				<th width="33%"><p style='color:white'>WebDesign By Servicio Social</p></th>
				<th width="33%"><div align="right">
					<?php
						if(!isset($_SESSION['user']))
							echo "<a href='sesionTecnicos.php'>Soporte</a>";?>
					</div></th>
					
			</table>

		</footer>
	</body>
</html>