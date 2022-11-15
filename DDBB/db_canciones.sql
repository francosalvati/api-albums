-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2022 a las 22:31:39
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_canciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `banda` varchar(60) NOT NULL,
  `genero` varchar(60) NOT NULL,
  `anio` int(11) NOT NULL,
  `cant_canciones` int(11) NOT NULL,
  `imgURL` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`id`, `nombre`, `banda`, `genero`, `anio`, `cant_canciones`, `imgURL`) VALUES
(1, 'Devorando Intensidad', 'El plan de la mariposa', 'Rock', 2017, 13, 'https://i.scdn.co/image/ab67616d0000b273f8eaa1230efe02e0be3fb1b7'),
(2, 'vida', 'sui generis', 'rock nacional', 1972, 11, 'https://upload.wikimedia.org/wikipedia/commons/0/01/Sui_Generis_-_Vida.jpg'),
(3, 'Oktubre', 'Patricio rey y sus redonditos de ricota', 'Rock nacional', 1986, 9, 'https://www.cmtv.com.ar/tapas-cd/redondosoktubre.jpg'),
(21, 'Eco', 'Jorge Drexler', 'Pop, Rock', 2004, 12, 'https://i.scdn.co/image/ab67616d0000b273c943c87f0730e247a6fb027b'),
(23, 'asdasd', 'asdasdak', '2017', 0, 13, 'https://i.scdn.co/image/ab67616d0000b273f8eaa1230efe02e0be3fb1b7'),
(24, 'asdasd', 'asdasdak', '2017', 0, 13, 'https://i.scdn.co/image/ab67616d0000b273f8eaa1230efe02e0be3fb1b7'),
(25, 'asdasd', 'asdasdak', '2017', 0, 13, 'https://i.scdn.co/image/ab67616d0000b273f8eaa1230efe02e0be3fb1b7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `duracion` int(11) NOT NULL,
  `id_album_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`id`, `nombre`, `duracion`, `id_album_fk`) VALUES
(2, 'Cancion para mi muerte', 335, 2),
(5, 'Cuando comenzamos a nacer', 243, 2),
(6, 'Amigo vuelve pronto', 325, 2),
(8, 'Fuegos de octubre', 338, 3),
(9, 'Preso en mi ciudad', 403, 3),
(10, 'Musica para pastillas', 435, 3),
(11, 'Semen-Up', 522, 3),
(12, 'El riesgo', 429, 1),
(13, 'Mar argentino', 343, 1),
(14, 'Invierno nuclear', 409, 1),
(15, 'Como decir que no?', 419, 1),
(16, 'Cruz del sur', 430, 1),
(17, 'invierno loco', 222, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `contraseña` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `contraseña`) VALUES
(1, 'admin1', '$2a$12$UdFHoiSnkqS3sp6PJd7XY.lT54irsDff6YF/fPVrVMrrI4Cn84w6q');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_album_fk` (`id_album_fk`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`id_album_fk`) REFERENCES `album` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
