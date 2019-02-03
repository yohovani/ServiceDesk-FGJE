-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2019 a las 23:47:53
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicedesk`
--
CREATE DATABASE IF NOT EXISTS servicedesk;
USE servicedesk;


DELIMITER ;
--
-- Procedimientos
--
CREATE DEFINER=`yohovani` PROCEDURE `cambiarAdmin` (IN `idTecnico` INT(10), IN `cambio` BOOLEAN)  MODIFIES SQL DATA
UPDATE `tecnicos` SET `admin`=cambio WHERE tecnicos.idTecnicos = idTecnico;

CREATE DEFINER=`yohovani` PROCEDURE `cambiarRecepcion` (IN `idTecnico` INT(10), IN `cambio` BOOLEAN)  MODIFIES SQL DATA
UPDATE `tecnicos` SET `recepcion`=cambio WHERE tecnicos.idTecnicos = idTecnico;

CREATE DEFINER=`yohovani` PROCEDURE `entregarEquipo` (IN `fecha` DATE, IN `id` INT)  MODIFIES SQL DATA
UPDATE `equipo` SET `fechaEntrega`= fecha ,`entregado`= true WHERE `idEquipo` = id;

CREATE DEFINER=`yohovani` PROCEDURE `finalizarCompra` (IN `idCompra` INT(10))  MODIFIES SQL DATA
UPDATE `compras` SET `resuelto`= true WHERE `idCompras` = idCompra;

CREATE DEFINER=`yohovani` PROCEDURE `finalizarEquipo` (IN `id` INT(10))  NO SQL
UPDATE `equipo` SET `finalizado`= true WHERE `idEquipo` = id;

CREATE DEFINER=`yohovani` PROCEDURE `FinalizarPrestamo` (IN `idP` INT(10), IN `fecha` DATE)  MODIFIES SQL DATA
UPDATE `prestamos` SET `fechaEntrega` = fecha,`entregado`= true WHERE `idPrestamo` = idP;

CREATE DEFINER=`yohovani` PROCEDURE `FinalizarServicio` (IN `idS` INT(10), IN `hf` TIME, IN `ff` DATE)  MODIFIES SQL DATA
UPDATE `servicios` SET `fecha_fin` = ff,`horaFin`= hf ,`finalizado`=  1 WHERE  `idServicios` = idS;

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarAreaUsuarios` (IN `idUsuario` INT(10), IN `idArea` INT(10))  MODIFIES SQL DATA
INSERT INTO `areausuarios`(`fk_idUsuario`, `fk_idArea`) VALUES (idUsuario,idArea);

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarCompra` (IN `fecha` DATE, IN `area` VARCHAR(100), IN `articulo` VARCHAR(200), IN `dictamen` VARCHAR(200), IN `planeacion` VARCHAR(200))  MODIFIES SQL DATA
INSERT INTO `compras`(`fecha`, `area`, `articulo`, `dictamen`, `planeacion`, `resuelto`) VALUES (fecha,area,articulo,dictamen,planeacion,false);

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarEquipo` (IN `fecha` DATE, IN `area` VARCHAR(100), IN `movil` VARCHAR(100), IN `servicio` VARCHAR(100), IN `equipo` VARCHAR(150))  MODIFIES SQL DATA
INSERT INTO `equipo`(`fecha`, `area`, `extencionMovil`, `descripcionSrv`, `descripcionEquipo`, `finalizado`, `entregado`) VALUES (fecha,area,movil,servicio,equipo,false,false);

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarFalla` (IN `fecha` VARCHAR(20), IN `hi` TIME, IN `tipo` VARCHAR(50), IN `descripcion` VARCHAR(100))  MODIFIES SQL DATA
INSERT INTO `servicios`(`fecha`, `horaInicio`, `tipoServicio`, `descripcion`, `finalizado`) VALUES (fecha,hi,tipo,descripcion,false);

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarPrestamo` (IN `fecha` DATE, IN `descripcion` VARCHAR(200), IN `mot` VARCHAR(200))  MODIFIES SQL DATA
INSERT INTO `prestamos`(`fechaActual`, `descripcion`, `motivo`,`entregado`) VALUES (fecha,descripcion,mot,false);

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarTecnico` (IN `name` VARCHAR(50), IN `pass` VARCHAR(50))  NO SQL
INSERT INTO `tecnicos`(`nombre`, `password`, `admin`) VALUES (name,pass,false);

CREATE DEFINER=`yohovani` PROCEDURE `RegistrarUsuario` (IN `name` VARCHAR(50), IN `ap` VARCHAR(50), IN `usuario` VARCHAR(50))  MODIFIES SQL DATA
INSERT INTO `usuarios`(nombre, apellidos, usuario) VALUES (name,ap,usuario);

CREATE DEFINER=`yohovani` PROCEDURE `RelacionComprasUsuarios` (IN `idUser` INT(10), IN `idCompra` INT(10))  MODIFIES SQL DATA
INSERT INTO `comprasusuarios`(`fk_idCompras`, `fk_idUsuarios`) VALUES (idCompra,idUser);

CREATE DEFINER=`yohovani` PROCEDURE `relacionEquiposTecnicos` (IN `idEquipo` INT(10), IN `idTecnico` INT(10))  MODIFIES SQL DATA
INSERT INTO `equipotecnicos`(`fk_idEquipo`, `ifk_dTecnico`) VALUES (idEquipo,idTecnico);

CREATE DEFINER=`yohovani` PROCEDURE `RelacionEquipoUsuarios` (IN `idEquipo` INT(10), IN `idUsuario` INT(10))  READS SQL DATA
INSERT INTO `equipousuarios`(`fk_idEquipo`, `fk_idUsuarios`) VALUES (idEquipo,idUsuario);

CREATE DEFINER=`yohovani` PROCEDURE `RelacionPrestamosUsuarios` (IN `idUser` INT(10), IN `idPrestamo` INT(10))  MODIFIES SQL DATA
INSERT INTO `prestamosusuarios`(`fk_idUsuarios`, `fk_idPrestamos`) VALUES (idUser,idPrestamo);

CREATE DEFINER=`yohovani` PROCEDURE `RelacionServicioArea` (IN `idServicio` INT(11), IN `idArea` INT(11))  MODIFIES SQL DATA
INSERT INTO `servicioarea`(`fk_idServicio`, `fk_idArea`) VALUES (idServicio,idArea);

CREATE DEFINER=`yohovani` PROCEDURE `RelacionServiciosTecnicos` (IN `idServicio` INT(10), IN `idTecnico` INT(10))  MODIFIES SQL DATA
INSERT INTO `serviciostecnicos`(`fk_idServicios`, `fk_idTecnicos`) VALUES (idServicio,idTecnico);

CREATE DEFINER=`yohovani` PROCEDURE `RelacionServiciosUsuarios` (IN `idUsuario` INT(10), IN `idServicio` INT(10))  MODIFIES SQL DATA
INSERT INTO `serviciosusuarios`(`fk_idServicios`, `fk_idUsuarios`) VALUES (idServicio,idUsuario);

CREATE DEFINER=`yohovani` PROCEDURE `SeleccionarFallas` ()  READS SQL DATA
SELECT * FROM servicios WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SeleccionarTecnico` (IN `name` VARCHAR(50), IN `pass` VARCHAR(50))  READS SQL DATA
SELECT * FROM `tecnicos` WHERE name = `nombre` AND pass = `password`;

