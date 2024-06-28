-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2024 a las 00:47:02
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `actividades_universitarias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `carreras_id` int(11) NOT NULL,
  `car_nombre` varchar(255) NOT NULL,
  `car_duracion` int(11) NOT NULL,
  `car_tipo` varchar(1) NOT NULL,
  `car_activo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`carreras_id`, `car_nombre`, `car_duracion`, `car_tipo`, `car_activo`) VALUES
(1, 'Ingeniería Informática', 5, 'G', 'A'),
(2, 'Medicina', 5, 'G', 'A'),
(4, 'Lic. en Psicología', 3, 'G', 'A'),
(5, 'Economía', 2, 'G', 'A'),
(6, 'Derecho', 4, 'G', 'A'),
(7, 'Ingeniería Comercial', 4, 'G', 'A'),
(8, 'Contaduría Pública', 2, 'G', 'A'),
(9, 'Diseño Gráfico', 3, 'G', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `publicaciones_id` int(11) NOT NULL,
  `pub_descripcion` varchar(255) NOT NULL,
  `pub_image` varchar(255) NOT NULL,
  `pub_fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `pub_fecha_evento` timestamp NULL DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`publicaciones_id`, `pub_descripcion`, `pub_image`, `pub_fecha_publicacion`, `pub_fecha_evento`, `usuarios_id`) VALUES
(1, 'Crea la mejor versión profesional de tí mismo', 'imagen_profesional.PNG', '2024-06-07 23:11:15', '2024-06-07 04:00:00', 11),
(2, 'Fortalece tus conocimientos', 'criptomonedas.PNG', '2024-06-07 23:13:30', '2024-06-30 04:00:00', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones_carreras`
--

CREATE TABLE `publicaciones_carreras` (
  `publicaciones_carreras_id` int(11) NOT NULL,
  `publicaciones_id` int(11) NOT NULL,
  `carreras_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publicaciones_carreras`
--

INSERT INTO `publicaciones_carreras` (`publicaciones_carreras_id`, `publicaciones_id`, `carreras_id`) VALUES
(15, 1, 1),
(16, 1, 4),
(17, 1, 6),
(18, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones_carreras_anios`
--

CREATE TABLE `publicaciones_carreras_anios` (
  `publicaciones_carreras_id` int(11) NOT NULL,
  `pubcarani_anio` int(11) NOT NULL,
  `publicaciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publicaciones_carreras_anios`
--

INSERT INTO `publicaciones_carreras_anios` (`publicaciones_carreras_id`, `pubcarani_anio`, `publicaciones_id`) VALUES
(15, 1, 1),
(15, 2, 1),
(15, 3, 1),
(16, 1, 1),
(16, 2, 1),
(17, 1, 1),
(17, 2, 1),
(17, 3, 1),
(17, 4, 1),
(18, 1, 2),
(18, 2, 2),
(18, 3, 2),
(18, 4, 2),
(18, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarios_id` int(11) NOT NULL,
  `usu_nombre` varchar(255) NOT NULL,
  `usu_contraseña` varchar(255) NOT NULL,
  `usu_tipo` int(11) NOT NULL,
  `usu_activo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuarios_id`, `usu_nombre`, `usu_contraseña`, `usu_tipo`, `usu_activo`) VALUES
(11, 'Fernando', '123456', 9999, 'A'),
(12, 'martinez', '123456', 2, 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`carreras_id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`publicaciones_id`);

--
-- Indices de la tabla `publicaciones_carreras`
--
ALTER TABLE `publicaciones_carreras`
  ADD PRIMARY KEY (`publicaciones_carreras_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarios_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `carreras_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `publicaciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `publicaciones_carreras`
--
ALTER TABLE `publicaciones_carreras`
  MODIFY `publicaciones_carreras_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarios_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
