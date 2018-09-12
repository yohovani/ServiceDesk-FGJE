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
                    //Adminsitradores
					if(isset($_SESSION['admin'])){
						if($_SESSION['admin'] == true){
							echo"<button style='color:white' class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbarRT'>
								Registrar T&eacute;cnicos
							</button>";
                            
						}else{
							echo"<button style='color:white' class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbar'>
								Registrar
							</button>";
						}
					}else{
                    
                    echo"
                    <button style='color:white' class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbarRE'>
								Reporte
							</button>";
                    }
					echo "<form class='form-horizontal' action='cerrarSesion.php' method='post'>
								<center><button style='color:white' class='navbar-toggler' data-toggle='collapse type='submit' >Cerrar Sesi&oacute;n</button></center>
							</form>";
                    
                    
				}
			?>
            <!-- Modal para Reportes-->
            <div class="collapse navbar-collapse" id="collapsibleNavbarRE">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Generar Reporte</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="Reporte.php" method="post">
								<div class="form-group">
									<label class="control-label col-sm-2" >Descripci&oacute;n</label>
									<div class="col-sm-10">
										<div class="form-group">
                                            
                                            <textarea class="form-control" rows="5" id="descripcion"></textarea>
                                        </div>
									</div>
								</div>
                                <!--
								<div class="form-group">
									<label class="control-label col-sm" >Se a Solucionado su Problema?</label>
									<div class="col-sm-10">
										<div class="checkbox">
                                            <label><input type="checkbox" value="" disabled></label>
                                        </div>
                                            
									</div>
								</div>
                                -->
								<div class="form-group"> 
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default">Enviar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

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
								<!-- Nombre-->
								<div class="form-group">
									<label class="control-label col-sm-2" >Nombre:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required id="nombre" onKeyUp="nameUser()">
									</div>
								</div>
								<!-- Apellidos-->
								<div class="form-group">
									<label class="control-label col-sm-2" >Apellidos:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="apellidos" placeholder="Apellidos" id="apellidos" onKeyUp="nameUser()">
									</div>
								</div>
								<!-- Usuario-->
								<div class="form-group">
									<label class="control-label col-sm-2" id="usuario">Usuario:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="user" placeholder="Nombre de usuario" id="user">
									</div>
								</div>
								<!-- Area-->
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
								<!-Botón enviar-->
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
								<!-- Nombre-->
								<div class="form-group">
									<label class="control-label col-sm-2" >Nombre de usuario:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nombre" placeholder="Nombre de usuario" required id="nombre" onKeyUp="nameUser()">
									</div>
								</div>
								<!-- Password-->
								<div class="form-group">
									<label class="control-label col-sm-2" id="pass">Contrase&ntilde;a:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" name="password" placeholder="Contrase&ntilde;a" id="password" >
									</div>
								</div>
								<!--Confirmación del Password-->
								<div class="form-group">
									<label class="control-label col-sm-2" id="pass">Confirma Contrase&ntilde;a:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" name="password2" placeholder="Repite la Contrase&ntilde;a" id="password2" onKeyUp="verificarPassword()">
										<input type="text" class="form-control" id="resultado">
									</div>
								</div>
								<!--Botón enviar-->
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
            <!-- Modal para ver usuarios-->
            <div id='usuarios' class='modal fade' role='dialog'>
            <div class='modal-dialog'>
            <!-- Modal content-->
            <div class='modal-content'>
                <div class='modal-header'>
                
                <h4 class='modal-title'>Monitoreo de Reportes</h4>
                </div>
            <div class='modal-body'>"
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
		
		<!-- Container (Portfolio Section) -->
		<div id="portfolio" class="container-fluid text-center bg-grey">
			<div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target='#myCarousel' data-slide-to='1'></li>
					<li data-target='#myCarousel' data-slide-to='2'></li>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<img src="img/logo.png">

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Siguiente</span>
					</a>
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
                    <button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#usuarios'>Ver</button>
                    </center></div>";
						}
					}
			?>
		</div>
     
                
<footer class="container-fluid text-center" style="background-color:gold;">

  <p style='color:white'>WebDesign By Servicio Social</p>
</footer>
            
	</body>
</html>