CREATE DEFINER=`yohovani` PROCEDURE `SeleccionarTecnicoFalla` ()  READS SQL DATA
SELECT * FROM `tecnicos` WHERE 1 ORDER BY RAND();

CREATE DEFINER=`yohovani` PROCEDURE `SeleccionarUsuario` (IN `name` VARCHAR(50))  READS SQL DATA
SELECT * FROM `usuarios` WHERE name = `usuario`;

CREATE DEFINER=`yohovani` PROCEDURE `SelectAreas` ()  READS SQL DATA
SELECT * FROM areas;

CREATE DEFINER=`yohovani` PROCEDURE `SelectAreaUsuario` (IN `id` INT(10))  NO SQL
SELECT a.nombre,a.idArea FROM areas a INNER JOIN usuarios u INNER JOIN areausuarios au ON au.fk_idUsuario = u.idUsuarios AND au.fk_idArea = a.idArea WHERE u.idUsuarios = id;

CREATE DEFINER=`yohovani` PROCEDURE `SelectCompras` ()  READS SQL DATA
SELECT * FROM compras WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectComprasAdmin` ()  READS SQL DATA
Select c.*,u.usuario FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON cu.fk_idCompras = c.idCompras AND cu.fk_idUsuarios = u.idUsuarios WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `selectComprasExcel` ()  READS SQL DATA
SELECT c.*,u.usuario FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON c.idCompras = cu.fk_idCompras AND u.idUsuarios = cu.fk_idUsuarios WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectComprasNoFinalizadas` ()  READS SQL DATA
SELECT c.idCompras,c.fecha,u.usuario,c.area,c.articulo,c.dictamen,c.planeacion FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON cu.fk_idCompras = c.idCompras AND cu.fk_idUsuarios = u.idUsuarios WHERE c.resuelto = false;

