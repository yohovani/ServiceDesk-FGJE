<?php
	session_start();
	include 'conexion.php';
	require_once  'Classes/PHPExcel.php';

	$objExcel = new PHPExcel();
	
	$objExcel->getProperties()
			->setCreator("'".$_SESSION['user']."'")
			->setTitle('Reporte')
			->setDescription('Reporte general del serviceDesk')
			->setCategory('Administracion');
	
	$objExcel->setActiveSheetIndex(0);
	$objExcel->getActiveSheet()->setTitle('Servicios');
	$objExcel->getActiveSheet()->setCellValue('A1','Id');
	$objExcel->getActiveSheet()->setCellValue('B1','Fecha Inicio');
	$objExcel->getActiveSheet()->setCellValue('C1','Fecha Fin');
	$objExcel->getActiveSheet()->setCellValue('D1','Hora Inicio');
	$objExcel->getActiveSheet()->setCellValue('E1','Hora Fin');
	$objExcel->getActiveSheet()->setCellValue('F1','Tipo de servicio');
	$objExcel->getActiveSheet()->setCellValue('G1','Descripción');
	$objExcel->getActiveSheet()->setCellValue('H1','Ubicación');
	$objExcel->getActiveSheet()->setCellValue('I1','Finalizado');
	$objExcel->getActiveSheet()->setCellValue('J1','Tecnico');
	$objExcel->getActiveSheet()->setCellValue('K1','Usuario');
	$cells = array("A1","B1","C1","D1","E1","F1","G1","H1","I1","J1","K1");
	$servicios = array(0,0,0,0,0,0,0);
	for($x=0;$x<11;$x++){
		$objExcel->getActiveSheet()
			->getStyle($cells[$x])
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
			->setRGB('204D8E');
	}

	$SQLreportes = "CALL selectServicosExcel()";
	$resultado = mysqli_query($conexion,$SQLreportes) or die(mysqli_error($conexion));
	$i=2;
	while($b= mysqli_fetch_array($resultado)){
		$objExcel->getActiveSheet()->setCellValue('A'.$i,$b['idServicios']);
		$objExcel->getActiveSheet()->setCellValue('B'.$i,$b['fecha']);
		$objExcel->getActiveSheet()->setCellValue('C'.$i,$b['fecha_fin']);
		$objExcel->getActiveSheet()->setCellValue('D'.$i,$b['horaInicio']);
		$objExcel->getActiveSheet()->setCellValue('E'.$i,$b['horaFin']);
		$objExcel->getActiveSheet()->setCellValue('F'.$i,$b['tipoServicio']);
		switch ($b['tipoServicio']){
			case 'Internet':{
				$servicios[0]+=1;
				break;
			}
			case 'Impresora':{
				$servicios[1]+=1;
				break;
			}
			case 'Word':{
				$servicios[2]+=1;
				break;
			}
			case 'Excel':{
				$servicios[3]+=1;
				break;
			}
			case 'Permisos de Red':{
				$servicios[4]+=1;
				break;
			}
			case 'Conectividad':{
				$servicios[5]+=1;
				break;
			}
			case 'Otro':{
				$servicios[6]+=1;
				break;
			}
			
		}
		$objExcel->getActiveSheet()->setCellValue('G'.$i,$b['descripcion']);
		$objExcel->getActiveSheet()->setCellValue('H'.$i,$b['ubicacion']);
		if ($b['finalizado'] == true) {
			$objExcel->getActiveSheet()->setCellValue('I' . $i, 'Si');
		} else {
			$objExcel->getActiveSheet()->setCellValue('I' . $i, 'No');
		}
	$objExcel->getActiveSheet()->setCellValue('J'.$i,$b['nombre']);
		$objExcel->getActiveSheet()->setCellValue('K'.$i,$b['usuario']);
		$i+=1;
	}
	
	foreach(range('A','K') as $columnID) {
		$objExcel->getActiveSheet()->getColumnDimension($columnID)
			->setAutoSize(true);
	}
	
	$objExcel->createSheet(1);
	$objExcel->setActiveSheetIndex(1);
	$objExcel->getActiveSheet()->setTitle('Equipo');
	$objExcel->getActiveSheet()->setCellValue('A1','Id');
	$objExcel->getActiveSheet()->setCellValue('B1','Fecha Inicio');
	$objExcel->getActiveSheet()->setCellValue('C1','Fecha de entrega');
	$objExcel->getActiveSheet()->setCellValue('D1','Area');
	$objExcel->getActiveSheet()->setCellValue('E1','Extención Movil');
	$objExcel->getActiveSheet()->setCellValue('F1','Descripción de equipo');
	$objExcel->getActiveSheet()->setCellValue('G1','Descripción de Servicio');
	$objExcel->getActiveSheet()->setCellValue('H1','Finalizado');
	$objExcel->getActiveSheet()->setCellValue('I1','Entregado');
	$objExcel->getActiveSheet()->setCellValue('J1','Tecnico');
	$objExcel->getActiveSheet()->setCellValue('K1','Usuario');
	for($x=0;$x<11;$x++){
		$objExcel->getActiveSheet()
			->getStyle($cells[$x])
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
			->setRGB('204D8E');
	}
	
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$SQLequipo = "CALL selectEquipoExcel()";
	$resultado = mysqli_query($conexion,$SQLequipo) or die(mysqli_error($conexion));
	$i=2;
	
	while($b= mysqli_fetch_array($resultado)){
		$objExcel->getActiveSheet()->setCellValue('A'.$i,$b['idEquipo']);
		$objExcel->getActiveSheet()->setCellValue('B'.$i,$b['fecha']);
		$objExcel->getActiveSheet()->setCellValue('C'.$i,$b['fechaEntrega']);
		$objExcel->getActiveSheet()->setCellValue('D'.$i,$b['area']);
		$objExcel->getActiveSheet()->setCellValue('E'.$i,$b['extencionMovil']);
		$objExcel->getActiveSheet()->setCellValue('F'.$i,$b['descripcionEquipo']);
		$objExcel->getActiveSheet()->setCellValue('G'.$i,$b['descripcionSrv']);
		if($b['finalizado'] == true)
			$objExcel->getActiveSheet()->setCellValue('H'.$i,'Si');
		else
			$objExcel->getActiveSheet()->setCellValue('H'.$i,'No');
		if($b['entregado'] == true)
			$objExcel->getActiveSheet()->setCellValue('I'.$i,'Si');
		else
			$objExcel->getActiveSheet()->setCellValue('I'.$i,'No');
		$objExcel->getActiveSheet()->setCellValue('J'.$i,$b['nombre']);
		$objExcel->getActiveSheet()->setCellValue('K'.$i,$b['usuario']);
		$i+=1;
	}

	foreach(range('A','K') as $columnID) {
		$objExcel->getActiveSheet()->getColumnDimension($columnID)
			->setAutoSize(true);
	}
	
	$objExcel->createSheet(2);
	$objExcel->setActiveSheetIndex(2);
	$objExcel->getActiveSheet()->setTitle('Prestamos');
	$objExcel->getActiveSheet()->setCellValue('A1','Id');
	$objExcel->getActiveSheet()->setCellValue('B1','Fecha de Prestamo');
	$objExcel->getActiveSheet()->setCellValue('C1','Fecha de entrega');
	$objExcel->getActiveSheet()->setCellValue('D1','Area');
	$objExcel->getActiveSheet()->setCellValue('E1','Descripcion');
	$objExcel->getActiveSheet()->setCellValue('F1','Motivo');
	$objExcel->getActiveSheet()->setCellValue('G1','Entregado');
	$objExcel->getActiveSheet()->setCellValue('H1','Usuario');

	for($x=0;$x<8;$x++){
		$objExcel->getActiveSheet()
			->getStyle($cells[$x])
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
			->setRGB('204D8E');
	}
	
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$SQLprestamos = "CALL selectPrestamosExcel()";
	$resultado = mysqli_query($conexion,$SQLprestamos) or die(mysqli_error($conexion));
	$i=2;
	
	while($b= mysqli_fetch_array($resultado)){
		$objExcel->getActiveSheet()->setCellValue('A'.$i,$b['idPrestamo']);
		$objExcel->getActiveSheet()->setCellValue('B'.$i,$b['fechaActual']);
		$objExcel->getActiveSheet()->setCellValue('C'.$i,$b['fechaEntrega']);
		$objExcel->getActiveSheet()->setCellValue('D'.$i,$b['area']);
		$objExcel->getActiveSheet()->setCellValue('E'.$i,$b['descripcion']);
		$objExcel->getActiveSheet()->setCellValue('F'.$i,$b['motivo']);
		if($b['entregado'] == true)
			$objExcel->getActiveSheet()->setCellValue('G'.$i,'Si');
		else
			$objExcel->getActiveSheet()->setCellValue('G'.$i,'No');
		$objExcel->getActiveSheet()->setCellValue('H'.$i,$b['nombre']);
		$i+=1;
	}

	foreach(range('A','H') as $columnID) {
		$objExcel->getActiveSheet()->getColumnDimension($columnID)
			->setAutoSize(true);
	}
	
	
	$objExcel->createSheet(3);
	$objExcel->setActiveSheetIndex(3);
	$objExcel->getActiveSheet()->setTitle('Compras');
	$objExcel->getActiveSheet()->setCellValue('A1','Id');
	$objExcel->getActiveSheet()->setCellValue('B1','Fecha de Solicitud');
	$objExcel->getActiveSheet()->setCellValue('C1','Area');
	$objExcel->getActiveSheet()->setCellValue('D1','Usuario');
	$objExcel->getActiveSheet()->setCellValue('E1','Articulo');
	$objExcel->getActiveSheet()->setCellValue('F1','Dictamen');
	$objExcel->getActiveSheet()->setCellValue('G1','Planeación');
	$objExcel->getActiveSheet()->setCellValue('H1','resuelto');

	for($x=0;$x<8;$x++){
		$objExcel->getActiveSheet()
			->getStyle($cells[$x])
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
			->setRGB('204D8E');
	}
	
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	unset($resultado,$conexion);
	include "conexion.php";
	$SQLprestamos = "CALL selectComprasExcel()";
	$resultado = mysqli_query($conexion,$SQLprestamos) or die(mysqli_error($conexion));
	$i=2;
	
	while($b= mysqli_fetch_array($resultado)){
		$objExcel->getActiveSheet()->setCellValue('A'.$i,$b['idCompras']);
		$objExcel->getActiveSheet()->setCellValue('B'.$i,$b['fecha']);
		$objExcel->getActiveSheet()->setCellValue('C'.$i,$b['area']);
		$objExcel->getActiveSheet()->setCellValue('D'.$i,$b['usuario']);
		$objExcel->getActiveSheet()->setCellValue('E'.$i,$b['articulo']);
		$objExcel->getActiveSheet()->setCellValue('F'.$i,$b['dictamen']);
		$objExcel->getActiveSheet()->setCellValue('G'.$i,$b['planeacion']);
		if($b['resuelto'] == true)
			$objExcel->getActiveSheet()->setCellValue('H'.$i,'Si');
		else
			$objExcel->getActiveSheet()->setCellValue('H'.$i,'No');
		$i+=1;
	}

	foreach(range('A','H') as $columnID) {
		$objExcel->getActiveSheet()->getColumnDimension($columnID)
			->setAutoSize(true);
	}
	
	
	$objExcel->createSheet(4);
	$objExcel->setActiveSheetIndex(4);
	$objExcel->getActiveSheet()->setTitle('Graficas');
	$objExcel->getActiveSheet()->setCellValue('A1','Tipo de Servicio');
	$objExcel->getActiveSheet()->setCellValue('A2','Internet');
	$objExcel->getActiveSheet()->setCellValue('A3','Impresora');
	$objExcel->getActiveSheet()->setCellValue('A4','Word');
	$objExcel->getActiveSheet()->setCellValue('A5','Excel');
	$objExcel->getActiveSheet()->setCellValue('A6','Permisos de Red');
	$objExcel->getActiveSheet()->setCellValue('A7','Conectividad');
	$objExcel->getActiveSheet()->setCellValue('A8','Otro');
	$objExcel->getActiveSheet()->setCellValue('B1','Total');
	$objExcel->getActiveSheet()->setCellValue('B2',$servicios[0]);
	$objExcel->getActiveSheet()->setCellValue('B3',$servicios[1]);
	$objExcel->getActiveSheet()->setCellValue('B4',$servicios[2]);
	$objExcel->getActiveSheet()->setCellValue('B5',$servicios[3]);
	$objExcel->getActiveSheet()->setCellValue('B6',$servicios[4]);
	$objExcel->getActiveSheet()->setCellValue('B7',$servicios[5]);
	$objExcel->getActiveSheet()->setCellValue('B8',$servicios[6]);
	
	$objExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	
	$dataSeriesLabel1 = array(new \PHPExcel_Chart_DataSeriesValues('String','Graficas!$A$1',NULL,1));
	$labaelXS1 = array(new \PHPExcel_Chart_DataSeriesValues('String','Graficas!$A$2:$A$8',NULL,1));
	$valuesS1 = array(new \PHPExcel_Chart_DataSeriesValues('Number','Graficas!$B$2:$B$8',NULL,1));
	$series1 = new \PHPExcel_Chart_DataSeries(
		\PHPExcel_Chart_DataSeries::TYPE_BARCHART,
		\PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
		range(0, count($valuesS1) - 1),
		$dataSeriesLabel1,
		$labaelXS1,
		$valuesS1
	);
	$series1->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);
	$plotarea = new \PHPExcel_Chart_PlotArea(NULL, array($series1));
	$legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
	$title = new \PHPExcel_Chart_Title('Servicios');
	
	$chart = new \PHPExcel_Chart(
		'servicios',
		$title,
		$legend,
		$plotarea,
		true,
		0,
		NULL,
		NULL);
	$chart->setTopLeftPosition('C2');
	$chart->setBottomRightPosition('I11');
	$objExcel->getActiveSheet()->addChart($chart);
	
	$objWriter = new PHPExcel_Writer_Excel2007($objExcel);
	$objWriter->setIncludeCharts(true);
	$objWriter->save("ServiceDesk.xlsx");
	
	header('Location: index.php');
//	echo'<script type="text/javascript">
//		alert("Click en Aceptar para descargar el archivo");
//		window.location.href="ServiceDesk.xlsx";
//    </script>';