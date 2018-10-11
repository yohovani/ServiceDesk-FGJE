-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2018 a las 19:31:27
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE servicedesk;
use servicedesk;
--
-- Base de datos: `servicedesk`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiarAdmin` (IN `idTecnico` INT(10), IN `cambio` BOOLEAN)  MODIFIES SQL DATA
UPDATE `tecnicos` SET `admin`=cambio WHERE tecnicos.idTecnicos = idTecnico$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiarRecepcion` (IN `idTecnico` INT(10), IN `cambio` BOOLEAN)  MODIFIES SQL DATA
UPDATE `tecnicos` SET `recepcion`=cambio WHERE tecnicos.idTecnicos = idTecnico$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `entregarEquipo` (IN `fecha` DATE, IN `id` INT)  MODIFIES SQL DATA
UPDATE `equipo` SET `fechaEntrega`= fecha ,`entregado`= true WHERE `idEquipo` = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `finalizarCompra` (IN `idCompra` INT(10))  MODIFIES SQL DATA
UPDATE `compras` SET `resuelto`= true WHERE `idCompras` = idCompra$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `finalizarEquipo` (IN `id` INT(10))  NO SQL
UPDATE `equipo` SET `finalizado`= true WHERE `idEquipo` = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FinalizarPrestamo` (IN `idP` INT(10), IN `fecha` DATE)  MODIFIES SQL DATA
UPDATE `prestamos` SET `fechaEntrega` = fecha,`entregado`= true WHERE `idPrestamo` = idP$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FinalizarServicio` (IN `idS` INT(10), IN `hf` TIME, IN `ff` DATE)  MODIFIES SQL DATA
UPDATE `servicios` SET `fecha_fin` = ff,`horaFin`= hf ,`finalizado`=  1 WHERE  `idServicios` = idS$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarAreaUsuarios` (IN `idUsuario` INT(10), IN `idArea` INT(10))  MODIFIES SQL DATA
INSERT INTO `areausuarios`(`fk_idUsuario`, `fk_idArea`) VALUES (idUsuario,idArea)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarCompra` (IN `fecha` DATE, IN `area` VARCHAR(100), IN `articulo` VARCHAR(200), IN `dictamen` VARCHAR(200), IN `planeacion` VARCHAR(200))  MODIFIES SQL DATA
INSERT INTO `compras`(`fecha`, `area`, `articulo`, `dictamen`, `planeacion`, `resuelto`) VALUES (fecha,area,articulo,dictamen,planeacion,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarEquipo` (IN `fecha` DATE, IN `area` VARCHAR(100), IN `movil` VARCHAR(100), IN `servicio` VARCHAR(100), IN `equipo` VARCHAR(150))  MODIFIES SQL DATA
INSERT INTO `equipo`(`fecha`, `area`, `extencionMovil`, `descripcionSrv`, `descripcionEquipo`, `finalizado`, `entregado`) VALUES (fecha,area,movil,servicio,equipo,false,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarFalla` (IN `fecha` VARCHAR(20), IN `hi` TIME, IN `tipo` VARCHAR(50), IN `descripcion` VARCHAR(100), IN `area` VARCHAR(100))  MODIFIES SQL DATA
INSERT INTO `servicios`(`fecha`, `horaInicio`, `tipoServicio`, `descripcion`, `ubicacion`, `finalizado`) VALUES (fecha,hi,tipo,descripcion,area,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarPrestamo` (IN `fecha` DATE, IN `descripcion` VARCHAR(200), IN `mot` VARCHAR(200))  MODIFIES SQL DATA
INSERT INTO `prestamos`(`fechaActual`, `descripcion`, `motivo`,`entregado`) VALUES (fecha,descripcion,mot,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarTecnico` (IN `name` VARCHAR(50), IN `pass` VARCHAR(50))  NO SQL
INSERT INTO `tecnicos`(`nombre`, `password`, `admin`) VALUES (name,pass,false)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarUsuario` (IN `name` VARCHAR(50), IN `ap` VARCHAR(50), IN `usuario` VARCHAR(50))  MODIFIES SQL DATA
INSERT INTO `usuarios`(nombre, apellidos, usuario) VALUES (name,ap,usuario)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RelacionComprasUsuarios` (IN `idUser` INT(10), IN `idCompra` INT(10))  MODIFIES SQL DATA
INSERT INTO `comprasusuarios`(`fk_idCompras`, `fk_idUsuarios`) VALUES (idCompra,idUser)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `relacionEquiposTecnicos` (IN `idEquipo` INT(10), IN `idTecnico` INT(10))  MODIFIES SQL DATA
INSERT INTO `equipotecnicos`(`fk_idEquipo`, `ifk_dTecnico`) VALUES (idEquipo,idTecnico)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RelacionEquipoUsuarios` (IN `idEquipo` INT(10), IN `idUsuario` INT(10))  READS SQL DATA
INSERT INTO `equipousuarios`(`fk_idEquipo`, `fk_idUsuarios`) VALUES (idEquipo,idUsuario)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RelacionPrestamosUsuarios` (IN `idUser` INT(10), IN `idPrestamo` INT(10))  MODIFIES SQL DATA
INSERT INTO `prestamosusuarios`(`fk_idUsuarios`, `fk_idPrestamos`) VALUES (idUser,idPrestamo)$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectCompras` ()  READS SQL DATA
SELECT * FROM compras WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectComprasAdmin` ()  READS SQL DATA
Select c.*,u.usuario FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON cu.fk_idCompras = c.idCompras AND cu.fk_idUsuarios = u.idUsuarios WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectComprasNoFinalizadas` ()  READS SQL DATA
SELECT c.idCompras,c.fecha,u.usuario,c.area,c.articulo,c.dictamen,c.planeacion FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON cu.fk_idCompras = c.idCompras AND cu.fk_idUsuarios = u.idUsuarios WHERE c.resuelto = false$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectComprasUsuario` (IN `userid` INT(10))  READS SQL DATA
SELECT c.idCompras,c.fecha,c.articulo,c.planeacion FROM compras c INNER JOIN usuarios u INNER JOIN comprasusuarios cu ON c.idCompras = cu.fk_idCompras AND u.idUsuarios = cu.fk_idUsuarios WHERE u.idUsuarios = userid AND c.resuelto = false$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectEquipoAdmin` ()  READS SQL DATA
SELECT e.*,u.usuario,t.nombre FROM equipo e INNER JOIN tecnicos t INNER JOIN equipotecnicos et INNER JOIN usuarios u INNER JOIN equipousuarios eu ON eu.fk_idEquipo = e.idEquipo AND eu.fk_idUsuarios = u.idUsuarios AND et.fk_idEquipo = e.idEquipo AND et.ifk_dTecnico = t.idTecnicos WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectEquipoNoEntregado` ()  READS SQL DATA
SELECT e.idEquipo,e.fecha,u.usuario,e.area,e.extencionMovil,e.descripcionSrv,e.descripcionEquipo,e.finalizado FROM equipo e INNER JOIN usuarios u INNER JOIN equipousuarios eu ON e.idEquipo = eu.fk_idEquipo AND u.idUsuarios = eu.fk_idUsuarios WHERE entregado = false$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectEquipos` ()  READS SQL DATA
SELECT * FROM equipo WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectEquipoTecnicoIndividual` (IN `id` INT(10))  READS SQL DATA
SELECT e.idEquipo,e.fecha,e.area,e.extencionMovil,e.descripcionSrv,e.descripcionEquipo,e.finalizado FROM equipo e INNER JOIN tecnicos t INNER JOIN equipotecnicos et ON et.fk_idEquipo = e.idEquipo AND et.ifk_dTecnico = t.idTecnicos WHERE e.finalizado = false AND t.idTecnicos = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectEquipoUsuario` (IN `idUser` INT(10))  READS SQL DATA
SELECT e.idEquipo,e.fecha,e.descripcionSrv,e.descripcionEquipo,e.finalizado FROM equipo e INNER JOIN usuarios u INNER JOIN equipousuarios eu ON eu.fk_idEquipo = e.idEquipo AND eu.fk_idUsuarios = u.idUsuarios
 WHERE e.entregado = false AND u.idUsuarios = idUser$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectOnlyTecnicos` ()  READS SQL DATA
SELECT t.idTecnicos, t.nombre FROM tecnicos t WHERE t.admin =false and t.recepcion = false$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectPrestamos` ()  READS SQL DATA
SELECT * FROM `prestamos` WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectPrestamosAdmin` ()  READS SQL DATA
SELECT p.*,u.nombre,a.nombre as area FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areas a INNER JOIN areausuarios au ON u.idUsuarios = pu.fk_idUsuarios AND p.idPrestamo = pu.fk_idPrestamos AND u.idUsuarios = au.fk_idUsuario AND a.idArea = au.fk_idArea WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectPrestamosIndividuales` (IN `idUser` INT(10))  READS SQL DATA
SELECT p.idPrestamo,p.fechaActual,p.descripcion,p.motivo,u.usuario,a.nombre FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areausuarios au INNER JOIN areas a ON p.idPrestamo = pu.fk_idPrestamos AND u.idUsuarios = pu.fk_idUsuarios AND a.idArea = au.fk_idArea AND u.idUsuarios = au.fk_idUsuario WHERE `entregado` = false and u.idUsuarios = idUser$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectPrestamosNoFinalizados` ()  READS SQL DATA
SELECT p.idPrestamo,p.fechaActual,p.descripcion,p.motivo,u.usuario,a.nombre FROM prestamos p INNER JOIN usuarios u INNER JOIN prestamosusuarios pu INNER JOIN areausuarios au INNER JOIN areas a ON p.idPrestamo = pu.fk_idPrestamos AND u.idUsuarios = pu.fk_idUsuarios AND a.idArea = au.fk_idArea AND u.idUsuarios = au.fk_idUsuario WHERE `entregado` = false$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectRegistrosServicios` ()  READS SQL DATA
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE 1 ORDER BY s.idServicios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectServiciosNoFinalizados` ()  NO SQL
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado FROM servicios s WHERE s.finalizado = 0 ORDER BY s.idServicios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectServiciosNoFinalizadosIndividuales` (IN `idTec` INT(10))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.fecha_fin,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,t.nombre,s.finalizado FROM servicios s INNER JOIN serviciostecnicos st INNER JOIN tecnicos t ON s.idServicios = st.fk_idServicios AND t.idTecnicos = st.fk_idTecnicos WHERE s.finalizado = 0 AND t.idTecnicos = idTec ORDER BY s.idServicios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectServiciosUsuario` (IN `idUsuario` INT(10))  READS SQL DATA
SELECT s.idServicios,s.fecha,s.horaInicio,s.horaFin,s.tipoServicio,s.descripcion,s.ubicacion,s.finalizado FROM servicios s INNER JOIN serviciosusuarios su INNER JOIN usuarios u ON su.fk_idServicios = s.idServicios AND su.fk_idUsuarios = u.idUsuarios WHERE u.idUsuarios = idUsuario AND s.finalizado = 0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectTecnicoEquipo` (IN `id` INT(10))  READS SQL DATA
SELECT t.nombre FROM equipo e INNER JOIN tecnicos t INNER JOIN equipotecnicos et ON e.idEquipo = et.fk_idEquipo AND et.ifk_dTecnico = t.idTecnicos WHERE e.idEquipo = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectTecnicos` ()  READS SQL DATA
SELECT * FROM `tecnicos` WHERE 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectTecnicoServicio` (IN `id` INT(10))  NO SQL
SELECT t.nombre FROM tecnicos t INNER JOIN servicios s INNER JOIN serviciostecnicos st ON st.fk_idServicios = s.idServicios AND st.fk_idTecnicos = t.idTecnicos WHERE s.idServicios = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectUsuarios` ()  READS SQL DATA
SELECT u.idUsuarios,u.nombre,u.apellidos,u.usuario,a.nombre as area FROM `usuarios` u INNER JOIN areas a INNER JOIN areausuarios au ON au.fk_idUsuario = u.idUsuarios AND au.fk_idArea = a.idArea WHERE 1$$

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
(2, 1),
(3, 9);

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

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`idCompras`, `fecha`, `area`, `articulo`, `dictamen`, `planeacion`, `resuelto`) VALUES
(5, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 'terjeta de red', 'no tiene', '1 semana', 1),
(6, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 'terjeta de red', 'no tiene', '1 semana', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprasusuarios`
--

CREATE TABLE `comprasusuarios` (
  `fk_idCompras` int(11) NOT NULL,
  `fk_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comprasusuarios`
--

INSERT INTO `comprasusuarios` (`fk_idCompras`, `fk_idUsuarios`) VALUES
(5, 2),
(6, 2);

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

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`idEquipo`, `fecha`, `area`, `extencionMovil`, `descripcionSrv`, `descripcionEquipo`, `fechaEntrega`, `finalizado`, `entregado`) VALUES
(1, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234', 'Test equipos', 'Laptop', NULL, '0', 0),
(2, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234', 'Test equipos', 'Laptop', NULL, '0', 0),
(3, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234', 'Test equipos', 'Laptop', NULL, '0', 0),
(4, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234', 'Test equipos', 'Laptop', NULL, '0', 0),
(5, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234', 'Test equipos', 'Laptop', '2018-09-27', '0', 1),
(6, '2018-09-27', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234567', 'laptop', 'laptop hp', '2018-10-02', '1', 1),
(7, '2018-10-02', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '123456789', 'El equipo no enciende', 'Laptop', '2018-10-02', '1', 1),
(8, '2018-10-05', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '1234', 'hegd', 'sdhgfdsf\r\n', '2018-10-05', '1', 1),
(9, '2018-10-05', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', '12334', 'dgf', 'ggnf', '2018-10-05', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipotecnicos`
--

CREATE TABLE `equipotecnicos` (
  `fk_idEquipo` int(11) NOT NULL,
  `ifk_dTecnico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `equipotecnicos`
--

INSERT INTO `equipotecnicos` (`fk_idEquipo`, `ifk_dTecnico`) VALUES
(6, 8),
(7, 8),
(8, 8),
(9, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipousuarios`
--

CREATE TABLE `equipousuarios` (
  `fk_idEquipo` int(11) NOT NULL,
  `fk_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `equipousuarios`
--

INSERT INTO `equipousuarios` (`fk_idEquipo`, `fk_idUsuarios`) VALUES
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2);

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

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`idPrestamo`, `fechaActual`, `descripcion`, `motivo`, `fechaEntrega`, `entregado`) VALUES
(1, '2018-09-19', 'Test 1', 'Test 1', NULL, 0),
(2, '2018-09-19', 'Test 1', 'Test 1', NULL, 0),
(3, '2018-09-19', 'Test 2', 'Test 2', '2018-09-19', 1),
(4, '2018-09-27', 'laptop', 'test', '2018-10-02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamosusuarios`
--

CREATE TABLE `prestamosusuarios` (
  `fk_idUsuarios` int(11) NOT NULL,
  `fk_idPrestamos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `prestamosusuarios`
--

INSERT INTO `prestamosusuarios` (`fk_idUsuarios`, `fk_idPrestamos`) VALUES
(2, 4),
(3, 3);

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
  `finalizado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`idServicios`, `fecha`, `fecha_fin`, `horaInicio`, `horaFin`, `tipoServicio`, `descripcion`, `ubicacion`, `finalizado`) VALUES
(7, '2018-09-13', '2018-09-13', '11:22:05', '17:50:00', 'Excel', 'Prueba 2', 'DEPARTAMEN', 1),
(10, '2018-09-13', '2018-09-13', '11:31:37', '17:51:00', 'Permisos de Red', 'Prueba 5', 'DEPARTAMEN', 1),
(11, '2018-09-13', '2018-09-13', '17:56:45', '19:28:10', 'Internet', 'Prueba x', 'DEPARTAMEN', 1),
(12, '2018-09-13', '2018-09-13', '17:58:38', '19:29:09', 'Impresora', 'Prueba x1', 'DEPARTAMEN', 1),
(13, '2018-09-13', '2018-09-13', '17:58:49', '19:29:18', 'Word', 'Word ghjg', 'DEPARTAMEN', 1),
(14, '2018-09-13', '2018-09-13', '17:59:05', '19:44:34', 'Permisos de Red', 'Error', 'DEPARTAMEN', 1),
(15, '2018-09-13', '2018-09-13', '19:13:43', '19:44:31', 'Internet', 'test', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(16, '2018-09-14', '2018-09-14', '12:43:06', '12:47:01', 'Internet', 'sdfsfds', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(17, '2018-09-14', '2018-09-15', '12:50:53', '18:37:21', 'Internet', 'gfhjf', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(18, '2018-09-14', '2018-09-19', '12:52:05', '17:31:15', 'Internet', 'uiyi', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(19, '2018-09-14', '2018-09-15', '12:52:10', '18:36:37', 'Internet', 'opupioj', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(20, '2018-09-14', '2018-09-19', '19:18:08', '17:33:14', 'Word', 'nguguj', 'AGENCIA DEL MINISTERIO ESPECIALIZADA PARA EL DELITO FEMINICIDIO', 1),
(21, '2018-09-17', '2018-09-19', '09:30:02', '17:32:02', 'Excel', 'vcghc', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(22, '2018-09-19', '2018-09-19', '17:54:24', '17:55:33', '', '', '', 1),
(23, '2018-09-19', '2018-09-19', '18:47:58', '19:08:30', 'Internet', 'xzc<', 'AGENCIA DEL MINISTERIO ESPECIALIZADA PARA EL DELITO FEMINICIDIO', 1),
(24, '2018-09-21', '2018-09-21', '14:12:36', '14:18:23', 'Internet', 'regrg', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(25, '2018-09-27', '2018-09-27', '14:33:44', '14:34:36', 'Internet', 'test', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(26, '2018-09-27', '2018-10-02', '19:52:16', '16:54:02', 'Internet', 'test', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(27, '2018-09-27', '2018-10-02', '19:53:46', '16:54:03', 'Word', 'test2', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(28, '2018-09-27', '2018-10-02', '19:53:57', '16:54:04', 'Excel', 'Test 3', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(29, '2018-10-02', '2018-10-02', '15:42:42', '16:54:05', 'Internet', 'test', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1),
(30, '2018-10-05', '2018-10-05', '10:27:52', '10:30:00', 'Internet', 'sad', 'DEPARTAMENTO DE RECURSOS FINANCIEROS', 1);

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
(15, 1),
(16, 7),
(17, 1),
(18, 7),
(19, 1),
(20, 7),
(21, 1),
(22, 1),
(23, 7),
(24, 1),
(25, 1),
(26, 7),
(27, 7),
(28, 1),
(29, 8),
(30, 8);

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
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 3),
(21, 2),
(22, 3),
(23, 3),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2);

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
(1, 'admin', 'admin', 1, 0),
(7, 't1', 'asdf', 0, 1),
(8, 'qwerty', 'qwerty', 0, 0);

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
(2, 'test', 'test', 'test'),
(3, 'test2', 'test2', 'tt2');

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
  MODIFY `idCompras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `idEquipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `idPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idServicios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `idTecnicos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
