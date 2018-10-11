			<?php
			session_start();
			Include 'conexion.php';

			if(isset($_SESSION['admin'])){
				if($_SESSION['admin'] == true  || $_SESSION['recepcion'] == true){
					$registros = "CALL SelectServiciosNoFinalizados()";
					$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
				}else{
					$registros = "CALL SelectServiciosNoFinalizadosIndividuales('".$_SESSION['idUser']."')";
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
												. "<input type='submit' class='btn btn-default' value ='Guardar'>'";
									echo"</form>";
								}else{
									while($c = mysqli_fetch_array($resultadoTecnico)){
										$tecnicoName = $c['nombre'];
									}
									echo $tecnicoName;
								}
							echo"</td>";
							echo "<td bgcolor='#FD8A00'>No</td>
						";
				}
						echo"</tbody>
					</table>";
				}
				echo "</div>";
			?>