CREATE DEFINER=`yohovani` PROCEDURE `SelectComprasUsuario` (IN `userid` INT(10))  READS SQL DATA
SELECT c.idCompras,c.fecha,c.articulo,c.planeacion FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON c.idCompras = cu.fk_idCompras AND u.idUsuarios = cu.fk_idUsuarios WHERE u.idUsuarios = userid AND c.resuelto = false;

CREATE DEFINER=`yohovani` PROCEDURE `SelectEquipoAdmin` ()  READS SQL DATA
SELECT e.*,u.usuario,t.nombre FROM equipo e INNER JOIN tecnicos t INNER JOIN equipotecnicos et INNER JOIN usuarios u INNER JOIN equipousuarios eu ON eu.fk_idEquipo = e.idEquipo AND eu.fk_idUsuarios = u.idUsuarios AND et.fk_idEquipo = e.idEquipo AND et.ifk_dTecnico = t.idTecnicos WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `selectEquipoExcel` ()  READS SQL DATA
SELECT e.*,u.usuario,t.nombre FROM equipo e INNER JOIN usuarios u INNER JOIN equipousuarios eu INNER JOIN tecnicos t INNER JOIN equipotecnicos et ON u.idUsuarios = eu.fk_idUsuarios AND e.idEquipo = eu.fk_idEquipo AND et.fk_idEquipo = e.idEquipo AND t.idTecnicos = et.ifk_dTecnico WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectEquipoNoEntregado` ()  READS SQL DATA
SELECT e.idEquipo,e.fecha,u.usuario,e.area,e.extencionMovil,e.descripcionSrv,e.descripcionEquipo,e.finalizado FROM equipo e INNER JOIN usuarios u INNER JOIN equipousuarios eu ON e.idEquipo = eu.fk_idEquipo AND u.idUsuarios = eu.fk_idUsuarios WHERE entregado = false;

CREATE DEFINER=`yohovani` PROCEDURE `SelectEquipos` ()  READS SQL DATA
SELECT * FROM equipo WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectEquipoTecnicoIndividual` (IN `id` INT(10))  READS SQL DATA
SELECT e.idEquipo,e.fecha,e.area,e.extencionMovil,e.descripcionSrv,e.descripcionEquipo,e.finalizado FROM equipo e INNER JOIN tecnicos t INNER JOIN equipotecnicos et ON et.fk_idEquipo = e.idEquipo AND et.ifk_dTecnico = t.idTecnicos WHERE e.finalizado = false AND t.idTecnicos = id;

