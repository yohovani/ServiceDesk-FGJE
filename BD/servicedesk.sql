-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2019 a las 21:01:40
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

--
-- Base de datos: `servicedesk
--

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
  MODIFY `idServicios` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `idTecnicos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT;

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
