-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2016 a las 10:25:44
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_registro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignaturas`
--

CREATE TABLE `tbl_asignaturas` (
  `codigo_asignatura` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `alias` varchar(7) NOT NULL,
  `UV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_asignaturas`
--

INSERT INTO `tbl_asignaturas` (`codigo_asignatura`, `nombre`, `alias`, `UV`) VALUES
(7, 'Calculo I', 'MM-201', 4),
(8, 'Matematicas I', 'MM-110', 5),
(10, 'Geometria y Trigonometria', 'MM-111', 5),
(11, 'Programacion I', 'MM-314', 5),
(12, 'Estadistica', 'MM-402', 4),
(13, 'Programacion orientada a objetos', 'IS-410', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_aulas`
--

CREATE TABLE `tbl_aulas` (
  `codigo_aula` int(11) NOT NULL,
  `codigo_edificio` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `alias` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_aulas`
--

INSERT INTO `tbl_aulas` (`codigo_aula`, `codigo_edificio`, `capacidad`, `alias`) VALUES
(1, 1, 7, '101'),
(2, 1, 7, '102'),
(3, 1, 6, '103'),
(4, 2, 6, '101'),
(5, 2, 5, '102'),
(6, 2, 7, '103'),
(7, 3, 6, '101'),
(8, 3, 7, '102'),
(9, 3, 6, '103');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carreras`
--

CREATE TABLE `tbl_carreras` (
  `codigo_carrera` int(11) NOT NULL,
  `codigo_jefe_dept` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `alias` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_carreras`
--

INSERT INTO `tbl_carreras` (`codigo_carrera`, `codigo_jefe_dept`, `nombre`, `alias`) VALUES
(1, 2, 'Ingenieria en Sistemas', 'IS'),
(2, 3, 'Matematicas', 'MM'),
(3, 3, 'Ingenieria Quimica', 'IQ'),
(4, 3, 'Ingenieria Electrica', 'IE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carreras_x_asignaturas`
--

CREATE TABLE `tbl_carreras_x_asignaturas` (
  `codigo_asignatura` int(11) NOT NULL,
  `codigo_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_carreras_x_asignaturas`
--

INSERT INTO `tbl_carreras_x_asignaturas` (`codigo_asignatura`, `codigo_carrera`) VALUES
(7, 2),
(8, 1),
(8, 2),
(8, 3),
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(12, 1),
(12, 2),
(12, 3),
(13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_edificios`
--

CREATE TABLE `tbl_edificios` (
  `codigo_edificio` int(11) NOT NULL,
  `codigo_region` int(11) NOT NULL,
  `alias` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_edificios`
--

INSERT INTO `tbl_edificios` (`codigo_edificio`, `codigo_region`, `alias`) VALUES
(1, 1, 'F1'),
(2, 1, 'D1'),
(3, 1, 'B2'),
(7, 3, 'R3'),
(8, 3, '12'),
(9, 3, '0B'),
(10, 4, '3A'),
(11, 4, '2A'),
(12, 4, '1A'),
(13, 4, '5A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_horarios`
--

CREATE TABLE `tbl_horarios` (
  `codigo_horario` int(11) NOT NULL,
  `horario` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_horarios`
--

INSERT INTO `tbl_horarios` (`codigo_horario`, `horario`) VALUES
(1, 'Lu'),
(2, 'Ma'),
(3, 'Mi'),
(4, 'Ju'),
(5, 'Vi'),
(6, 'Sa'),
(7, 'LuMaMi'),
(8, 'LuMiVi'),
(9, 'LuMaMiJu'),
(10, 'LuMaMiJuVi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_horas_inicio`
--

CREATE TABLE `tbl_horas_inicio` (
  `codigo_hi` int(11) NOT NULL,
  `hora_inicio` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_horas_inicio`
--

INSERT INTO `tbl_horas_inicio` (`codigo_hi`, `hora_inicio`) VALUES
(1, '0600'),
(2, '0700'),
(3, '0800'),
(4, '0900'),
(5, '1000'),
(6, '1100'),
(7, '1200'),
(8, '1300'),
(9, '1400'),
(10, '1500'),
(11, '1600'),
(12, '1700'),
(13, '1800'),
(14, '1900');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `codigo_tipo_usuario` int(11) NOT NULL,
  `url_menu` varchar(25) NOT NULL,
  `menu` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_menus`
--

INSERT INTO `tbl_menus` (`codigo_tipo_usuario`, `url_menu`, `menu`) VALUES
(1, 'nuevo_usuario.php', 'Nuevo usuario'),
(1, 'nuevo_estudiante.php', 'Nuevo estudiante'),
(1, 'nuevo_edificio.php', 'Nuevo edificio'),
(1, 'nueva_aula.php', 'Nueva aula'),
(1, 'nueva_region.php', 'Nueva region'),
(1, 'nuevo_dept.php', 'Nuevo departamento'),
(2, 'nueva_asignatura.php', 'Nueva asignatura'),
(2, 'nueva_seccion.php', 'Nueva seccion'),
(3, 'subir_calificacion.php', 'Subir calificaciones'),
(4, 'matricula.php', 'Matricula'),
(4, 'calificaciones.php', 'Calificaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_regiones`
--

CREATE TABLE `tbl_regiones` (
  `codigo_region` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `alias` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_regiones`
--

INSERT INTO `tbl_regiones` (`codigo_region`, `nombre`, `alias`) VALUES
(1, 'Ciudad Universitaria', 'CU'),
(3, 'Centro Universitario Regional del Litoral Pacifico', 'CURLP'),
(4, 'Valle de Sula', 'VS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_regiones_x_carreras`
--

CREATE TABLE `tbl_regiones_x_carreras` (
  `codigo_region` int(11) NOT NULL,
  `codigo_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_regiones_x_carreras`
--

INSERT INTO `tbl_regiones_x_carreras` (`codigo_region`, `codigo_carrera`) VALUES
(1, 1),
(1, 2),
(1, 3),
(3, 2),
(4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_secciones`
--

CREATE TABLE `tbl_secciones` (
  `codigo_seccion` int(11) NOT NULL,
  `codigo_tipo_seccion` int(11) NOT NULL,
  `codigo_asignatura` int(11) NOT NULL,
  `codigo_aula` int(11) NOT NULL,
  `codigo_horario` int(11) NOT NULL,
  `codigo_catedratico` int(11) NOT NULL,
  `codigo_hi` int(11) NOT NULL,
  `cupos_disponibles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_secciones`
--

INSERT INTO `tbl_secciones` (`codigo_seccion`, `codigo_tipo_seccion`, `codigo_asignatura`, `codigo_aula`, `codigo_horario`, `codigo_catedratico`, `codigo_hi`, `cupos_disponibles`) VALUES
(5, 1, 7, 9, 10, 5, 8, 7),
(6, 2, 11, 1, 9, 5, 10, 5),
(8, 2, 11, 6, 6, 5, 13, 0),
(9, 1, 13, 7, 10, 5, 4, 5),
(10, 1, 12, 6, 9, 4, 10, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_secciones_x_usuarios`
--

CREATE TABLE `tbl_secciones_x_usuarios` (
  `codigo_seccion` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_secciones_x_usuarios`
--

INSERT INTO `tbl_secciones_x_usuarios` (`codigo_seccion`, `codigo_usuario`) VALUES
(6, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_secciones`
--

CREATE TABLE `tbl_tipos_secciones` (
  `codigo_tipo_seccion` int(11) NOT NULL,
  `tipo_seccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipos_secciones`
--

INSERT INTO `tbl_tipos_secciones` (`codigo_tipo_seccion`, `tipo_seccion`) VALUES
(1, 'Clase presencial'),
(2, 'Laboratorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_usuarios`
--

CREATE TABLE `tbl_tipos_usuarios` (
  `codigo_tipo_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipos_usuarios`
--

INSERT INTO `tbl_tipos_usuarios` (`codigo_tipo_usuario`, `tipo_usuario`) VALUES
(1, 'Administrador'),
(2, 'Jefe de departamento'),
(3, 'Catedratico'),
(4, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `codigo_usuario` int(11) NOT NULL,
  `codigo_tipo_usuario` int(11) NOT NULL,
  `codigo_region` int(11) DEFAULT NULL,
  `codigo_carrera` int(11) DEFAULT NULL,
  `codigo_identidad` varchar(100) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` varchar(1) NOT NULL,
  `email` varchar(25) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `url_imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`codigo_usuario`, `codigo_tipo_usuario`, `codigo_region`, `codigo_carrera`, `codigo_identidad`, `nombres`, `apellidos`, `fecha_nacimiento`, `genero`, `email`, `clave`, `url_imagen`) VALUES
(1, 1, NULL, NULL, '0', '@', 'root', '2012-12-12', 'M', 'admin', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/unnamed.png'),
(2, 2, NULL, NULL, '0501-1983-49200', 'Matrin', 'Shkreli', '1983-05-17', 'M', 'martin@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/basedshkreli.jpg'),
(3, 2, NULL, NULL, '0801-1985-29250', 'Barack', 'Obama', '1985-12-12', 'M', 'obama@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/face_PNG5660.png'),
(4, 3, NULL, NULL, '0801-1983-04202', 'Juan', 'Nieves', '1983-12-12', 'M', 'snow@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/juannieves.jpg'),
(5, 3, NULL, NULL, '0701-1965-42040', 'Leonardo', 'DiCaprio', '1965-12-12', 'M', 'dicaprio@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/dicaprio.jpg'),
(6, 4, 1, 1, '0501-1996-00201', 'Andrea', 'Castro', '1996-11-14', 'F', 'andrea@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/1.jpg'),
(7, 4, NULL, 2, '0501-1988-42902', 'Miguel', 'Torres', '1988-12-12', 'M', 'miguel@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/dude.jpg'),
(11, 4, 1, 1, '0501-1996-12812', 'Javier', 'Cano', '1996-11-14', 'M', 'javier@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/omarborkan.jpg'),
(12, 4, NULL, 2, '0801-1937-40205', 'Morgan', 'Freeman', '1937-06-01', 'M', 'morgan@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/morgan.jpg'),
(16, 3, NULL, NULL, '0501-1954-40299', 'Hugh', 'Mungus', '1954-09-21', 'M', 'hughmungus@gmail.com', 'bcdcb29ed2aab16d48c11485264df665e906bdd9', '../imagenes/hugh.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  ADD PRIMARY KEY (`codigo_asignatura`);

--
-- Indices de la tabla `tbl_aulas`
--
ALTER TABLE `tbl_aulas`
  ADD PRIMARY KEY (`codigo_aula`),
  ADD KEY `fk_tbl_aulas_tbl_edificios1_idx` (`codigo_edificio`);

--
-- Indices de la tabla `tbl_carreras`
--
ALTER TABLE `tbl_carreras`
  ADD PRIMARY KEY (`codigo_carrera`),
  ADD KEY `fk_tbl_carreras_tbl_usuarios1_idx` (`codigo_jefe_dept`);

--
-- Indices de la tabla `tbl_carreras_x_asignaturas`
--
ALTER TABLE `tbl_carreras_x_asignaturas`
  ADD PRIMARY KEY (`codigo_asignatura`,`codigo_carrera`),
  ADD KEY `fk_tbl_departamentos_x_asignaturas_tbl_departamentos1_idx` (`codigo_carrera`);

--
-- Indices de la tabla `tbl_edificios`
--
ALTER TABLE `tbl_edificios`
  ADD PRIMARY KEY (`codigo_edificio`),
  ADD KEY `fk_tbl_edificios_tbl_regiones1_idx` (`codigo_region`);

--
-- Indices de la tabla `tbl_horarios`
--
ALTER TABLE `tbl_horarios`
  ADD PRIMARY KEY (`codigo_horario`);

--
-- Indices de la tabla `tbl_horas_inicio`
--
ALTER TABLE `tbl_horas_inicio`
  ADD PRIMARY KEY (`codigo_hi`);

--
-- Indices de la tabla `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD KEY `fk_tbl_menus_tbl_tipos_usuarios1_idx` (`codigo_tipo_usuario`);

--
-- Indices de la tabla `tbl_regiones`
--
ALTER TABLE `tbl_regiones`
  ADD PRIMARY KEY (`codigo_region`);

--
-- Indices de la tabla `tbl_regiones_x_carreras`
--
ALTER TABLE `tbl_regiones_x_carreras`
  ADD PRIMARY KEY (`codigo_region`,`codigo_carrera`),
  ADD KEY `fk_tbl_region_x_departamentos_tbl_departamentos1_idx` (`codigo_carrera`);

--
-- Indices de la tabla `tbl_secciones`
--
ALTER TABLE `tbl_secciones`
  ADD PRIMARY KEY (`codigo_seccion`),
  ADD KEY `fk_tbl_secciones_tbl_asignaturas1_idx` (`codigo_asignatura`),
  ADD KEY `fk_tbl_secciones_tbl_aulas1_idx` (`codigo_aula`),
  ADD KEY `fk_tbl_secciones_tbl_horarios1_idx` (`codigo_horario`),
  ADD KEY `fk_tbl_secciones_tbl_usuarios1_idx` (`codigo_catedratico`),
  ADD KEY `fk_tbl_secciones_tbl_horas_inicio1_idx` (`codigo_hi`),
  ADD KEY `fk_tbl_secciones_tbl_tipos_secciones1_idx` (`codigo_tipo_seccion`);

--
-- Indices de la tabla `tbl_secciones_x_usuarios`
--
ALTER TABLE `tbl_secciones_x_usuarios`
  ADD PRIMARY KEY (`codigo_seccion`,`codigo_usuario`),
  ADD KEY `fk_tbl_secciones_x_usuarios_tbl_usuarios1_idx` (`codigo_usuario`);

--
-- Indices de la tabla `tbl_tipos_secciones`
--
ALTER TABLE `tbl_tipos_secciones`
  ADD PRIMARY KEY (`codigo_tipo_seccion`);

--
-- Indices de la tabla `tbl_tipos_usuarios`
--
ALTER TABLE `tbl_tipos_usuarios`
  ADD PRIMARY KEY (`codigo_tipo_usuario`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`codigo_usuario`),
  ADD KEY `fk_tbl_usuarios_tbl_tipos_usuarios1_idx` (`codigo_tipo_usuario`),
  ADD KEY `fk_tbl_usuarios_tbl_regiones1_idx` (`codigo_region`),
  ADD KEY `fk_tbl_usuarios_tbl_departamentos1_idx` (`codigo_carrera`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  MODIFY `codigo_asignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `tbl_aulas`
--
ALTER TABLE `tbl_aulas`
  MODIFY `codigo_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `tbl_carreras`
--
ALTER TABLE `tbl_carreras`
  MODIFY `codigo_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbl_edificios`
--
ALTER TABLE `tbl_edificios`
  MODIFY `codigo_edificio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `tbl_horarios`
--
ALTER TABLE `tbl_horarios`
  MODIFY `codigo_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `tbl_horas_inicio`
--
ALTER TABLE `tbl_horas_inicio`
  MODIFY `codigo_hi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `tbl_regiones`
--
ALTER TABLE `tbl_regiones`
  MODIFY `codigo_region` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbl_secciones`
--
ALTER TABLE `tbl_secciones`
  MODIFY `codigo_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `tbl_tipos_secciones`
--
ALTER TABLE `tbl_tipos_secciones`
  MODIFY `codigo_tipo_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tbl_tipos_usuarios`
--
ALTER TABLE `tbl_tipos_usuarios`
  MODIFY `codigo_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_aulas`
--
ALTER TABLE `tbl_aulas`
  ADD CONSTRAINT `fk_tbl_aulas_tbl_edificios1` FOREIGN KEY (`codigo_edificio`) REFERENCES `tbl_edificios` (`codigo_edificio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_carreras`
--
ALTER TABLE `tbl_carreras`
  ADD CONSTRAINT `fk_tbl_carreras_tbl_usuarios1` FOREIGN KEY (`codigo_jefe_dept`) REFERENCES `tbl_usuarios` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_carreras_x_asignaturas`
--
ALTER TABLE `tbl_carreras_x_asignaturas`
  ADD CONSTRAINT `fk_tbl_departamentos_x_asignaturas_tbl_asignaturas1` FOREIGN KEY (`codigo_asignatura`) REFERENCES `tbl_asignaturas` (`codigo_asignatura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_departamentos_x_asignaturas_tbl_departamentos1` FOREIGN KEY (`codigo_carrera`) REFERENCES `tbl_carreras` (`codigo_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_edificios`
--
ALTER TABLE `tbl_edificios`
  ADD CONSTRAINT `fk_tbl_edificios_tbl_regiones1` FOREIGN KEY (`codigo_region`) REFERENCES `tbl_regiones` (`codigo_region`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD CONSTRAINT `fk_tbl_menus_tbl_tipos_usuarios1` FOREIGN KEY (`codigo_tipo_usuario`) REFERENCES `tbl_tipos_usuarios` (`codigo_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_regiones_x_carreras`
--
ALTER TABLE `tbl_regiones_x_carreras`
  ADD CONSTRAINT `fk_tbl_region_x_departamentos_tbl_departamentos1` FOREIGN KEY (`codigo_carrera`) REFERENCES `tbl_carreras` (`codigo_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_region_x_departamentos_tbl_regiones` FOREIGN KEY (`codigo_region`) REFERENCES `tbl_regiones` (`codigo_region`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_secciones`
--
ALTER TABLE `tbl_secciones`
  ADD CONSTRAINT `fk_tbl_secciones_tbl_asignaturas1` FOREIGN KEY (`codigo_asignatura`) REFERENCES `tbl_asignaturas` (`codigo_asignatura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_secciones_tbl_aulas1` FOREIGN KEY (`codigo_aula`) REFERENCES `tbl_aulas` (`codigo_aula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_secciones_tbl_horarios1` FOREIGN KEY (`codigo_horario`) REFERENCES `tbl_horarios` (`codigo_horario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_secciones_tbl_horas_inicio1` FOREIGN KEY (`codigo_hi`) REFERENCES `tbl_horas_inicio` (`codigo_hi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_secciones_tbl_tipos_secciones1` FOREIGN KEY (`codigo_tipo_seccion`) REFERENCES `tbl_tipos_secciones` (`codigo_tipo_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_secciones_tbl_usuarios1` FOREIGN KEY (`codigo_catedratico`) REFERENCES `tbl_usuarios` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_secciones_x_usuarios`
--
ALTER TABLE `tbl_secciones_x_usuarios`
  ADD CONSTRAINT `fk_tbl_secciones_x_usuarios_tbl_secciones1` FOREIGN KEY (`codigo_seccion`) REFERENCES `tbl_secciones` (`codigo_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_secciones_x_usuarios_tbl_usuarios1` FOREIGN KEY (`codigo_usuario`) REFERENCES `tbl_usuarios` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `fk_tbl_usuarios_tbl_departamentos1` FOREIGN KEY (`codigo_carrera`) REFERENCES `tbl_carreras` (`codigo_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_usuarios_tbl_regiones1` FOREIGN KEY (`codigo_region`) REFERENCES `tbl_regiones` (`codigo_region`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_usuarios_tbl_tipos_usuarios1` FOREIGN KEY (`codigo_tipo_usuario`) REFERENCES `tbl_tipos_usuarios` (`codigo_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