CREATE DEFINER=`yohovani` PROCEDURE `SelectEquipoUsuario` (IN `idUser` INT(10))  READS SQL DATA
SELECT e.idEquipo,e.fecha,e.descripcionSrv,e.descripcionEquipo,e.finalizado FROM equipo e INNER JOIN usuarios u INNER JOIN equipousuarios eu ON eu.fk_idEquipo = e.idEquipo AND eu.fk_idUsuarios = u.idUsuarios
 WHERE e.entregado = false AND u.idUsuarios = idUser;

CREATE DEFINER=`yohovani` PROCEDURE `selectIdArea` (IN `area` VARCHAR(200))  READS SQL DATA
SELECT areas.idArea FROM areas WHERE areas.nombre = area;

CREATE DEFINER=`yohovani` PROCEDURE `SelectOnlyTecnicos` ()  READS SQL DATA
SELECT t.idTecnicos, t.nombre FROM tecnicos t WHERE t.admin =false and t.recepcion = false;

CREATE DEFINER=`yohovani` PROCEDURE `SelectPrestamos` ()  READS SQL DATA
SELECT * FROM `prestamos` WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectPrestamosAdmin` ()  READS SQL DATA
SELECT p.*,u.nombre,a.nombre as area FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areas a INNER JOIN areausuarios au ON u.idUsuarios = pu.fk_idUsuarios AND p.idPrestamo = pu.fk_idPrestamos AND u.idUsuarios = au.fk_idUsuario AND a.idArea = au.fk_idArea WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `selectPrestamosExcel` ()  READS SQL DATA
SELECT p.*,u.nombre,a.nombre AS area FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areas a INNER JOIN areausuarios au ON pu.fk_idUsuarios = u.idUsuarios AND pu.fk_idPrestamos = p.idPrestamo AND a.idArea = au.fk_idArea AND u.idUsuarios = au.fk_idUsuario WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectPrestamosIndividuales` (IN `idUser` INT(10))  READS SQL DATA
SELECT p.idPrestamo,p.fechaActual,p.descripcion,p.motivo,u.usuario,a.nombre FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areausuarios au INNER JOIN areas a ON p.idPrestamo = pu.fk_idPrestamos AND u.idUsuarios = pu.fk_idUsuarios AND a.idArea = au.fk_idArea AND u.idUsuarios = au.fk_idUsuario WHERE `entregado` = false and u.idUsuarios = idUser;

CREATE DEFINER=`yohovani` PROCEDURE `SelectPrestamosNoFinalizados` ()  READS SQL DATA
SELECT p.idPrestamo,p.fechaActual,p.descripcion,p.motivo,u.usuario,a.nombre FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areausuarios au INNER JOIN areas a ON p.idPrestamo = pu.fk_idPrestamos AND u.idUsuarios = pu.fk_idUsuarios AND a.idArea = au.fk_idArea AND u.idUsuarios = au.fk_idUsuario WHERE `entregado` = false;

CREATE DEFINER=`yohovani` PROCEDURE `selectRegistrosServicios` ()  READS SQL DATA
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE 1 ORDER BY s.idServicios;

CREATE DEFINER=`yohovani` PROCEDURE `SelectServiciosNoFinalizados` ()  NO SQL
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado,a.nombre FROM servicios s INNER JOIN areas a INNER JOIN servicioarea sa ON s.idServicios = sa.fk_idServicio AND a.idArea = sa.fk_idArea WHERE s.finalizado = 0 ORDER BY s.idServicios;

CREATE DEFINER=`yohovani` PROCEDURE `SelectServiciosNoFinalizadosIndividuales` (IN `idTec` INT(10))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado,s.solucion FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t INNER JOIN areas a INNER JOIN servicioarea sa ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos AND sa.fk_idServicio = s.idServicios AND sa.fk_idArea = a.idArea WHERE s.finalizado = 0 AND t.idTecnicos = idTec AND s.mostrar = false ORDER BY s.idServicios;

