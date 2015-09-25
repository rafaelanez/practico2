-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2015 a las 00:28:05
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practico2`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblCategoria_Delete`(IN `idParam` INT)
    NO SQL
DELETE FROM tblcategoria
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblCategoria_Insert`(IN `nombreParam` VARCHAR(100), IN `colorParam` VARCHAR(100))
    NO SQL
INSERT INTO tblcategoria(nombre,color) VALUES (nombreParam,colorParam)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblCategoria_SelectAll`()
    NO SQL
SELECT id,
	   nombre,
       color
FROM tblcategoria$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblCategoria_SelectById`(IN `idParam` INT)
    NO SQL
SELECT id,
	   nombre,
       color
FROM tblcategoria
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblCategoria_Update`(IN `idParam` INT, IN `nombreParam` VARCHAR(100), IN `colorParam` VARCHAR(100))
    NO SQL
UPDATE tblcategoria
SET nombre = nombreParam,
	color = colorParam
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Archivar`(IN `idParam` INT)
    NO SQL
UPDATE tblnota
SET estado = false
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Delete`(IN `idParam` INT)
    NO SQL
DELETE FROM tblnota
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Insert`(IN `notaParam` TEXT, IN `idCategoriaParam` INT)
    NO SQL
INSERT INTO tblnota(nota,
                    idCategoria)
VALUES (notaParam,
        idCategoriaParam)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_SearchNota`(IN `searchTextParam` TEXT)
    NO SQL
SELECT id,
	   fecha,
       titulo,
       nota,
       estado,
       idCategoria
FROM tblnota
WHERE MATCH (id,fecha,titulo,nota) AGAINST (searchTextParam)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_SelectAll`()
    NO SQL
SELECT id,
	   fecha,
       titulo,
       nota,
       estado,
       idCategoria
FROM tblnota$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_SelectByCategoria`(IN `idCategoriaParam` INT)
    NO SQL
SELECT id,
	   fecha,
       titulo,
       nota,
       estado,
       idCategoria
FROM tblnota
WHERE idCategoria = idCategoriaParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_SelectById`(IN `idParam` INT)
    NO SQL
SELECT id,
	   fecha,
       titulo,
       nota,
       estado,
       idCategoria
FROM tblnota
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Update`(IN `idParam` INT, IN `fechaParam` DATETIME, IN `tituloParam` TEXT, IN `notaParam` TEXT)
    NO SQL
UPDATE tblnota
SET fecha = fechaParam,
	titulo = tituloParam,
    nota = notaParam
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_UpdateCategoria`(IN `idParam` INT, IN `idCategoriaParam` INT)
    NO SQL
UPDATE tblnota
SET idCategoria = idCategoriaParam
WHERE id = idParam$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcategoria`
--

CREATE TABLE IF NOT EXISTS `tblcategoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblcategoria`
--

INSERT INTO `tblcategoria` (`id`, `nombre`, `color`) VALUES
(2, 'Importante', 'rojo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblnota`
--

CREATE TABLE IF NOT EXISTS `tblnota` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` text NOT NULL,
  `nota` text NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblnota`
--

INSERT INTO `tblnota` (`id`, `fecha`, `titulo`, `nota`, `estado`, `idCategoria`) VALUES
(1, '2015-09-25 14:44:15', '', 'Esta es una nueva nota', 1, 2),
(2, '2015-09-25 14:44:55', '', '', 0, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tblcategoria`
--
ALTER TABLE `tblcategoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_Categoria` (`nombre`);

--
-- Indices de la tabla `tblnota`
--
ALTER TABLE `tblnota`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tblcategoria`
--
ALTER TABLE `tblcategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tblnota`
--
ALTER TABLE `tblnota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
