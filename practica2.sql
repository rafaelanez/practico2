

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Archivar`(IN `idParam` INT, IN `estadoParam` BOOLEAN)
    NO SQL
UPDATE tblnota
SET estado = estadoParam
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Delete`(IN `idParam` INT)
    NO SQL
DELETE FROM tblnota
WHERE id = idParam$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_Insert`(IN `tituloParam` TEXT, IN `notaParam` TEXT, IN `idCategoriaParam` INT)
    NO SQL
BEGIN
	insert into tblnota (titulo, nota, idCategoria)
	values(tituloParam, notaParam, idCategoriaParam);
	SELECT LAST_INSERT_ID() AS lastId;
END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tblNota_SelectByEstado`(IN `estadoParam` BOOLEAN)
    NO SQL
SELECT id,
	   fecha,
       titulo,
       nota,
       estado,
       idCategoria
FROM tblnota
WHERE estado = estadoParam$$

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblcategoria`
--

INSERT INTO `tblcategoria` (`id`, `nombre`, `color`) VALUES
(1, 'default', 'grey'),
(2, 'rojo', 'deep-orange'),
(3, 'naranja', 'orange'),
(4, 'amarillo', 'yellow'),
(5, 'gris', 'blue-grey'),
(6, 'azul', 'light-blue'),
(7, 'turquesa', 'teal'),
(8, 'verde', 'lime');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblnota`
--

INSERT INTO `tblnota` (`id`, `fecha`, `titulo`, `nota`, `estado`, `idCategoria`) VALUES
(1, '2015-09-27 18:41:57', '', '', 0, 1),
(2, '2015-09-27 18:42:24', 'Esta nota es es especial', 'Esta nota es especial porque es la primera que pongo. Adios.', 0, 1),
(3, '2015-09-27 18:42:34', 'Esta nota es es especial', 'Esta nota es especial porque es la primera que pongo. Adios.', 0, 3),
(4, '2015-09-27 18:45:39', 'Nota', 'Vamos a casa.<br />A caaaasa.', 0, 1),
(5, '2015-09-27 19:40:11', 'Agregando una nueva nota', 'Mostrar nota', 0, 3),
(6, '2015-09-27 20:51:45', 'd', 'f', 1, 1),
(7, '2015-09-27 20:54:10', 'otra nota mÃ¡s', 'envÃ­o otra nota', 0, 1),
(8, '2015-09-27 20:56:44', 'f', 'd', 1, 1),
(9, '2015-09-27 21:01:18', 'fsdafsd', 'fasdfasdfsd', 1, 1),
(10, '2015-09-27 21:03:23', 'dsafdas', 'fasdfas', 1, 1),
(11, '2015-09-27 21:04:38', 'sdfasdfsdfsdf', 'sdfsdfasd', 0, 1),
(12, '2015-09-27 21:05:48', 'fa', 'dafsd', 0, 1),
(13, '2015-09-27 21:10:23', 'sdfasdf', 'sdfasdfsdfas', 0, 6),
(14, '2015-09-27 21:20:07', 'Goooooooooooooooool de Bloooooming', 'QuÃ© huevada!', 0, 1),
(15, '2015-09-27 21:25:51', 'QuÃ© dejgracia choc', 'Pierde oriente', 0, 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `tblnota`
--
ALTER TABLE `tblnota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