CREATE DEFINER=`yohovani` PROCEDURE `selectServiciosNotify` (IN `idUser` INT(100))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado FROM servicios s INNER JOIN serviciosusuarios su INNER JOIN usuarios u ON su.fk_idServicios = s.idServicios AND su.fk_idUsuarios = u.idUsuarios WHERE u.idUsuarios = idUser AND s.finalizado = 0 AND s.mostrar = true;

CREATE DEFINER=`yohovani` PROCEDURE `SelectServiciosUsuario` (IN `idUsuario` INT(10))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado,a.nombre FROM servicios s INNER JOIN serviciosusuarios su INNER JOIN usuarios u INNER JOIN areas a INNER JOIN servicioarea sa ON su.fk_idServicios = s.idServicios AND su.fk_idUsuarios = u.idUsuarios AND s.idServicios = sa.fk_idServicio AND a.idArea = sa.fk_idArea WHERE u.idUsuarios = idUsuario AND s.finalizado = 0;

CREATE DEFINER=`yohovani` PROCEDURE `selectServicosExcel` ()  READS SQL DATA
SELECT s.*,t.nombre,u.usuario,a.idArea,a.nombre as area FROM servicios s INNER JOIN tecnicos t INNER JOIN serviciostecnicos st INNER JOIN usuarios u INNER JOIN serviciosusuarios su INNER JOIN areas a INNER JOIN servicioarea sa ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos AND u.idUsuarios = su.fk_idUsuarios AND su.fk_idServicios = s.idServicios AND s.idServicios = sa.fk_idServicio AND a.idArea = sa.fk_idArea WHERE 1 ORDER BY s.idServicios;

CREATE DEFINER=`yohovani` PROCEDURE `selectServicosExcelFechas` (IN `fecha1` DATE, IN `fecha2` DATE)  READS SQL DATA
SELECT s.*,t.nombre,u.usuario,a.idArea,a.nombre AS area FROM servicios s INNER JOIN tecnicos t INNER JOIN serviciostecnicos st INNER JOIN usuarios u INNER JOIN serviciosusuarios su INNER JOIN areas a INNER JOIN servicioarea sa ON s.idServicios = st.fk_idServicios AND t.idTecnicos = t.idTecnicos AND u.idUsuarios = su.fk_idUsuarios AND su.fk_idServicios = s.idServicios AND s.idServicios = sa.fk_idServicio AND a.idArea = sa.fk_idArea WHERE s.fecha >= fecha1 AND s.fecha_fin <= fecha2;

CREATE DEFINER=`yohovani` PROCEDURE `SelectTecnicoEquipo` (IN `id` INT(10))  READS SQL DATA
SELECT t.nombre FROM equipo e INNER JOIN tecnicos t INNER JOIN equipotecnicos et ON e.idEquipo = et.fk_idEquipo AND et.ifk_dTecnico = t.idTecnicos WHERE e.idEquipo = id;

CREATE DEFINER=`yohovani` PROCEDURE `SelectTecnicos` ()  READS SQL DATA
SELECT * FROM `tecnicos` WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `SelectTecnicoServicio` (IN `id` INT(10))  NO SQL
SELECT t.nombre FROM tecnicos t INNER JOIN servicios s INNER JOIN serviciostecnicos st ON st.fk_idServicios = s.idServicios AND st.fk_idTecnicos = t.idTecnicos WHERE s.idServicios = id;

CREATE DEFINER=`yohovani` PROCEDURE `SelectUsuarios` ()  READS SQL DATA
SELECT u.idUsuarios,u.nombre,u.apellidos,u.usuario,a.nombre as area FROM `usuarios` u INNER JOIN areas a INNER JOIN areausuarios au ON au.fk_idUsuario = u.idUsuarios AND au.fk_idArea = a.idArea WHERE 1;

