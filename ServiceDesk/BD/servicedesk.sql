-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2018 a las 02:45:00
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE `servicedesk`;
USE `servicedesk`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicedesk`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `FinalizarServicio` (IN `idS` INT(10), IN `hf` TIME, IN `ff` DATE)  MODIFIES SQL DATA
UPDATE `servicios` SET `fecha_fin` = ff,`horaFin`= hf ,`finalizado`=  1 WHERE  `idServicios` = idS$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarAreaUsuarios` (IN `idUsuario` INT(10), IN `idArea` INT(10))  MODIFIES SQL DATA
INSERT INTO `areausuarios`(`fk_idUsuario`, `fk_idArea`) VALUES (idUsuario,idArea)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarFalla` (IN `fecha` VARCHAR(20), IN `hi` TIME, IN `tipo` VARCHAR(50), IN `descripcion` VARCHAR(100), IN `area` VARCHAR(100), IN `tecnico` INT(10))  MODIFIES SQL DATA
INSERT INTO `servicios`(`fecha`, `horaInicio`, `tipoServicio`, `descripcion`, `ubicacion`, `tecnico`, `finalizado`) VALUES (fecha,hi,tipo,descripcion,area,tecnico,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarTecnico` (IN `name` VARCHAR(50), IN `pass` VARCHAR(50))  NO SQL
INSERT INTO `tecnicos`(`nombre`, `password`, `admin`) VALUES (name,pass,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarUsuario` (IN `name` VARCHAR(50), IN `ap` VARCHAR(50), IN `usuario` VARCHAR(50))  MODIFIES SQL DATA
INSERT INTO `usuarios`(nombre, apellidos, usuario) VALUES (name,ap,usuario)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RelacionServiciosTecnicos` (IN `idServicio` INT(10), IN `idTecnico` INT(10))  MODIFIES SQL DATA
INSERT INTO `serviciostecnicos`(`fk_idServicios`, `fk_idTecnicos`) VALUES (idServicio,idTecnico)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RelacionServiciosUsuarios` (IN `idUsuario` INT(10), IN `idServicio` INT(10))  MODIFIES SQL DATA
INSERT INTO `serviciosusuarios`(`fk_idServicios`, `fk_idUsuarios`) VALUES (idServicio,idUsuario)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SeleccionarFallas` ()  READS SQL DATA
SELECT * FROM servicios WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SeleccionarTecnico` (IN `name` VARCHAR(50), IN `pass` VARCHAR(50))  READS SQL DATA
SELECT * FROM `tecnicos` WHERE name = `nombre` AND pass = `password`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SeleccionarTecnicoFalla` ()  READS SQL DATA
SELECT * FROM `tecnicos` WHERE 1 ORDER BY RAND()$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SeleccionarUsuario` (IN `name` VARCHAR(50))  READS SQL DATA
SELECT * FROM `usuarios` WHERE name = `usuario`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectAreas` ()  READS SQL DATA
SELECT * FROM areas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectAreaUsuario` (IN `id` INT(10))  NO SQL
SELECT a.nombre FROM areas a INNER JOIN usuarios u INNER JOIN areausuarios au ON au.fk_idUsuario = u.idUsuarios AND au.fk_idArea = a.idArea WHERE u.idUsuarios = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectRegistrosServicios` ()  READS SQL DATA
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE 1 ORDER BY s.idServicios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectServiciosNoFinalizados` ()  NO SQL
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE s.finalizado = 0 ORDER BY s.idServicios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectServiciosNoFinalizadosIndividuales` (IN `idTec` INT(10))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE s.finalizado = 0 AND t.idTecnicos = idTec ORDER BY s.idServicios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectServiciosUsuario` (IN `idUsuario` INT(10))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado FROM servicios s INNER JOIN serviciosusuarios su INNER JOIN usuarios u ON su.fk_idServicios = s.idServicios AND su.fk_idUsuarios = u.idUsuarios WHERE u.idUsuarios = idUsuario AND s.finalizado = 0$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `idArea` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`idArea`, `nombre`) VALUES
(1, 'DEPARTAMENTO DE RECURSOS FINANCIEROS'),
(2, 'DEPARTAMENTO DE RECURSOS HUMANOS'),
(3, 'DEPARTAMENTO DE RECURSOS MATERIALES'),
(4, 'DIRECCIÓN GENERAL DE INVESTIGACIONES'),
(5, 'AGENCIAS DEL MINISTERIO PéBLICO ESPECIALES'),
(6, 'AGENCIAS DEL MINISTERIO PéBLICO ESPECIALES'),
(7, 'AGENCIAS DEL MINISTERIO PéBLICO INSTRUCTORAS'),
(8, 'CENTRO DE OPERACIàN ESTRATGICA PARA EL NARCOMENUDEO'),
(9, 'AGENCIA DEL MINISTERIO ESPECIALIZADA PARA EL DELITO FEMINICIDIO'),
(10, 'COORDINACIÓN DE UNIDADES ESPECIALIZADAS DE INVESTIGACIÓN'),
(11, 'UNIDAD ESPECIALIZADA DE DELITO CONTRA ROBO'),
(12, 'UNIDAD ESPECIALIZADA DE DELITO CONTRA EL DELITO DE ACTOS U OMISIONES CULPOSAS'),
(13, 'UNIDAD ESPECIALIZADA DE DELITO CONTRA EL ORDEN DE LA FAMILIA'),
(14, 'UNIDAD ESPECIALIZADA DE DELITO CONTRA LA LIBERTAD SEXUAL EN LA INTEGRIDAD'),
(15, 'UNIDAD ESPECIALIZADA DE DELITO CONTRA EL ROBO DE VEHÍCULOS'),
(16, 'UNIDAD ESPECIALIZADA DE DELITO CONTRA EL SECUESTRO'),
(17, 'UNIDAD ESPECIALIZADA EN LA INVESTIGACIàN DEL DELITO DE HOMICIDIOS'),
(18, 'UNIDAD ESPECIALIZADA EN LA INVESTIGACIàN DEL DELITO MIXTA'),
(19, 'UNIDAD ESPECIALIZADA EN LA INVESTIGACIàN DE ADOLESCENTES EN CONFLICTO CON LA LEY PENAL'),
(20, 'UNIDAD ESPECIALIZADA EN LA INVESTIGACIÓN DE DELITOS DE SERVIDORES PÚBLICOS'),
(21, 'COORDINACIàN DEL MàDULO DE ATENCIàN TEMPRANA'),
(22, 'COORDINACIàN DE CENTRO DE JUSTICIA ALTERNATIVA'),
(23, 'DIRECCIàN GENERAL DE PROCEDIMIENTOS JURISDICCIONALES'),
(24, 'AGENCIAS DEL MINISTERIO PÚBLICO ADSCRITAS A LOS JUZGADOS'),
(25, 'UNIDAD DE AMPAROS'),
(26, 'DIRECCIàN DE APREHENSIONES COLABORACIONES Y EXTRADICIONES INTERNACIONALES'),
(27, 'UNIDAD DE EXPEDICIàN DE CARTAS DE NO ANTECEDENTES PENALES'),
(28, 'DIRECCIÓN DE PREVENCIÓN Y ATENCIÓN A VÍCTIMAS DEL DELITO'),
(29, 'DEPARTAMENTO DE TRABAJO SOCIAL'),
(30, 'DEPARTAMENTO DE INVESTIGACIÓN Y DIFUSIÓN'),
(31, 'DEPARTAMENTO DE PREVENCIàN DEL DELITO'),
(32, 'DEPARTAMENTO PARA LA LOCALIZACIàN DE PERSONAS DESAPARECIDAS'),
(33, 'DEPARTAMENTO DE ATENCIàN A VICTIMAS DEL DELITO'),
(34, 'DIRECCIÓN DE CONTROL Y DERECHOS HUMANOS'),
(35, 'AGENCIA DEL MINISTERIO PéBLICO INSTRUCTORA'),
(36, 'AGENCIA DEL MINISTERIO PéBLICO ADSCRITA'),
(37, 'AGENCIA DEL MINISTERIO PéBLICO CONCILIADORA'),
(38, 'SUBDIRECCIàN GENERAL OPERATIVA'),
(39, 'COORDINACIàN OPERAIVA'),
(40, 'VINCULACIàN ADMINISTRATIVA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areausuarios`
--

CREATE TABLE `areausuarios` (
  `fk_idUsuario` int(11) NOT NULL,
  `fk_idArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `areausuarios`
--

INSERT INTO `areausuarios` (`fk_idUsuario`, `fk_idArea`) VALUES
(1, 29),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idCompras` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `usuario` int(11) NOT NULL,
  `area` varchar(75) NOT NULL,
  `ubicacion` varchar(45) NOT NULL,
  `articulo` varchar(150) NOT NULL,
  `dictamen` varchar(150) DEFAULT NULL,
  `planeacion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprasusuarios`
--

CREATE TABLE `comprasusuarios` (
  `fk_idCompras` int(11) NOT NULL,
  `fk_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `idEquipo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `area` varchar(45) NOT NULL,
  `extencionMovil` varchar(45) DEFAULT NULL,
  `descripcionSrv` varchar(150) NOT NULL,
  `descripcionEquipo` varchar(150) NOT NULL,
  `Tecnico` int(11) NOT NULL,
  `fechaEntrega` date NOT NULL,
  `avisado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipotecnicos`
--

CREATE TABLE `equipotecnicos` (
  `fk_idEquipo` int(11) NOT NULL,
  `ifk_dTecnico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipousuarios`
--

CREATE TABLE `equipousuarios` (
  `fk_idEquipo` int(11) NOT NULL,
  `fk_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `idPrestamo` int(11) NOT NULL,
  `fechaActual` date NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `area` varchar(75) NOT NULL,
  `fechaEntrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamosusuarios`
--

CREATE TABLE `prestamosusuarios` (
  `fk_idUsuarios` int(11) NOT NULL,
  `fk_idPrestamos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `idServicios` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `horaInicio` time NOT NULL,
  `horaFin` time DEFAULT NULL,
  `tipoServicio` varchar(100) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `tecnico` int(11) NOT NULL,
  `finalizado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`idServicios`, `fecha`, `fecha_fin`, `horaInicio`, `horaFin`, `tipoServicio`, `descripcion`, `ubicacion`, `tecnico`, `finalizado`) VALUES
(1, '2012-09-18', '0000-00-00', '18:33:00', NULL, 'Internet', 'El internet no funciona', 'DEPARTAMEN', 1, 0),
(2, '2018-09-12', '0000-00-00', '19:07:04', NULL, 'Internet', 'No abre facebook', 'DEPARTAMEN', 1, 0),
(3, '2018-09-13', '0000-00-00', '11:14:37', NULL, 'Impresora', 'La impresiÃ³n sale rayada', 'DEPARTAMEN', 7, 0),
(4, '2018-09-13', '0000-00-00', '11:15:28', NULL, 'Impresora', 'La impresiÃ³n sale rayada', 'DEPARTAMEN', 7, 0),
(5, '2018-09-13', '0000-00-00', '11:16:20', NULL, 'Impresora', 'La impresiÃ³n sale rayada', 'DEPARTAMEN', 1, 0),
(6, '2018-09-13', '0000-00-00', '11:17:56', NULL, 'Excel', 'Prueba 1', 'DEPARTAMEN', 1, 0),
(7, '2018-09-13', '2018-09-13', '11:22:05', '17:50:00', 'Excel', 'Prueba 2', 'DEPARTAMEN', 1, 1),
(8, '2018-09-13', '0000-00-00', '11:29:27', NULL, 'Permisos de Red', 'Prueba 3', 'DEPARTAMEN', 7, 0),
(9, '2018-09-13', '0000-00-00', '11:30:21', NULL, 'Permisos de Red', 'Prueba 4', 'DEPARTAMEN', 1, 0),
(10, '2018-09-13', '2018-09-13', '11:31:37', '17:51:00', 'Permisos de Red', 'Prueba 5', 'DEPARTAMEN', 1, 1),
(11, '2018-09-13', '2018-09-13', '17:56:45', '19:28:10', 'Internet', 'Prueba x', 'DEPARTAMEN', 1, 1),
(12, '2018-09-13', '2018-09-13', '17:58:38', '19:29:09', 'Impresora', 'Prueba x1', 'DEPARTAMEN', 1, 1),
(13, '2018-09-13', '2018-09-13', '17:58:49', '19:29:18', 'Word', 'Word ghjg', 'DEPARTAMEN', 7, 1),
(14, '2018-09-13', '2018-09-13', '17:59:05', '19:44:34', 'Permisos de Red', 'Error', 'DEPARTAMEN', 7, 1),
(15, '2018-09-13', '2018-09-13', '19:13:43', '19:44:31', 'Internet', 'test', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciostecnicos`
--

CREATE TABLE `serviciostecnicos` (
  `fk_idServicios` int(11) NOT NULL,
  `fk_idTecnicos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `serviciostecnicos`
--

INSERT INTO `serviciostecnicos` (`fk_idServicios`, `fk_idTecnicos`) VALUES
(10, 1),
(11, 1),
(12, 1),
(13, 7),
(14, 7),
(15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciosusuarios`
--

CREATE TABLE `serviciosusuarios` (
  `fk_idServicios` int(11) NOT NULL,
  `fk_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `serviciosusuarios`
--

INSERT INTO `serviciosusuarios` (`fk_idServicios`, `fk_idUsuarios`) VALUES
(7, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

CREATE TABLE `tecnicos` (
  `idTecnicos` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `admin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tecnicos`
--

INSERT INTO `tecnicos` (`idTecnicos`, `nombre`, `password`, `admin`) VALUES
(1, 'admin', 'admin', 1),
(7, 't1', 'asdf', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuarios`, `nombre`, `apellidos`, `usuario`) VALUES
(1, 'Jaime', 'Fernandez', 'JaFernandez'),
(2, 'test', 'test', 'test');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`idArea`);

--
-- Indices de la tabla `areausuarios`
--
ALTER TABLE `areausuarios`
  ADD PRIMARY KEY (`fk_idUsuario`,`fk_idArea`),
  ADD KEY `fk_idArea` (`fk_idArea`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idCompras`,`usuario`);

--
-- Indices de la tabla `comprasusuarios`
--
ALTER TABLE `comprasusuarios`
  ADD PRIMARY KEY (`fk_idCompras`,`fk_idUsuarios`),
  ADD KEY `fk_CU_U` (`fk_idUsuarios`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`idEquipo`,`Tecnico`);

--
-- Indices de la tabla `equipotecnicos`
--
ALTER TABLE `equipotecnicos`
  ADD PRIMARY KEY (`fk_idEquipo`,`ifk_dTecnico`),
  ADD KEY `fk_ET_U` (`ifk_dTecnico`);

--
-- Indices de la tabla `equipousuarios`
--
ALTER TABLE `equipousuarios`
  ADD PRIMARY KEY (`fk_idEquipo`,`fk_idUsuarios`),
  ADD KEY `fk_EU_U` (`fk_idUsuarios`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`idPrestamo`);

--
-- Indices de la tabla `prestamosusuarios`
--
ALTER TABLE `prestamosusuarios`
  ADD PRIMARY KEY (`fk_idUsuarios`,`fk_idPrestamos`),
  ADD KEY `fk_PU_P` (`fk_idPrestamos`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idServicios`,`tecnico`);

--
-- Indices de la tabla `serviciostecnicos`
--
ALTER TABLE `serviciostecnicos`
  ADD PRIMARY KEY (`fk_idServicios`,`fk_idTecnicos`),
  ADD KEY `fk_ST_T` (`fk_idTecnicos`);

--
-- Indices de la tabla `serviciosusuarios`
--
ALTER TABLE `serviciosusuarios`
  ADD PRIMARY KEY (`fk_idServicios`,`fk_idUsuarios`),
  ADD KEY `fk_SU-U` (`fk_idUsuarios`);

--
-- Indices de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  ADD PRIMARY KEY (`idTecnicos`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `idArea` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idCompras` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `idEquipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `idPrestamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idServicios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `idTecnicos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areausuarios`
--
ALTER TABLE `areausuarios`
  ADD CONSTRAINT `areausuarios_ibfk_1` FOREIGN KEY (`fk_idArea`) REFERENCES `areas` (`idArea`),
  ADD CONSTRAINT `areausuarios_ibfk_2` FOREIGN KEY (`fk_idUsuario`) REFERENCES `usuarios` (`idUsuarios`);

--
-- Filtros para la tabla `comprasusuarios`
--
ALTER TABLE `comprasusuarios`
  ADD CONSTRAINT `fk_CU_C` FOREIGN KEY (`fk_idCompras`) REFERENCES `compras` (`idCompras`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CU_U` FOREIGN KEY (`fk_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `equipotecnicos`
--
ALTER TABLE `equipotecnicos`
  ADD CONSTRAINT `fk_ET_E` FOREIGN KEY (`fk_idEquipo`) REFERENCES `equipo` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ET_U` FOREIGN KEY (`ifk_dTecnico`) REFERENCES `tecnicos` (`idTecnicos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `equipousuarios`
--
ALTER TABLE `equipousuarios`
  ADD CONSTRAINT `fk_EU_E` FOREIGN KEY (`fk_idEquipo`) REFERENCES `equipo` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_EU_U` FOREIGN KEY (`fk_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `prestamosusuarios`
--
ALTER TABLE `prestamosusuarios`
  ADD CONSTRAINT `fk_PU_P` FOREIGN KEY (`fk_idPrestamos`) REFERENCES `prestamos` (`idPrestamo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PU_U` FOREIGN KEY (`fk_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `serviciostecnicos`
--
ALTER TABLE `serviciostecnicos`
  ADD CONSTRAINT `fk_ST_S` FOREIGN KEY (`fk_idServicios`) REFERENCES `servicios` (`idServicios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ST_T` FOREIGN KEY (`fk_idTecnicos`) REFERENCES `tecnicos` (`idTecnicos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `serviciosusuarios`
--
ALTER TABLE `serviciosusuarios`
  ADD CONSTRAINT `fk_SU-S` FOREIGN KEY (`fk_idServicios`) REFERENCES `servicios` (`idServicios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_SU-U` FOREIGN KEY (`fk_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
