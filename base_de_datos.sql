-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2021 a las 05:57:10
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `diestro_chat`
--
CREATE DATABASE IF NOT EXISTS `diestro_chat` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `diestro_chat`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `abrirConversacion` (IN `usuEnvia` VARCHAR(20) CHARSET utf8, IN `usuRecibe` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Muestra conversación entre dos usuarios.'
SELECT mensaje, fecha_envio, usuario_envia AS ue FROM mensajes WHERE usuario_envia = usuEnvia AND usuario_recibe = usuRecibe

UNION

SELECT mensaje, fecha_envio, usuario_envia AS ur FROM mensajes WHERE usuario_envia = usuRecibe AND usuario_recibe = usuEnvia

ORDER BY fecha_envio ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarUsuarios` (IN `usu` VARCHAR(22) CHARSET utf8)  READS SQL DATA
    COMMENT 'Busca usuarios con nombre similar al ingresado en consulta.'
SELECT usuario FROM usuarios WHERE usuario LIKE usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiarPassword` (IN `cla` VARCHAR(255) CHARSET utf8, IN `usu` VARCHAR(20) CHARSET utf8, IN `cod` VARCHAR(43) CHARSET utf8, IN `ema` VARCHAR(80) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'Actualiza password comparando código.'
UPDATE usuarios SET password = cla, estado = 1 WHERE usuario = usu AND codigo = cod AND email = ema$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `consultarEstado` (IN `usu` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Retorna estado según usuario.'
SELECT estado FROM usuarios WHERE usuario = usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crearUsuario` (IN `ema` VARCHAR(80) CHARSET utf8, IN `usu` VARCHAR(20) CHARSET utf8, IN `pass` VARCHAR(255) CHARSET utf8, IN `est` TINYINT(1) UNSIGNED, IN `cod` VARCHAR(43) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'Carga datos de usuario nuevo a la base de datos.'
INSERT INTO usuarios(email,usuario,password,estado,codigo) VALUES(ema,usu,pass,est,cod)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `emailExiste` (IN `ema` VARCHAR(80) CHARSET utf8)  READS SQL DATA
    COMMENT 'Verifica si el e-mail está en la base de datos.'
SELECT email FROM usuarios WHERE email = ema$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `enviarMensaje` (IN `usuarioEnvia` VARCHAR(20) CHARSET utf8, IN `msj` VARCHAR(500) CHARSET utf8, IN `usuarioRecibe` VARCHAR(20) CHARSET utf8)  BEGIN

DECLARE idEnvia INT;
DECLARE idRecibe INT;
SET idEnvia = (SELECT id FROM usuarios WHERE usuario = usuarioEnvia);
SET idRecibe = (SELECT id FROM usuarios WHERE usuario = usuarioRecibe);

INSERT INTO mensajes(id_envia,id_recibe,mensaje,usuario_envia,usuario_recibe) VALUES(idEnvia,idRecibe,msj,usuarioEnvia,usuarioRecibe);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `idPorUsuario` (IN `usu` VARCHAR(20) CHARSET utf8)  NO SQL
    COMMENT 'Devuelve id según usuario.'
SELECT id FROM usuarios WHERE usuario = usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `iniciarSesion` (IN `usu` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Retorna password.'
SELECT password FROM usuarios WHERE usuario = usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrarConversaciones` (IN `usu` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Muestra usuarios con los que hay conversaciones.'
SELECT DISTINCT usuario_recibe FROM mensajes WHERE usuario_envia = usu
UNION
SELECT DISTINCT usuario_envia FROM mensajes WHERE usuario_recibe = usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrarImagenPerfil` (IN `usu` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Muestra imagen de perfil.'
BEGIN

DECLARE idUsuario INT;
SET idUsuario = (SELECT id FROM usuarios WHERE usuario = usu);

SELECT imagen_perfil,fecha_subida FROM imagenes WHERE fk_id_usuario = idUsuario
ORDER BY fecha_subida DESC;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrarInformacion` (IN `usu` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Retorna la información accesible del usuario.'
SELECT usuario, email FROM usuarios WHERE usuario = usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `olvidoPassword` (IN `cod` VARCHAR(43) CHARSET utf8, IN `ema` VARCHAR(80) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'Cambia el estado de quien olvidó password.'
UPDATE usuarios SET estado = 3, codigo = cod WHERE email = ema$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `subirImagenPerfil` (IN `usu` VARCHAR(20) CHARSET utf8, IN `img` VARCHAR(255) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'Guarda imagen de perfil.'
BEGIN

DECLARE idUsuario INT;
SET idUsuario = (SELECT id FROM usuarios WHERE usuario = usu);

INSERT INTO imagenes(imagen_perfil,fk_id_usuario) VALUES(img,idUsuario);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `usuarioExiste` (IN `usu` VARCHAR(20) CHARSET utf8)  READS SQL DATA
    COMMENT 'Consulta si nombre de usuario existe.'
SELECT usuario FROM usuarios WHERE usuario = usu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `validarCodigo` (IN `cod` VARCHAR(43) CHARSET utf8)  READS SQL DATA
    COMMENT 'Coteja codigo enviado con el de la base de datos.'
SELECT codigo FROM usuarios WHERE codigo = cod$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `validarEmail` (IN `cod` VARCHAR(43) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'Valida correo electronico cambiando estado de usuario.'
UPDATE usuarios SET estado = 1 WHERE codigo = cod$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id_imagen` int(10) UNSIGNED NOT NULL,
  `imagen_perfil` varchar(255) DEFAULT NULL,
  `fk_id_usuario` int(10) UNSIGNED NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(10) UNSIGNED NOT NULL,
  `id_envia` int(10) UNSIGNED NOT NULL,
  `id_recibe` int(10) UNSIGNED NOT NULL,
  `usuario_envia` varchar(20) NOT NULL,
  `usuario_recibe` varchar(20) NOT NULL,
  `mensaje` varchar(500) NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(80) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) UNSIGNED NOT NULL,
  `codigo` varchar(43) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_mensajes` (`id_envia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id_imagen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `fk_mensajes` FOREIGN KEY (`id_envia`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