CREATE DEFINER=`yohovani` PROCEDURE `servicioNoFinalizado` (IN `id` INT(10))  MODIFIES SQL DATA
UPDATE `servicios` SET `mostrar`=false, `finalizadoTecnico`=false WHERE `idServicios` = id;

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
(5, 'AGENCIAS DEL MINISTERIO PÚBLICO ESPECIALES'),
(6, 'AGENCIAS DEL MINISTERIO PÚBLICO ESPECIALES'),
(7, 'AGENCIAS DEL MINISTERIO PÚBLICO INSTRUCTORAS'),
(8, 'CENTRO DE OPERACIÓN ESTRATÉGICA PARA EL NARCOMENUDEO'),
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
(35, 'AGENCIA DEL MINISTERIO PÚBLICO INSTRUCTORA'),
(36, 'AGENCIA DEL MINISTERIO PéBLICO ADSCRITA'),
(37, 'AGENCIA DEL MINISTERIO PéBLICO CONCILIADORA'),
(38, 'SUBDIRECCIÓN GENERAL OPERATIVA'),
(39, 'COORDINACIÓN OPERAIVA'),
(40, 'VINCULACIÓN ADMINISTRATIVA');

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
(1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idCompras` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `area` varchar(45) NOT NULL,
  `articulo` varchar(150) NOT NULL,
  `dictamen` varchar(150) DEFAULT NULL,
  `planeacion` varchar(150) DEFAULT NULL,
  `resuelto` tinyint(1) NOT NULL
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
  `fechaEntrega` date DEFAULT NULL,
  `finalizado` varchar(25) NOT NULL,
  `entregado` tinyint(1) NOT NULL
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
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `respuesta` varchar(100) NOT NULL
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
  `fechaEntrega` date DEFAULT NULL,
  `entregado` tinyint(1) NOT NULL
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
-- Estructura de tabla para la tabla `servicioarea`
--

CREATE TABLE `servicioarea` (
  `fk_idServicio` int(11) NOT NULL,
  `fk_idArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicioarea`
--

INSERT INTO `servicioarea` (`fk_idServicio`, `fk_idArea`) VALUES
(2, 8);

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
  `finalizado` tinyint(4) NOT NULL,
  `finalizadoTecnico` tinyint(4) NOT NULL,
  `solucion` varchar(200) NOT NULL,
  `mostrar` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciostecnicos`
--

CREATE TABLE `serviciostecnicos` (
  `fk_idServicios` int(11) NOT NULL,
  `fk_idTecnicos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciosusuarios`
--

CREATE TABLE `serviciosusuarios` (
  `fk_idServicios` int(11) NOT NULL,
  `fk_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

CREATE TABLE `tecnicos` (
  `idTecnicos` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `recepcion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tecnicos`
--

INSERT INTO `tecnicos` (`idTecnicos`, `nombre`, `password`, `admin`, `recepcion`) VALUES
(1, 'admin', 'admin', 1, 0);

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
  ADD PRIMARY KEY (`idCompras`);

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
  ADD PRIMARY KEY (`idEquipo`);

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
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `servicioarea`
--
ALTER TABLE `servicioarea`
  ADD PRIMARY KEY (`fk_idServicio`,`fk_idArea`),
  ADD KEY `fk_idArea` (`fk_idArea`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idServicios`);

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
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `idPrestamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idServicios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `idTecnicos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

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
-- Filtros para la tabla `servicioarea`
--
ALTER TABLE `servicioarea`
  ADD CONSTRAINT `fk_idArea` FOREIGN KEY (`fk_idArea`) REFERENCES `areas` (`idArea`),
  ADD CONSTRAINT `fk_idServicio` FOREIGN KEY (`fk_idServicio`) REFERENCES `servicios` (`idServicios`);

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
