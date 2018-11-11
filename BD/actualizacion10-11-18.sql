ALTER TABLE `servicios` ADD `finalizadoTecnico` TINYINT(4) NOT NULL 
AFTER `finalizado`, ADD `solucion` VARCHAR(200) NOT NULL AFTER `finalizadoTecnico`;
ALTER TABLE `servicios` ADD `mostrar` TINYINT(4) NOT NULL AFTER `solucion`;

DROP PROCEDURE `SelectServiciosNoFinalizadosIndividuales`; 
CREATE DEFINER=`root`@`localhost`
 PROCEDURE `SelectServiciosNoFinalizadosIndividuales`(IN `idTec` INT(10)) 
 NOT DETERMINISTIC READS SQL DATA SQL 
 SECURITY DEFINER 
 SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE s.finalizado = 0 AND t.idTecnicos = idTec AND s.mostrar = false ORDER BY s.idServicios;

 
 CREATE PROCEDURE `selectServiciosNotify`(IN `idUser` INT(100)) NOT DETERMINISTIC READS SQL DATA SQL SECURITY DEFINER SELECT s.idServicios,s.fecha,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado FROM servicios s INNER JOIN serviciosusuarios su INNER JOIN usuarios u ON su.fk_idServicios = s.idServicios AND su.fk_idUsuarios = u.idUsuarios WHERE u.idUsuarios = idUser AND s.finalizado = 0 AND s.mostrar = true;
 
 CREATE PROCEDURE `servicioNoFinalizado`(IN `id` INT(10)) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY DEFINER UPDATE `servicios` SET `mostrar`=false, `finalizadoTecnico`=false WHERE `idServicios` = id;