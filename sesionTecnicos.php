<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="shortcut icon" href="img/logo.png">
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
		
		<nav class="navbar" style="background-color:#212650;">

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
		</nav>
            <!-- Modal para Iniciar Sesion Admin-->
            <div class="container" id="collapsibleNavbar3">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Iniciar Sesi&oacute;n Técnico</h4>
						</div>
						<div class="modal-body">
							
							<div id="sesionTecnicos">
								<form action="InicioSesion.php" method="post">
									<div class="form-group">
										<label class="control-label col-sm-2" >Usuario:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="user" id="usuario" placeholder="Usuario" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">Contrae&ntilde;a:</label>
										<div class="col-sm-10"> 
											<input type="password" class="form-control" name="password" id="pass" onkeyup="sesionTecnicos()" placeholder="Contrase&ntilde;a" required>
										</div>
									</div>
									<div class="form-group"> 
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-default">Iniciar Sesi&oacute;n</button>
										</div>

									<div id="resultadoIS">

									</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
<footer class="container-fluid text-center" style="background-color:#ad8a3e;">
  <p style='color:white'>WebDesign By Servicio Social</p>
</footer>

	</body>
</html>