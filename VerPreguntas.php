<?php
Include 'conexion.php';
	$registros = "SELECT `id`, `pregunta`, `respuesta` FROM `preguntas`";
	$resultado = mysqli_query($conexion,$registros) or die(mysqli_error($conexion));
	echo "<div class='container'>";
	echo"<table class='table table-hover '>
            <thead>
            <tr>
      <th scope='col'>Pregunta</th>
      <th scope='col'>Respuesta</th>
            </tr>
          </thead>
          <tbody>";
	while($b= mysqli_fetch_array($resultado)){
		
			echo"<tr>
					<td>".$b['pregunta']."</td>
					<td>".$b['respuesta']."</td>";
		
			
		
	}
			echo"</tbody>
		</table>
	</div>";
