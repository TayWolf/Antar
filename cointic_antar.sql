-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-07-2019 a las 12:19:32
-- Versión del servidor: 5.6.41-84.1
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
-- Base de datos: `constj7s_sistema_contratos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `idArea` int(11) NOT NULL,
  `nombreArea` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`idArea`, `nombreArea`) VALUES
(1, 'RECURSOS HUMANOS'),
(5, 'GERENCIA ADMINISTRATIVA'),
(6, 'COORDINACION JURIDICO'),
(8, 'GERENCIA TECNICA'),
(9, 'DIRECCION'),
(10, 'GERENCIA PROYECTOS'),
(11, 'GERENCIA DE PLANEACION Y GESTION'),
(13, 'GERENCIA TECNICA GAS NATURAL'),
(14, 'GERENCIA TECNICA CALIDAD PETROLIFEROS Y PETROQUIMICOS'),
(15, 'GERENCIA TECNICA MEDICION'),
(16, 'TI'),
(17, 'PRESIDENCIA'),
(18, 'CONTABILIDAD'),
(19, 'TESORERIA'),
(20, 'GERENCIA DE ALMACENAMIENTO Y TRANSPORTE DE PETROLÍFEROS'),
(21, 'SGI DEISA'),
(23, 'GERENCIA DE CONSTRUCCIÓN');

--
-- Disparadores `area`
--
DELIMITER $$
CREATE TRIGGER `area_delete` AFTER DELETE ON `area` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE modulo INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET modulo=2;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Área ',OLD.idArea,' - ',OLD.nombreArea), OLD.nombreArea, '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `area_insert` AFTER INSERT ON `area` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=2;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues) VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Área ',NEW.idArea,' - ',NEW.nombreArea), '', CONCAT('Nueva área "', NEW.nombreArea,'"'));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `area_update` AFTER UPDATE ON `area` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=2;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  IF(OLD.nombreArea<>NEW.nombreArea)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Área ',OLD.idArea,' - ',OLD.nombreArea),'Nombre del área', OLD.nombreArea, NEW.nombreArea);
  END IF;
  IF(OLD.idArea<>NEW.idArea) THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Área ',OLD.idArea,' - ',OLD.nombreArea),'ID del área', OLD.idArea, NEW.idArea);
  END IF ;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Bitacora`
--

CREATE TABLE `Bitacora` (
  `idBitacora` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaAccion` date DEFAULT NULL,
  `horaAccion` time DEFAULT NULL,
  `idModulo` int(11) DEFAULT NULL,
  `accion` varchar(20) DEFAULT NULL,
  `texto` text,
  `columna` varchar(50) DEFAULT NULL,
  `antes` varchar(300) DEFAULT NULL,
  `despues` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatalogoFianzas`
--

CREATE TABLE `CatalogoFianzas` (
  `idCatalogoFianza` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `CatalogoFianzas`
--

INSERT INTO `CatalogoFianzas` (`idCatalogoFianza`, `nombre`, `orden`) VALUES
(1, 'Fianzas de anticipo', 0),
(2, 'Fianzas de vicios ocultos', 1),
(3, 'Fianzas de buena calidad', 2),
(5, 'Fianzas de cumplimiento', 4),
(7, 'Fianza de garantía', 5),
(8, 'Póliza de  seguro', 6);

--
-- Disparadores `CatalogoFianzas`
--
DELIMITER $$
CREATE TRIGGER `CatalogoFianzas_delete` AFTER DELETE ON `CatalogoFianzas` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=12;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Fianza o garantía ',OLD.idCatalogoFianza,' - ',OLD.nombre),CONCAT('Fianza o garantía ',OLD.idCatalogoFianza,' - ',OLD.nombre) ,'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `CatalogoFianzas_insert` AFTER INSERT ON `CatalogoFianzas` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=12;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Fianza o garantía ',NEW.idCatalogoFianza,' - ',NEW.nombre), '', CONCAT('Fianza o garantía ',NEW.idCatalogoFianza,' - ',NEW.nombre));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `CatalogoFianzas_update` AFTER UPDATE ON `CatalogoFianzas` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=12;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.nombre!=OLD.nombre)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Fianza o garantía ',OLD.idCatalogoFianza,' - ',OLD.nombre),'Nombre',OLD.nombre, NEW.nombre);
  END IF;
  IF(NEW.orden!=OLD.orden)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Fianza o garantía ',OLD.idCatalogoFianza,' - ',OLD.orden),'Orden',OLD.orden, NEW.orden);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ClienteDocumento`
--

CREATE TABLE `ClienteDocumento` (
  `idClienteDocumento` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `nombreDocumento` varchar(200) DEFAULT NULL,
  `documento` varchar(100) DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ClienteDocumento`
--

INSERT INTO `ClienteDocumento` (`idClienteDocumento`, `idCliente`, `nombreDocumento`, `documento`, `observaciones`) VALUES
(14, 6, 'Acta constitutiva', '/0ae8f657a989cb66a51939ac8314c25f.png', 'El acta de la empresa'),
(15, 7, 'Acta constitutiva', '/643dda919a697bd34edcc188af844b28.pdf', '');

--
-- Disparadores `ClienteDocumento`
--
DELIMITER $$
CREATE TRIGGER `ClienteDocumento_delete` AFTER DELETE ON `ClienteDocumento` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreCliente VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=23;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT Empresa.nombre FROM Empresa WHERE Empresa.idEmpresa=OLD.idCliente INTO nombreCliente;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente ó proveedor ',OLD.idCliente,' - ',nombreCliente,' / Documento ',OLD.idClienteDocumento,' - ',OLD.nombreDocumento),CONCAT('Documento ',OLD.idClienteDocumento,' - ',OLD.nombreDocumento),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ClienteDocumento_insert` AFTER INSERT ON `ClienteDocumento` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreCliente VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=23;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT Empresa.nombre FROM Empresa WHERE Empresa.idEmpresa=NEW.idCliente INTO nombreCliente;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente ó proveedor ',NEW.idCliente,' - ',nombreCliente,' / Documento ',NEW.idClienteDocumento,' - ',NEW.nombreDocumento), '', CONCAT('Documento ',NEW.idClienteDocumento,' - ',NEW.nombreDocumento));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ClienteDocumento_update` AFTER UPDATE ON `ClienteDocumento` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreCliente VARCHAR(50);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=23;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT Empresa.nombre FROM Empresa WHERE Empresa.idEmpresa=OLD.idCliente INTO nombreCliente;
  
  IF(NEW.nombreDocumento!=OLD.nombreDocumento)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente ó proveedor ',OLD.idCliente,' - ',nombreCliente,' / Documento ',OLD.idClienteDocumento,' - ',OLD.nombreDocumento),'Nombre del documento',OLD.nombreDocumento, NEW.nombreDocumento);
  END IF;  
  IF(NEW.observaciones!=OLD.observaciones)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente ó proveedor ',OLD.idCliente,' - ',nombreCliente,' / Documento ',OLD.idClienteDocumento,' - ',OLD.nombreDocumento),'Observaciones del documento',OLD.observaciones, NEW.observaciones);
  END IF;  
  IF(NEW.documento!=OLD.documento)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente ó proveedor ',OLD.idCliente,' - ',nombreCliente,' / Documento ',OLD.idClienteDocumento,' - ',OLD.nombreDocumento),'Archivo',OLD.documento, NEW.documento);
  END IF;

end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contrato`
--

CREATE TABLE `Contrato` (
  `idContrato` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Contrato`
--

INSERT INTO `Contrato` (`idContrato`, `nombre`) VALUES
(16, 'Contratos interno'),
(17, 'Contrato clientes /proveedor'),
(18, 'Contrato laboral'),
(19, 'Independientes'),
(23, 'ACTAS DE ASAMBLEA'),
(24, 'pagos provisionales');

--
-- Disparadores `Contrato`
--
DELIMITER $$
CREATE TRIGGER `Contrato_delete` AFTER DELETE ON `Contrato` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=3;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',OLD.nombre),CONCAT('Documento ',OLD.idContrato,' - ',OLD.nombre),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Contrato_insert` AFTER INSERT ON `Contrato` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=3;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',NEW.idContrato,' - ',NEW.nombre), '', CONCAT('Nuevo documento ',NEW.idContrato,' - ',NEW.nombre));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Contrato_update` AFTER UPDATE ON `Contrato` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=3;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.nombre!=OLD.nombre)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',OLD.nombre),'Nombre', OLD.nombre, NEW.nombre);
  END IF;
  IF(NEW.idContrato<>OLD.idContrato)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',OLD.nombre),'ID del documento', OLD.idContrato, NEW.idContrato);
  END IF;

end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratoProyecto`
--

CREATE TABLE `contratoProyecto` (
  `idContratoProyecto` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idTipoContrato` int(11) NOT NULL,
  `contratoMarco` int(11) DEFAULT NULL,
  `objetoContrato` varchar(250) DEFAULT NULL,
  `idEmpresa` int(11) NOT NULL,
  `fechaSolicitud` date NOT NULL,
  `fechaFirma` date NOT NULL,
  `montoContrato` varchar(250) NOT NULL,
  `vigencia` date DEFAULT NULL,
  `observacion` text,
  `plazoEjecucion` varchar(250) DEFAULT NULL,
  `programaEntrega` varchar(250) DEFAULT NULL,
  `lugarEntrega` varchar(300) DEFAULT NULL,
  `representanteObra` varchar(250) DEFAULT NULL,
  `testigos` text,
  `garantia` date DEFAULT NULL,
  `correoContacto` varchar(100) DEFAULT NULL,
  `contactoInterno` varchar(100) DEFAULT NULL,
  `correoInterno` varchar(100) DEFAULT NULL,
  `nota` text,
  `envioCorreo` int(11) NOT NULL,
  `diasAviso` int(11) DEFAULT NULL,
  `fechaNotificado` date DEFAULT NULL,
  `idSolicitante` int(11) NOT NULL,
  `nomenclatura` varchar(150) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `statusFinalizado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contratoProyecto`
--

INSERT INTO `contratoProyecto` (`idContratoProyecto`, `idProyecto`, `idTipoContrato`, `contratoMarco`, `objetoContrato`, `idEmpresa`, `fechaSolicitud`, `fechaFirma`, `montoContrato`, `vigencia`, `observacion`, `plazoEjecucion`, `programaEntrega`, `lugarEntrega`, `representanteObra`, `testigos`, `garantia`, `correoContacto`, `contactoInterno`, `correoInterno`, `nota`, `envioCorreo`, `diasAviso`, `fechaNotificado`, `idSolicitante`, `nomenclatura`, `status`, `statusFinalizado`) VALUES
(5, 5, 2, 0, 'Ninguno', 6, '2019-02-08', '0000-00-00', '123', '2019-01-08', 'asdasd', 'asdasd', 'thumb-1920-84316.jpg', 'asdasd', 'asdasd', 'asdasdasd', '2017-12-06', 'asdas@gmail.com', '', '', 'hola', 1, 0, NULL, 1, 'AERORE-MEX', 7, 0),
(6, 8, 3, 1, 'Remodelación del aeropuerto', 6, '2019-02-12', '0000-00-00', '500000', '2019-07-17', 'kjdlsakjdlsakjdlsakjdlksajdlksajd', 'sasasas', 'null', 'asSAssa', 'Pppppppppppp', 'sasassasasssaas', '2019-12-31', 'pppp@ppp.pm', '', '', 'jhhkhkjhkhkjhkjh', 0, 1, '2019-07-16', 16, 'f-j-o2', 4, 0),
(8, 11, 5, 0, 'Objeto del contrato', 7, '2019-06-20', '0000-00-00', '150000', '2019-04-16', '', 'Del 18 de junio al 19 de junio de 2019', 'null', 'Tuxpan', 'Fernando Reyes', 'Francisco Pacheco\r\nAlan Omar', '2019-06-21', 'francisco_pacheco_r@hotmail.com', '', '', 'El contacto interno es correo@mail.com', 1, 0, NULL, 1, 'ANT-TUX-0818/062', 11, 0),
(9, 11, 6, 0, 'asdasdasdasd', 7, '2019-07-16', '0000-00-00', '123123123', '2021-11-30', 'asdasdasdasdasdasdasd', 'asdasdasdasdasdasdasd', '/409cf8cedeb850e44e6ffa10e14cdd66.pdf', 'alla', 'holaasdasd', 'asdasdasdlaksnda', '2019-07-23', 'dotjar@outlook.com', 'NUEVO@NUEVO.com', 'NUEVO@NUsadEVO.com', 'hola', 1, 30, '0000-00-00', 33, 'AUX-ASD', 8, 1);

--
-- Disparadores `contratoProyecto`
--
DELIMITER $$
CREATE TRIGGER `contratoProyecto_delete` AFTER DELETE ON `contratoProyecto` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=7;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT proyecto.nombreProyecto FROM proyecto WHERE proyecto.idProyecto=OLD.idProyecto INTO nombreProyecto;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',OLD.idProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',OLD.nomenclatura),'', CONCAT('Contrato de proyecto ',OLD.idContratoProyecto,' - ',OLD.nomenclatura));
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `contratoProyecto_insert` AFTER INSERT ON `contratoProyecto` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreProyecto VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=7;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT proyecto.nombreProyecto FROM proyecto WHERE proyecto.idProyecto=NEW.idProyecto INTO nombreProyecto;

  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',NEW.idProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',NEW.idContratoProyecto,' - ',NEW.nomenclatura),'', CONCAT('Contrato de proyecto ',NEW.idContratoProyecto,' - ',NEW.nomenclatura));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `contratoProyecto_update` AFTER UPDATE ON `contratoProyecto` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(300);
    DECLARE valorAnterior VARCHAR(300);
    DECLARE valorNuevo VARCHAR(300);
    SET query='Actualización';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=7;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT proyecto.nombreProyecto FROM proyecto WHERE proyecto.idProyecto=OLD.idProyecto INTO nombreProyecto;
    IF (NEW.nomenclatura <> OLD.nomenclatura)
    THEN
      SET valorNuevo = NEW.nomenclatura;
      SET valorAnterior = OLD.nomenclatura;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Nomenclatura', valorAnterior, valorNuevo);
    END IF;
    IF(NEW.idTipoContrato<>OLD.idTipoContrato) THEN
      SELECT tipoContrato.nombreTipo FROM tipoContrato WHERE tipoContrato.idTipoC=OLD.idTipoContrato INTO valorAnterior;
      SELECT tipoContrato.nombreTipo FROM tipoContrato WHERE tipoContrato.idTipoC=NEW.idTipoContrato INTO valorNuevo;
      INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',OLD.idProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',OLD.nomenclatura),'Tipo de contrato',valorAnterior, valorNuevo);
    END IF;
    IF(NEW.contratoMarco<>OLD.contratoMarco) THEN
      IF(NEW.contratoMarco=1)THEN
        SET valorNuevo='Si';
        SET valorAnterior='No';
      ELSEIF(NEW.contratoMarco<>1)THEN
        SET valorNuevo='No';
        SET valorAnterior='Si';
      END IF;
      INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',OLD.idProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',OLD.nomenclatura),'Contrato marco',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.objetoContrato <> OLD.objetoContrato)
    THEN
      IF (OLD.objetoContrato IS NULL)
      THEN
        SET valorAnterior = '';
      ELSE SET valorAnterior= OLD.objetoContrato;
      END IF;
      IF (NEW.objetoContrato IS NULL)
      THEN
        SET valorNuevo= '';
      ELSE SET valorNuevo= NEW.objetoContrato;
      END IF;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Objeto del contrato', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.idEmpresa <> OLD.idEmpresa)
    THEN
      SELECT Empresa.nombre FROM Empresa WHERE Empresa.idEmpresa=OLD.idEmpresa INTO valorAnterior;
      SELECT Empresa.nombre FROM Empresa WHERE Empresa.idEmpresa=NEW.idEmpresa INTO valorNuevo;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Cliente o proveedor', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.fechaSolicitud <> OLD.fechaSolicitud)
    THEN
      SET valorAnterior = OLD.fechaSolicitud;
      SET valorNuevo = NEW.fechaSolicitud;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Fecha de solicitud', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.fechaFirma <> OLD.fechaFirma)
    THEN
      SET valorAnterior = OLD.fechaFirma;
      SET valorNuevo = NEW.fechaFirma;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Fecha de firma', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.montoContrato <> OLD.montoContrato)
    THEN
      SET valorAnterior = OLD.montoContrato;
      SET valorNuevo = NEW.montoContrato;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Monto del contrato', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.vigencia <> OLD.vigencia)
    THEN
      SET valorAnterior = OLD.vigencia;
      SET valorNuevo = NEW.vigencia;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Vigencia', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.observacion <> OLD.observacion)
    THEN
      SET valorAnterior = OLD.observacion;
      SET valorNuevo = NEW.observacion;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Observación', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.plazoEjecucion <> OLD.plazoEjecucion)
    THEN
      SET valorAnterior = OLD.plazoEjecucion;
      SET valorNuevo = NEW.plazoEjecucion;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Período de ejecución', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.programaEntrega <> OLD.programaEntrega)
    THEN
      if((OLD.programaEntrega IS NULL) OR (OLD.programaEntrega='null')) THEN SET valorAnterior=''; ELSE SET valorAnterior=OLD.programaEntrega; END IF;

      SET valorNuevo = NEW.programaEntrega;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Programa de entrega', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.lugarEntrega <> OLD.lugarEntrega)
    THEN
      SET valorNuevo = NEW.lugarEntrega;
      SET valorAnterior = OLD.lugarEntrega;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Lugar de entrega', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.representanteObra <> OLD.representanteObra)
    THEN
      SET valorNuevo = NEW.representanteObra;
      SET valorAnterior = OLD.representanteObra;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Representante de obra', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.testigos <> OLD.testigos)
    THEN
      SET valorNuevo = NEW.testigos;
      SET valorAnterior = OLD.testigos;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Testigos', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.garantia <> OLD.garantia)
    THEN
      SET valorNuevo = NEW.garantia;
      SET valorAnterior = OLD.garantia;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Garantía', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.correoContacto <> OLD.correoContacto)
    THEN
      SET valorNuevo = NEW.correoContacto;
      SET valorAnterior = OLD.correoContacto;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Correo del cliente', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.contactoInterno <> OLD.contactoInterno)
    THEN
      SET valorNuevo = NEW.contactoInterno;
      SET valorAnterior = OLD.contactoInterno;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Contacto interno', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.correoInterno <> OLD.correoInterno)
    THEN
      SET valorNuevo = NEW.correoInterno;
      SET valorAnterior = OLD.correoInterno;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Correo interno', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.nota <> OLD.nota)
    THEN
      SET valorNuevo = NEW.nota;
      SET valorAnterior = OLD.nota;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Nota', valorAnterior, valorNuevo);
    END IF;
    
    IF (NEW.status <> OLD.status)
    THEN
      SELECT StatusContratos.etiqueta FROM StatusContratos WHERE StatusContratos.idStatusContrato=OLD.status INTO valorAnterior;
      SELECT StatusContratos.etiqueta FROM StatusContratos WHERE StatusContratos.idStatusContrato=NEW.status INTO valorNuevo;

      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Status del contrato', valorAnterior, valorNuevo);
    END IF;
    IF (NEW.statusFinalizado <> OLD.statusFinalizado)
    THEN
      IF(NEW.statusFinalizado=1) THEN
        SET valorNuevo='Finalizado';
        SET valorAnterior='No finalizado';
      ELSE
        SET valorNuevo='No finalizado';
        SET valorAnterior='Finalizado';
      end if;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query,
              CONCAT('Proyecto ', OLD.idProyecto, ' - ', nombreProyecto, ' / Contrato de proyecto ',
                     OLD.idContratoProyecto, ' - ', OLD.nomenclatura), 'Status del contrato', valorAnterior, valorNuevo);
    END IF;


  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DocumentoEmpresaInterna`
--

CREATE TABLE `DocumentoEmpresaInterna` (
  `idDocumentoEmpresa` int(11) NOT NULL,
  `idEmpresaInterna` int(11) NOT NULL,
  `nombreDocumento` varchar(200) NOT NULL,
  `documento` varchar(150) NOT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `DocumentoEmpresaInterna`
--

INSERT INTO `DocumentoEmpresaInterna` (`idDocumentoEmpresa`, `idEmpresaInterna`, `nombreDocumento`, `documento`, `observaciones`) VALUES
(10, 2, 'Acta 7400 fecha 22-12-2017', '/cb8bf49ee17795dd43aa9b6725d3a085.pdf', '');

--
-- Disparadores `DocumentoEmpresaInterna`
--
DELIMITER $$
CREATE TRIGGER `DocumentoEmpresaInterna_delete` AFTER DELETE ON `DocumentoEmpresaInterna` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreEmpresaInterna varchar(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=15;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=OLD.idEmpresaInterna INTO nombreEmpresaInterna;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',nombreEmpresaInterna,' / Documento ',OLD.idDocumentoEmpresa,' - ',OLD.nombreDocumento),CONCAT('Documento ',OLD.idDocumentoEmpresa,' - ',OLD.nombreDocumento), '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `DocumentoEmpresaInterna_insert` AFTER INSERT ON `DocumentoEmpresaInterna` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreEmpresaInterna varchar(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=15;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=NEW.idEmpresaInterna INTO nombreEmpresaInterna;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',NEW.idEmpresaInterna,' - ',nombreEmpresaInterna,' / Documento ',NEW.idDocumentoEmpresa,' - ',NEW.nombreDocumento), '', CONCAT('Documento ',NEW.idDocumentoEmpresa,' - ',NEW.nombreDocumento));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `DocumentoEmpresaInterna_update` AFTER UPDATE ON `DocumentoEmpresaInterna` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreEmpresaInterna varchar(50);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=15;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=OLD.idEmpresaInterna INTO nombreEmpresaInterna;
  IF(NEW.nombreDocumento!=OLD.nombreDocumento)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',nombreEmpresaInterna,' / Documento ',OLD.idDocumentoEmpresa,' - ',OLD.nombreDocumento),'Nombre del documento',OLD.nombreDocumento, NEW.nombreDocumento);
  END IF;
  IF(NEW.observaciones!=OLD.observaciones)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',nombreEmpresaInterna,' / Documento ',OLD.idDocumentoEmpresa,' - ',OLD.nombreDocumento),'Observaciones del documento',OLD.observaciones, NEW.observaciones);
  END IF;
  IF(NEW.documento!=OLD.documento)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',nombreEmpresaInterna,' / Documento ',OLD.idDocumentoEmpresa,' - ',OLD.nombreDocumento),'Documento',OLD.documento, NEW.documento);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DocumentosUsuario`
--

CREATE TABLE `DocumentosUsuario` (
  `idDocumentoUser` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `nombreDocumento` varchar(200) NOT NULL,
  `documento` varchar(150) NOT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `DocumentosUsuario`
--
DELIMITER $$
CREATE TRIGGER `DocumentosUsuario_delete` AFTER DELETE ON `DocumentosUsuario` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nickUsuario VARCHAR(40);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=25;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT Usuarios.nickName FROM Usuarios WHERE Usuarios.idUser=OLD.idUser INTO nickUsuario;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',OLD.idUser,' - ',nickUsuario,' / Expediente de usuario ',OLD.idDocumentoUser,' - ',OLD.nombreDocumento),CONCAT('Expediente de usuario ',OLD.idDocumentoUser,' - ',OLD.nombreDocumento),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `DocumentosUsuario_insert` AFTER INSERT ON `DocumentosUsuario` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nickUsuario VARCHAR(40);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=25;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT Usuarios.nickName FROM Usuarios WHERE Usuarios.idUser=NEW.idUser INTO nickUsuario;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',NEW.idUser,' - ',nickUsuario,' / Expediente de usuario ',NEW.idDocumentoUser,' - ',NEW.nombreDocumento), '', CONCAT('Expediente de usuario ',NEW.idDocumentoUser,' - ',NEW.nombreDocumento));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `DocumentosUsuario_update` AFTER UPDATE ON `DocumentosUsuario` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nickUsuario VARCHAR(40);
    SET query='Actualización';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=25;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT Usuarios.nickName FROM Usuarios WHERE Usuarios.idUser=OLD.idUser INTO nickUsuario;

    IF (NEW.nombreDocumento<> OLD.nombreDocumento)
    THEN
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',OLD.idUser,' - ',nickUsuario,' / Expediente de usuario ',OLD.idDocumentoUser,' - ',OLD.nombreDocumento),'Nombre del documento',OLD.nombreDocumento,NEW.nombreDocumento);
    END IF;
    IF (NEW.observaciones<> OLD.observaciones)
    THEN
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',OLD.idUser,' - ',nickUsuario,' / Expediente de usuario ',OLD.idDocumentoUser,' - ',OLD.nombreDocumento),'Observaciones del documento',OLD.observaciones,NEW.observaciones);
    END IF;
    IF (NEW.documento<> OLD.documento)
    THEN
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',OLD.idUser,' - ',nickUsuario,' / Expediente de usuario ',OLD.idDocumentoUser,' - ',OLD.nombreDocumento),'Documento',OLD.documento,NEW.documento);
    END IF;

  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empresa`
--

CREATE TABLE `Empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `RFC` varchar(20) NOT NULL,
  `razon_social` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Empresa`
--

INSERT INTO `Empresa` (`idEmpresa`, `nombre`, `RFC`, `razon_social`) VALUES
(6, 'COMUNICACIÓN, DISEÑO Y RECUBRIMIENTO ARQUITECTÓNICO, S.A. DE C.V.', 'CDR0512142D6', 'COMUNICACIÓN, DISEÑO Y RECUBRIMIENTO ARQUITECTÓNICO, S.A. DE C.V.'),
(7, 'Empresas marítimas HB', 'EMPRESASMARITIMASHB', 'Empresas marítimas HB');

--
-- Disparadores `Empresa`
--
DELIMITER $$
CREATE TRIGGER `Empresa_delete` AFTER DELETE ON `Empresa` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=11;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente / Proveedor ',OLD.idEmpresa,' - ',OLD.nombre), CONCAT('Cliente / Proveedor ',OLD.idEmpresa,' - ',OLD.nombre), '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Empresa_insert` AFTER INSERT ON `Empresa` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=11;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente / Proveedor ',NEW.idEmpresa,' - ',NEW.nombre), '', CONCAT('Clientes / Proveedores ',NEW.idEmpresa,' - ',NEW.nombre));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Empresa_update` AFTER UPDATE ON `Empresa` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=11;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.nombre!=OLD.nombre)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente / Proveedor ',OLD.idEmpresa,' - ',OLD.nombre),'Nombre', OLD.nombre, NEW.nombre);
  END IF;
  IF(NEW.RFC<>OLD.RFC)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente / Proveedor ',OLD.idEmpresa,' - ',OLD.nombre),'RFC', OLD.RFC, NEW.RFC);
  END IF;
  IF(NEW.razon_social<>OLD.razon_social)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Cliente / Proveedor ',OLD.idEmpresa,' - ',OLD.nombre),'Razón social', OLD.razon_social, NEW.razon_social);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresainterna`
--

CREATE TABLE `empresainterna` (
  `idEmpresaInterna` int(11) NOT NULL,
  `nombreEmpresa` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresainterna`
--

INSERT INTO `empresainterna` (`idEmpresaInterna`, `nombreEmpresa`) VALUES
(2, 'DEISA CONSULTING SA DE CV'),
(3, 'CONSTRUCTORA ANTAR SA DE CV'),
(5, 'INMOBILIARIA SUR CENTRO SAPI DE CV'),
(7, 'GULF ENERGY DE MEXICO '),
(10, 'OBRAS Y PROYECTOS MEXIQUENSES SA DE CV'),
(11, 'INMOBILIARIA SCHAC SA DE CV'),
(12, 'ISADE INMOBILIARIA SAPI DE CV'),
(13, 'SERVICIOS INMOBILIARIOS SIHO SA DE CV'),
(14, 'DESARROLLADORA DE NEGOCIOS ANTAR SA DE CV');

--
-- Disparadores `empresainterna`
--
DELIMITER $$
CREATE TRIGGER `empresainterna_delete` AFTER DELETE ON `empresainterna` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=14;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',OLD.nombreEmpresa),CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',OLD.nombreEmpresa) ,'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `empresainterna_insert` AFTER INSERT ON `empresainterna` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=14;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',NEW.idEmpresaInterna,' - ',NEW.nombreEmpresa), '', CONCAT('Empresa interna ',NEW.idEmpresaInterna,' - ',NEW.nombreEmpresa));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `empresainterna_update` AFTER UPDATE ON `empresainterna` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=14;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.nombreEmpresa!=OLD.nombreEmpresa)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Empresa interna ',OLD.idEmpresaInterna,' - ',OLD.nombreEmpresa),'Nombre',OLD.nombreEmpresa, NEW.nombreEmpresa);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FianzaDocumento`
--

CREATE TABLE `FianzaDocumento` (
  `idFianzaDocumento` int(11) NOT NULL,
  `idFianza` int(11) DEFAULT NULL,
  `nombreDocumento` varchar(150) NOT NULL,
  `documento` varchar(150) DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que almacena los documentos de una fianza';

--
-- Volcado de datos para la tabla `FianzaDocumento`
--

INSERT INTO `FianzaDocumento` (`idFianzaDocumento`, `idFianza`, `nombreDocumento`, `documento`, `observaciones`) VALUES
(3, 14, '', '/8c2cf095c68c34e437751f9e492ea039.pdf', 'rtyiuoj');

--
-- Disparadores `FianzaDocumento`
--
DELIMITER $$
CREATE TRIGGER `FianzaDocumento_delete` AFTER DELETE ON `FianzaDocumento` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    DECLARE idNewProyecto VARCHAR(50);
    DECLARE nomenclaturaContrato VARCHAR(50);
    DECLARE idNewContratoProyecto VARCHAR(50);
    DECLARE nombreFianza VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=9;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT contratoProyecto.nomenclatura FROM contratoProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=OLD.idFianza INTO nomenclaturaContrato;
    SELECT contratoProyecto.idContratoProyecto FROM contratoProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=OLD.idFianza INTO idNewContratoProyecto;
    SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=OLD.idFianza INTO nombreProyecto;
    SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=OLD.idFianza INTO idNewProyecto;
    SELECT CatalogoFianzas.nombre FROM CatalogoFianzas JOIN Fianzas ON CatalogoFianzas.idCatalogoFianza = Fianzas.idCatalogoFianza WHERE Fianzas.idFianza=OLD.idFianza INTO nombreFianza;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',idNewContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza,' / Documento ',OLD.idFianzaDocumento,' - ',OLD.nombreDocumento),CONCAT('Documento ',OLD.idFianzaDocumento,' - ',OLD.nombreDocumento),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `FianzaDocumento_insert` AFTER INSERT ON `FianzaDocumento` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreProyecto VARCHAR(50);
  DECLARE idNewProyecto VARCHAR(50);
  DECLARE nomenclaturaContrato VARCHAR(50);
  DECLARE idNewContratoProyecto VARCHAR(50);
  DECLARE nombreFianza VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=9;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT contratoProyecto.nomenclatura FROM contratoProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO nomenclaturaContrato;
  SELECT contratoProyecto.idContratoProyecto FROM contratoProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO idNewContratoProyecto;
  SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO nombreProyecto;
  SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO idNewProyecto;
  SELECT CatalogoFianzas.nombre FROM CatalogoFianzas JOIN Fianzas ON CatalogoFianzas.idCatalogoFianza = Fianzas.idCatalogoFianza WHERE Fianzas.idFianza=NEW.idFianza INTO nombreFianza;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',idNewContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', NEW.idFianza,' - ',nombreFianza,' / Documento ',NEW.idFianzaDocumento,' - ',NEW.nombreDocumento),'', CONCAT('Documento ',NEW.idFianzaDocumento,' - ',NEW.nombreDocumento));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `FianzaDocumento_update` AFTER UPDATE ON `FianzaDocumento` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    DECLARE idNewProyecto VARCHAR(50);
    DECLARE nomenclaturaContrato VARCHAR(50);
    DECLARE idNewContratoProyecto VARCHAR(50);
    DECLARE nombreFianza VARCHAR(50);
    DECLARE valorAnterior VARCHAR(300);
    DECLARE valorNuevo VARCHAR(300);
    SET query='Actualización';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=9;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT contratoProyecto.nomenclatura FROM contratoProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO nomenclaturaContrato;
    SELECT contratoProyecto.idContratoProyecto FROM contratoProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO idNewContratoProyecto;
    SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=NEW.idFianza INTO nombreProyecto;
    SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto JOIN Fianzas ON contratoProyecto.idContratoProyecto = Fianzas.idContratoProyecto WHERE Fianzas.idFianza=OLD.idFianza INTO idNewProyecto;
    SELECT CatalogoFianzas.nombre FROM CatalogoFianzas JOIN Fianzas ON CatalogoFianzas.idCatalogoFianza = Fianzas.idCatalogoFianza WHERE Fianzas.idFianza=NEW.idFianza INTO nombreFianza;
    IF (NEW.nombreDocumento<> OLD.nombreDocumento)
    THEN
      SET valorNuevo = NEW.nombreDocumento;
      SET valorAnterior = OLD.nombreDocumento;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',idNewContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza,' / Documento ',OLD.idFianzaDocumento,' - ',OLD.nombreDocumento),'Nombre del documento',valorAnterior,valorNuevo);
    END IF;
    IF (NEW.observaciones<> OLD.observaciones)
    THEN
      SET valorNuevo = NEW.observaciones;
      SET valorAnterior = OLD.observaciones;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',idNewContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza,' / Documento ',OLD.idFianzaDocumento,' - ',OLD.nombreDocumento),'Observaciones del documento',valorAnterior,valorNuevo);
    END IF;
    IF (NEW.documento<> OLD.documento)
    THEN
      SET valorNuevo = NEW.documento;
      SET valorAnterior = OLD.documento;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',idNewContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza,' / Documento ',OLD.idFianzaDocumento,' - ',OLD.nombreDocumento),'Documento',valorAnterior,valorNuevo);
    END IF;

  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fianzas`
--

CREATE TABLE `Fianzas` (
  `idFianza` int(11) NOT NULL,
  `idCatalogoFianza` int(11) NOT NULL,
  `idContratoProyecto` int(11) NOT NULL,
  `condiciones` text NOT NULL,
  `monto` double NOT NULL,
  `status` int(11) NOT NULL,
  `diasAviso` int(11) NOT NULL,
  `fechaNotificado` date DEFAULT NULL,
  `vigencia` date NOT NULL,
  `statusCorreo` int(1) NOT NULL,
  `statusFinalizado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Fianzas`
--

INSERT INTO `Fianzas` (`idFianza`, `idCatalogoFianza`, `idContratoProyecto`, `condiciones`, `monto`, `status`, `diasAviso`, `fechaNotificado`, `vigencia`, `statusCorreo`, `statusFinalizado`) VALUES
(14, 7, 5, 'hola', 233450, 1, 0, NULL, '2018-12-07', 0, 1),
(15, 5, 5, '', 100, 0, 0, NULL, '2019-12-02', 0, 1),
(19, 8, 8, 'CONDICIÓN NÚMERO 1: \nLorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ', 600000, 1, 0, NULL, '2019-06-24', 0, 1),
(20, 8, 6, 'tt', 6666, 0, 30, '0000-00-00', '2019-07-15', 0, 0);

--
-- Disparadores `Fianzas`
--
DELIMITER $$
CREATE TRIGGER `Fianzas_delete` AFTER DELETE ON `Fianzas` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    DECLARE idNewProyecto VARCHAR(50);
    DECLARE nomenclaturaContrato VARCHAR(50);
    DECLARE nombreFianza VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=8;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT contratoProyecto.nomenclatura FROM contratoProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nomenclaturaContrato;
    SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nombreProyecto;
    SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO idNewProyecto;
    SELECT CatalogoFianzas.nombre FROM CatalogoFianzas WHERE CatalogoFianzas.idCatalogoFianza=OLD.idCatalogoFianza INTO nombreFianza;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),CONCAT('Fianza ',OLD.idFianza,' - ',nombreFianza),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Fianzas_insert` AFTER INSERT ON `Fianzas` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreProyecto VARCHAR(50);
  DECLARE idNewProyecto VARCHAR(50);
  DECLARE nomenclaturaContrato VARCHAR(50);
  DECLARE nombreFianza VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=8;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT contratoProyecto.nomenclatura FROM contratoProyecto WHERE contratoProyecto.idContratoProyecto=NEW.idContratoProyecto INTO nomenclaturaContrato;
  SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=NEW.idContratoProyecto INTO nombreProyecto;
  SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=NEW.idContratoProyecto INTO idNewProyecto;
  SELECT CatalogoFianzas.nombre FROM CatalogoFianzas WHERE CatalogoFianzas.idCatalogoFianza=NEW.idCatalogoFianza INTO nombreFianza;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',NEW.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', NEW.idFianza,' - ',nombreFianza),'', CONCAT('Fianza ',NEW.idFianza,' - ', nombreFianza));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Fianzas_update` AFTER UPDATE ON `Fianzas` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    DECLARE idNewProyecto VARCHAR(50);
    DECLARE nomenclaturaContrato VARCHAR(50);
    DECLARE nombreFianza VARCHAR(50);
    DECLARE valorAnterior VARCHAR(300);
    DECLARE valorNuevo VARCHAR(300);
    SET query='Actualización';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=8;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT contratoProyecto.nomenclatura FROM contratoProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nomenclaturaContrato;
    SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nombreProyecto;
    SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO idNewProyecto;
    SELECT CatalogoFianzas.nombre FROM CatalogoFianzas WHERE CatalogoFianzas.idCatalogoFianza=OLD.idCatalogoFianza INTO nombreFianza;
    IF (NEW.condiciones<> OLD.condiciones)
    THEN
      SET valorNuevo = NEW.condiciones;
      SET valorAnterior = OLD.condiciones;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),'Condiciones',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.monto<> OLD.monto)
    THEN
      SET valorNuevo = NEW.monto;
      SET valorAnterior = OLD.monto;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),'Monto',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.vigencia<> OLD.vigencia)
    THEN
      SET valorNuevo = NEW.vigencia;
      SET valorAnterior = OLD.vigencia;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),'Vigencia',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.idCatalogoFianza<> OLD.idCatalogoFianza)
    THEN
      SELECT CatalogoFianzas.nombre FROM CatalogoFianzas WHERE CatalogoFianzas.idCatalogoFianza=NEW.idCatalogoFianza INTO valorNuevo;
      SELECT CatalogoFianzas.nombre FROM CatalogoFianzas WHERE CatalogoFianzas.idCatalogoFianza=OLD.idCatalogoFianza INTO valorAnterior;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),'Tipo de fianza',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.statusFinalizado<> OLD.statusFinalizado)
    THEN
      IF(NEW.statusFinalizado=1)THEN
        SET valorNuevo='Finalizada';
        SET valorAnterior='No finalizada';
        ELSE
          SET valorAnterior='Finalizada';
          SET valorNuevo='No finalizada';
      END IF;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),'¿Finalizada?',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.status<> OLD.status)
    THEN
      IF(NEW.status=1)THEN
        SET valorNuevo='Pagada';
        SET valorAnterior='No pagada';
        ELSE
          SET valorAnterior='Pagada';
          SET valorNuevo='No pagada';
      END IF;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Fianza ', OLD.idFianza,' - ',nombreFianza),'Status',valorAnterior, valorNuevo);
    END IF;
    
    
    
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Modulo`
--

CREATE TABLE `Modulo` (
  `idModulo` int(11) NOT NULL,
  `nombreModulo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Modulo`
--

INSERT INTO `Modulo` (`idModulo`, `nombreModulo`) VALUES
(1, 'Tipos de usuarios'),
(2, 'Áreas'),
(3, 'Gestión documental'),
(4, 'Tipos de contrato'),
(5, 'Status de contrato'),
(6, 'Proyectos'),
(7, 'Contratos de un proyecto'),
(8, 'Fianzas / garantías de un contrato'),
(9, 'Documentos de la fianza / garantía de un contrato'),
(10, 'Rediciones de un contrato'),
(11, 'Clientes / Proveedores'),
(12, 'Fianzas / Garantía'),
(13, 'Gráficas'),
(14, 'Empresas internas'),
(15, 'Documentos de una empresa interna'),
(16, 'Archivo muerto'),
(17, 'Bitácora'),
(21, 'Usuarios'),
(22, 'Permisos'),
(23, 'Documentos de un cliente / proveedor'),
(24, 'Tipos de contrato de un usuario'),
(25, 'Expediente de usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Permiso`
--

CREATE TABLE `Permiso` (
  `idTipoUsuario` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  `mostrar` int(11) NOT NULL,
  `alta` int(11) NOT NULL,
  `detalle` int(11) NOT NULL,
  `editar` int(11) NOT NULL,
  `eliminar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Permiso`
--

INSERT INTO `Permiso` (`idTipoUsuario`, `idModulo`, `mostrar`, `alta`, `detalle`, `editar`, `eliminar`) VALUES
(1, 0, 1, 1, 1, 1, 1),
(1, 1, 1, 1, 1, 1, 1),
(1, 2, 1, 1, 1, 1, 1),
(1, 3, 1, 1, 1, 1, 1),
(1, 4, 1, 1, 1, 1, 1),
(1, 5, 1, 1, 1, 1, 1),
(1, 6, 1, 1, 1, 1, 1),
(1, 7, 1, 1, 1, 1, 1),
(1, 8, 1, 1, 1, 1, 1),
(1, 9, 1, 1, 1, 1, 1),
(1, 10, 1, 1, 1, 1, 1),
(1, 11, 1, 1, 1, 1, 1),
(1, 12, 1, 1, 1, 1, 1),
(1, 13, 1, 1, 1, 1, 1),
(1, 14, 1, 1, 1, 1, 1),
(1, 15, 1, 1, 1, 1, 1),
(1, 16, 1, 1, 1, 1, 1),
(1, 17, 1, 1, 1, 1, 1),
(1, 23, 1, 1, 1, 1, 1),
(1, 25, 1, 1, 1, 1, 1),
(2, 0, 1, 0, 0, 0, 0),
(2, 1, 0, 0, 0, 0, 0),
(2, 2, 1, 0, 0, 0, 0),
(2, 3, 1, 1, 1, 0, 0),
(2, 4, 1, 0, 0, 0, 0),
(2, 5, 1, 0, 0, 0, 0),
(2, 6, 1, 1, 1, 1, 1),
(2, 7, 1, 1, 1, 1, 1),
(2, 8, 1, 1, 0, 1, 0),
(2, 9, 1, 1, 1, 1, 1),
(2, 10, 1, 1, 1, 1, 1),
(2, 11, 1, 0, 0, 0, 0),
(2, 12, 1, 0, 0, 0, 0),
(2, 13, 1, 1, 1, 1, 1),
(2, 14, 1, 0, 0, 0, 0),
(2, 15, 1, 1, 1, 1, 0),
(2, 16, 1, 0, 0, 0, 0),
(4, 0, 1, 0, 0, 0, 0),
(4, 3, 1, 0, 0, 0, 0),
(4, 7, 0, 0, 0, 0, 0),
(4, 8, 0, 0, 0, 0, 0),
(4, 11, 1, 0, 0, 0, 0),
(4, 23, 0, 0, 0, 0, 0),
(4, 25, 1, 0, 1, 1, 1),
(7, 0, 1, 1, 1, 1, 1),
(7, 1, 1, 1, 1, 1, 1),
(7, 2, 1, 1, 1, 1, 1),
(7, 3, 1, 1, 1, 1, 1),
(7, 4, 1, 1, 1, 1, 1),
(7, 5, 1, 1, 1, 1, 1),
(7, 6, 1, 1, 1, 1, 1),
(7, 7, 1, 1, 1, 1, 1),
(7, 8, 1, 1, 1, 1, 1),
(7, 9, 1, 1, 1, 1, 1),
(7, 10, 1, 1, 1, 1, 1),
(7, 11, 1, 1, 1, 1, 1),
(7, 12, 1, 1, 1, 1, 1),
(7, 13, 1, 1, 1, 1, 1),
(7, 14, 1, 1, 1, 1, 1),
(7, 15, 1, 1, 1, 1, 1),
(7, 16, 1, 1, 1, 1, 1),
(9, 0, 1, 0, 0, 0, 0),
(9, 1, 0, 0, 0, 0, 0),
(9, 2, 1, 0, 0, 0, 0),
(9, 3, 1, 0, 0, 0, 0),
(9, 4, 1, 0, 0, 0, 0),
(9, 5, 1, 0, 0, 0, 0),
(9, 6, 1, 0, 0, 0, 0),
(9, 7, 1, 0, 0, 0, 0),
(9, 8, 1, 0, 0, 0, 0),
(9, 9, 1, 0, 0, 0, 0),
(9, 10, 1, 0, 0, 0, 0),
(9, 11, 1, 0, 0, 0, 0),
(9, 12, 1, 0, 0, 0, 0),
(9, 13, 1, 0, 0, 0, 0),
(9, 14, 1, 0, 0, 0, 0),
(9, 15, 1, 0, 0, 0, 0),
(9, 16, 1, 0, 0, 0, 0),
(10, 0, 1, 0, 0, 0, 0),
(10, 1, 1, 0, 0, 0, 0),
(10, 2, 1, 0, 0, 0, 0),
(10, 3, 1, 0, 0, 0, 0),
(10, 4, 1, 0, 0, 0, 0),
(10, 5, 1, 0, 0, 0, 0),
(10, 6, 1, 0, 0, 0, 0),
(10, 7, 1, 0, 0, 0, 0),
(10, 8, 1, 0, 0, 0, 0),
(10, 9, 1, 0, 0, 0, 0),
(10, 10, 1, 0, 0, 0, 0),
(10, 11, 1, 0, 0, 0, 0),
(10, 12, 1, 0, 0, 0, 0),
(10, 13, 1, 0, 0, 0, 0),
(10, 14, 1, 0, 0, 0, 0),
(10, 15, 1, 0, 0, 0, 0),
(10, 16, 1, 0, 0, 0, 0),
(11, 3, 1, 0, 0, 0, 0),
(11, 4, 1, 0, 0, 0, 0),
(11, 5, 1, 0, 0, 0, 0),
(11, 6, 1, 0, 0, 0, 0),
(11, 7, 1, 0, 0, 0, 0),
(11, 8, 1, 0, 0, 0, 0),
(11, 9, 1, 0, 0, 0, 0),
(11, 10, 1, 0, 0, 0, 0),
(11, 11, 1, 0, 0, 0, 0),
(11, 12, 1, 0, 0, 0, 0),
(11, 15, 1, 0, 0, 0, 0),
(11, 16, 1, 0, 0, 0, 0),
(12, 3, 1, 0, 0, 0, 0),
(12, 4, 0, 0, 0, 0, 0),
(12, 5, 1, 0, 0, 0, 0),
(12, 6, 1, 0, 0, 0, 0),
(12, 7, 1, 0, 0, 0, 0),
(12, 8, 1, 0, 0, 0, 0),
(12, 9, 1, 0, 0, 0, 0),
(12, 10, 1, 0, 0, 0, 0),
(12, 12, 1, 0, 0, 0, 0),
(12, 14, 0, 0, 0, 0, 0),
(14, 11, 1, 0, 1, 0, 0),
(14, 12, 0, 0, 0, 0, 0);

--
-- Disparadores `Permiso`
--
DELIMITER $$
CREATE TRIGGER `permiso_delete` AFTER DELETE ON `Permiso` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreTipoUsuario VARCHAR(50);
    DECLARE nombreModulo VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SELECT tipoUser.nombreTipo FROM tipoUser WHERE tipoUser.idTipo=OLD.idTipoUsuario INTO nombreTipoUsuario;
    SELECT Modulo.nombreModulo FROM Modulo WHERE Modulo.idModulo=OLD.idModulo INTO nombreModulo;
    SET module=22;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',OLD.idTipoUsuario,' - ',nombreTipoUsuario,'/ Módulo ',nombreModulo), CONCAT('Permiso para el tipo de usuario ',nombreTipoUsuario,' en el módulo ',nombreModulo), '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `permiso_insert` AFTER INSERT ON `Permiso` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreTipoUsuario VARCHAR(50);
  DECLARE nombreModulo VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=22;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT tipoUser.nombreTipo FROM tipoUser WHERE tipoUser.idTipo=NEW.idTipoUsuario INTO nombreTipoUsuario;
  SELECT Modulo.nombreModulo FROM Modulo WHERE Modulo.idModulo=NEW.idModulo INTO nombreModulo;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',NEW.idTipoUsuario,' - ',nombreTipoUsuario,' / Nuevo permiso en el módulo ', nombreModulo), '', CONCAT('Nuevo permiso en el módulo ', nombreModulo));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `permiso_update` AFTER UPDATE ON `Permiso` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE tipoPermiso varchar(20);
  DECLARE nombreTipoUsuario VARCHAR(50);
  DECLARE nombreModulo VARCHAR(50);
  DECLARE permisoAntes varchar(50);
  DECLARE permisoDespues varchar(50);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=22;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT tipoUser.nombreTipo FROM tipoUser WHERE tipoUser.idTipo=OLD.idTipoUsuario INTO nombreTipoUsuario;
  SELECT Modulo.nombreModulo FROM Modulo WHERE Modulo.idModulo=OLD.idModulo INTO nombreModulo;

  IF(NEW.editar<>OLD.editar)
  THEN
    SET tipoPermiso='Edición';
    IF(OLD.editar = 1) THEN
      SET permisoAntes='Con permiso';
      SET permisoDespues='Sin permiso';
    ELSEIF (OLD.editar=0) THEN
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    ELSE 
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    end if;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',OLD.idTipoUsuario,' - ',nombreTipoUsuario,'/ Módulo ',nombreModulo),tipoPermiso, permisoAntes, permisoDespues);
  END IF;

IF(NEW.eliminar<>OLD.eliminar)
  THEN
    SET tipoPermiso='Eliminar';
    IF(OLD.eliminar = 1) THEN
      SET permisoAntes='Con permiso';
      SET permisoDespues='Sin permiso';
    ELSEIF (OLD.eliminar=0) THEN
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    ELSE 
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    end if;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',OLD.idTipoUsuario,' - ',nombreTipoUsuario,'/ Módulo ',nombreModulo),tipoPermiso, permisoAntes, permisoDespues);
  END IF;

IF(NEW.detalle<>OLD.detalle)
  THEN
    SET tipoPermiso='Detalles';
    IF(OLD.detalle = 1) THEN
      SET permisoAntes='Con permiso';
      SET permisoDespues='Sin permiso';
    ELSEIF (OLD.detalle=0) THEN
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    ELSE 
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    end if;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',OLD.idTipoUsuario,' - ',nombreTipoUsuario,'/ Módulo ',nombreModulo),tipoPermiso, permisoAntes, permisoDespues);
  END IF;

IF(NEW.alta<>OLD.alta)
  THEN
    SET tipoPermiso='Edición';
    IF(OLD.alta = 1) THEN
      SET permisoAntes='Con permiso';
      SET permisoDespues='Sin permiso';
    ELSEIF (OLD.alta=0) THEN
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    ELSE 
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    end if;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',OLD.idTipoUsuario,' - ',nombreTipoUsuario,'/ Módulo ',nombreModulo),tipoPermiso, permisoAntes, permisoDespues);
  END IF;

IF(NEW.mostrar<>OLD.mostrar)
  THEN
    SET tipoPermiso='Mostrar';
    IF(OLD.mostrar = 1) THEN
      SET permisoAntes='Con permiso';
      SET permisoDespues='Sin permiso';
    ELSEIF (OLD.mostrar = 0) THEN
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    ELSE 
      SET permisoAntes='Sin permiso';
      SET permisoDespues='Con permiso';
    end if;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Tipo de usuario ',OLD.idTipoUsuario,' - ',nombreTipoUsuario,'/ Módulo ',nombreModulo),tipoPermiso, permisoAntes, permisoDespues);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `idProyecto` int(11) NOT NULL,
  `nombreProyecto` varchar(100) DEFAULT NULL,
  `idEmpresaInterna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`idProyecto`, `nombreProyecto`, `idEmpresaInterna`) VALUES
(5, 'Nuevo Aeropuerto de México', 3),
(8, 'Aeropuerto CDMX', 3),
(11, 'Estructura metálica ', 3);

--
-- Disparadores `proyecto`
--
DELIMITER $$
CREATE TRIGGER `proyecto_delete` AFTER DELETE ON `proyecto` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=6;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',OLD.idProyecto,' - ',OLD.nombreProyecto), CONCAT('Proyecto ',OLD.idProyecto,' - ',OLD.nombreProyecto), '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `proyecto_insert` AFTER INSERT ON `proyecto` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=6;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',NEW.idProyecto,' - ',NEW.nombreProyecto), '', CONCAT('Proyecto ',NEW.idProyecto,' - ',NEW.nombreProyecto));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `proyecto_update` AFTER UPDATE ON `proyecto` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreEmpresaInternaAntes VARCHAR(20);
  DECLARE nombreEmpresaInternaDespues VARCHAR(20);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=6;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.nombreProyecto!=OLD.nombreProyecto)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',OLD.idProyecto,' - ',OLD.nombreProyecto),'Nombre', OLD.nombreProyecto, NEW.nombreProyecto);
  END IF;
  IF(NEW.idEmpresaInterna<>OLD.idEmpresaInterna)
  THEN
    SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=OLD.idEmpresaInterna INTO nombreEmpresaInternaAntes;
    SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=NEW.idEmpresaInterna INTO nombreEmpresaInternaDespues;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',OLD.idProyecto,' - ',OLD.nombreProyecto),'Empresa', nombreEmpresaInternaAntes, nombreEmpresaInternaDespues);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `StatusContratos`
--

CREATE TABLE `StatusContratos` (
  `idStatusContrato` int(11) NOT NULL,
  `clase` varchar(100) DEFAULT NULL,
  `etiqueta` varchar(150) DEFAULT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que almacena los posibles estados de un contrato';

--
-- Volcado de datos para la tabla `StatusContratos`
--

INSERT INTO `StatusContratos` (`idStatusContrato`, `clase`, `etiqueta`, `orden`) VALUES
(3, 'gradient-45deg-purple-amber', 'Pendiente', 0),
(4, 'gradient-45deg-blue-indigo', 'Revisión', 4),
(5, 'gradient-45deg-deep-orange-orange', 'Negociación', 2),
(6, 'gradient-45deg-purple-deep-purple', 'Firmas', 5),
(7, 'gradient-45deg-green-teal', 'Definitivo', 3),
(8, 'gradient-45deg-brown-brown', 'Adendum ', 6),
(10, 'gradient-45deg-indigo-purple', 'En ejecución', 1),
(11, 'gradient-45deg-light-blue-cyan', 'Finalizado', 9),
(12, 'gradient-45deg-purple-amber', 'Convenio modificatorio', 8);

--
-- Disparadores `StatusContratos`
--
DELIMITER $$
CREATE TRIGGER `StatusContratos_delete` AFTER DELETE ON `StatusContratos` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=5;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Status de contratos ',OLD.idStatusContrato,' - ',OLD.etiqueta), CONCAT('Status de contratos ',OLD.idStatusContrato,' - ',OLD.etiqueta), '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `StatusContratos_insert` AFTER INSERT ON `StatusContratos` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=5;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Status de contratos ',NEW.idStatusContrato,' - ',NEW.etiqueta), '', CONCAT('Status de contratos ',NEW.idStatusContrato,' - ',NEW.etiqueta));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `StatusContratos_update` AFTER UPDATE ON `StatusContratos` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=5;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.etiqueta!=OLD.etiqueta)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Status de contratos ',OLD.idStatusContrato,' - ',OLD.etiqueta),'Etiqueta', OLD.etiqueta, NEW.etiqueta);
  END IF;
  IF(NEW.clase<>OLD.clase)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Status de contratos ',OLD.idStatusContrato,' - ',OLD.etiqueta),'Color', OLD.clase, NEW.clase);
  END IF;
  IF(NEW.orden<>OLD.orden)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Status de contratos ',OLD.idStatusContrato,' - ',OLD.etiqueta),'Orden', OLD.orden, NEW.orden);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoContrato`
--

CREATE TABLE `tipoContrato` (
  `idTipoC` int(11) NOT NULL,
  `claveContrato` varchar(100) NOT NULL,
  `nombreTipo` varchar(250) NOT NULL,
  `template` varchar(250) NOT NULL,
  `idContrato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoContrato`
--

INSERT INTO `tipoContrato` (`idTipoC`, `claveContrato`, `nombreTipo`, `template`, `idContrato`) VALUES
(2, 'F-03-P-JD-02', 'Contrato de sueldos y salarios', 'formato.docx', 18),
(3, 'F-03-P-JD-01', 'Emitido por el cliente', 'null', 17),
(5, 'F-02-P-JD-01', 'Contrato de suministros', 'null', 17),
(6, 'F-03-P-JD-02', 'Contrato de obra', 'null', 17),
(7, 'F-04-P-JD-01', 'Contrato de prestación de servicios', 'null', 17),
(8, 'F-05-P-JD-01', 'Contrato de arrendamiento', '', 19);

--
-- Disparadores `tipoContrato`
--
DELIMITER $$
CREATE TRIGGER `tipoContrato_delete` AFTER DELETE ON `tipoContrato` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreGestionDocumental varchar(30);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=4;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT Contrato.nombre FROM Contrato WHERE Contrato.idContrato=OLD.idContrato INTO nombreGestionDocumental;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',nombreGestionDocumental,' / Tipo de contrato ',OLD.idTipoC,' - ',OLD.nombreTipo), CONCAT('Tipo de contrato ',OLD.idTipoC,' - ',OLD.nombreTipo),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tipoContrato_insert` AFTER INSERT ON `tipoContrato` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreGestionDocumental varchar(30);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=4;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT Contrato.nombre FROM Contrato WHERE Contrato.idContrato=NEW.idContrato INTO nombreGestionDocumental;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',NEW.idContrato,' - ',nombreGestionDocumental,' / Tipo de contrato ',NEW.idTipoC,' - ',NEW.nombreTipo), '', CONCAT('Nuevo tipo de contrato ',NEW.idTipoC,' - ',NEW.nombreTipo));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tipoContrato_update` AFTER UPDATE ON `tipoContrato` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreGestionDocumental varchar(30);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=4;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT Contrato.nombre FROM Contrato WHERE Contrato.idContrato=OLD.idContrato INTO nombreGestionDocumental;

  IF(NEW.nombreTipo!=OLD.nombreTipo)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',nombreGestionDocumental,' / Tipo de contrato ',OLD.idTipoC,' - ',OLD.nombreTipo),'Nombre del tipo de contrato',Old.nombreTipo, NEW.nombreTipo);
  END IF;
  IF(NEW.claveContrato<>OLD.claveContrato)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',nombreGestionDocumental,' / Tipo de contrato ',OLD.idTipoC,' - ',OLD.nombreTipo),'Clave del tipo de contrato',Old.claveContrato, NEW.claveContrato);
  END IF;
  IF(NEW.template<>OLD.template)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Gestión documental ',OLD.idContrato,' - ',nombreGestionDocumental,' / Tipo de contrato ',OLD.idTipoC,' - ',OLD.nombreTipo),'Plantilla del tipo de contrato',Old.template, NEW.template);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoUser`
--

CREATE TABLE `tipoUser` (
  `idTipo` int(11) NOT NULL,
  `nombreTipo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoUser`
--

INSERT INTO `tipoUser` (`idTipo`, `nombreTipo`) VALUES
(1, 'Administrador'),
(2, 'Gerente Administrativo'),
(4, 'Coordinador Juridico'),
(6, 'Coordinador  Tesoreria'),
(7, 'Director'),
(8, 'Coordinador RH'),
(9, 'Coordinador Contable'),
(10, 'Presidencia'),
(11, 'Gerente Proyectos'),
(12, 'Gerente Tecnico'),
(13, 'Coordinador SGI'),
(14, 'Verificador');

--
-- Disparadores `tipoUser`
--
DELIMITER $$
CREATE TRIGGER `tipoUser_delete` AFTER DELETE ON `tipoUser` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE modulo INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET modulo=21;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Tipo de usuario ',OLD.idTipo,' - ',OLD.nombreTipo), OLD.nombreTipo, '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tipoUser_insert` AFTER INSERT ON `tipoUser` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=1;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Tipo de usuario ',NEW.idTipo,' - ',NEW.nombreTipo), '', NEW.nombreTipo);
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tipoUser_update` AFTER UPDATE ON `tipoUser` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=21;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  IF(NEW.idTipo<>OLD.idTipo)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Tipo de usuario ',OLD.idTipo,' - ',OLD.nombreTipo),'ID de tipo de usuario', OLD.idTipo, NEW.idTipo);
  END IF;
  IF(NEW.nombreTipo<>OLD.nombreTipo)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Tipo de usuario ',OLD.idTipo,' - ',OLD.nombreTipo),'Nombre de tipo de usuario ', OLD.nombreTipo, NEW.nombreTipo);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsuarioEmpresa`
--

CREATE TABLE `UsuarioEmpresa` (
  `idUsuario` int(11) NOT NULL DEFAULT '0',
  `idEmpresaInterna` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `UsuarioEmpresa`
--

INSERT INTO `UsuarioEmpresa` (`idUsuario`, `idEmpresaInterna`) VALUES
(1, 2),
(14, 2),
(16, 2),
(18, 2),
(19, 2),
(20, 2),
(22, 2),
(24, 2),
(25, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(1, 3),
(14, 3),
(16, 3),
(18, 3),
(19, 3),
(20, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(33, 3),
(1, 5),
(16, 5),
(18, 5),
(19, 5),
(24, 5),
(25, 5),
(33, 5),
(1, 7),
(16, 7),
(18, 7),
(19, 7),
(24, 7),
(25, 7),
(33, 7),
(1, 10),
(16, 10),
(18, 10),
(19, 10),
(23, 10),
(24, 10),
(25, 10),
(33, 10),
(1, 11),
(16, 11),
(18, 11),
(19, 11),
(24, 11),
(25, 11),
(33, 11),
(1, 12),
(16, 12),
(18, 12),
(19, 12),
(24, 12),
(25, 12),
(33, 12),
(1, 13),
(16, 13),
(18, 13),
(19, 13),
(24, 13),
(25, 13),
(33, 13),
(1, 14),
(16, 14),
(18, 14),
(19, 14),
(20, 14),
(23, 14),
(24, 14),
(25, 14),
(33, 14);

--
-- Disparadores `UsuarioEmpresa`
--
DELIMITER $$
CREATE TRIGGER `UsuarioEmpresa_delete` AFTER DELETE ON `UsuarioEmpresa` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  DECLARE valorUsuarioAnterior varchar(300);
  DECLARE valorEmpresaAnterior varchar(300);
  SET query='Eliminación';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=21;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT nombreUser FROM Usuarios WHERE Usuarios.idUser=OLD.idUsuario INTO valorUsuarioAnterior;
  SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=OLD.idEmpresaInterna INTO valorEmpresaAnterior;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUsuario,' - ',valorUsuarioAnterior,' / Empresa ',OLD.idEmpresaInterna,' - ',valorEmpresaAnterior), 'Liga Usuario-Empresa', CONCAT('Usuario ',valorUsuarioAnterior,' - Empresa ',valorEmpresaAnterior), '');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UsuarioEmpresa_insert` AFTER INSERT ON `UsuarioEmpresa` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  
  DECLARE valorUsuarioNuevo varchar(300);
  DECLARE valorEmpresaNuevo varchar(300);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=21;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT nombreUser FROM Usuarios WHERE Usuarios.idUser=NEW.idUsuario INTO valorUsuarioNuevo;
  SELECT empresainterna.nombreEmpresa FROM empresainterna WHERE empresainterna.idEmpresaInterna=NEW.idEmpresaInterna INTO valorEmpresaNuevo;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',NEW.idUsuario,' - ',valorUsuarioNuevo,' / Empresa ',NEW.idEmpresaInterna,' - ',valorEmpresaNuevo), 'Liga Usuario-Empresa', '', CONCAT('Usuario ',valorUsuarioNuevo,' - Empresa ',valorEmpresaNuevo));
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `idUser` int(11) NOT NULL,
  `nombreUser` varchar(250) NOT NULL,
  `nickName` varchar(100) NOT NULL,
  `passwordUser` varchar(300) NOT NULL,
  `correoDestino` varchar(150) NOT NULL,
  `idArea` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`idUser`, `nombreUser`, `nickName`, `passwordUser`, `correoDestino`, `idArea`, `idTipo`, `Status`) VALUES
(1, 'Cointic', 'cointic', '7de69656bbb5271b2871cde34f2fc762aece20c22dabdb518700688325824c14736b73a3d7ada23e88d8517546d326019a00aa36a6932cfd87f411e264bff916gqCgy360GchjTU2x6cfsROWAm8HCyPOXo46O6BcS2l8=', 'marcos.moreno@cointic.com.mx', 1, 1, 0),
(14, 'Hugo leon', 'Hugoleon', '4c9c2172916b6cc5bafb22653574eba8069b4abaeb10024b2d6519622d8e7a7a36fe5931dcae77eb4b5f3af6e9c374892382c7f3fb0cc294db3d5d35b243a8a4NFeNdiJhaRawDTDDWf0ul9zLXCUe1FsXArj5Fw1YrUo=', 'hugoless91@gmail.com', 1, 1, 0),
(16, 'Fernando Monroy ', 'fmonroy', '39c92cb74e05304dc710659e06c64ee74a74d7e1feca5c460f5e63fc7ae8048810c9f3b17d1caf9ff40183cc7af09f1c2c8689ee5c171353b4dbf2246f9c1a74MI2uELVvo7+Io1T0VoSX4F7bYz25y+zTULVYYzkEKSE=', 'fernando.monroy@cointic.com.mx', 1, 2, 0),
(18, 'Francisco Pacheco Ramirez', 'Fpacheco', '44739a2bb3fa8478459b28f929e0e54bd8572e0aa70fcade7e9a5d885efeff8e90514a505ed232e85751eefa2f80b628fb3c7d0d9932d4e8138bce5d1cbf9f1cctHGQITopyRGgVSRymsVNuDgOt642ptbpuGo3um5VhE=', 'fpacheco_cpf@constructora-antar.com.mx', 5, 2, 0),
(19, 'Pedro E. Arjona Allison', 'Pearjona', 'f5b4551d5e74dc3d71ac9c932ff145f1125d3b1cf0de0b4e402f05ada0dfbdf592f932d8185d9e42082232f009e02eb2f7ae766a9779a3dfa74e867fb2ed3700idQOprvuOJM6msogz2NHnuJsB6pzj+KqsHWZCrdtH3A=', 'pearjona@constructora-antar.com.mx', 17, 10, 0),
(20, 'Samara Jimenez', 'sjimenez', 'eae496c11f40182923edfcd631adb4d66ebba04aa4d759da29f7d420f8fc148d041f3e8ad29ea82cbe9ec638dc1dcd4b133094716830806b34176ec91a3be341JS38KGXrce79Sk2IhGMfx8KFtRzI2VYOObamf7FBpB4=', 'sjimenez@constructora-antar.com.mx', 1, 8, 0),
(21, 'Alan Omar Gonzalez Lopez', 'ogonzalez', 'c0c04a90e2de3a17120a312f956f5ccdf3115cf2cb8f2653b45ad13bda94737c446270c9f79e9d41c272956400d95b31545336c3455e009af78423e3c10ae7561fMQmYauYoI49Eb/JzzIV9LQRFcTuvN46oTIXwaJnBE=', 'ogonzalez@constructora-antar.com.mx', 16, 1, 0),
(22, 'Salvador Segovia Sandoval', 'ssegovia', 'e2f7d034e64ade73ddfef730ea18b04e9a382914674454dce3da12d1f932d6cacf8c2eb5685fed208e0b8bc3a441fc7d5377e96be84090cf3cb861346a58cd59WQ4HKQanIH4QL3Ks8Ej+bDlRsqFoEc/IYoFZIlGElTI=', 'ssegovia@deisa.com.mx', 9, 7, 0),
(23, 'Mario  Varela', 'mavarela', '4e8463066f3740edc48984587bce6cda4110077b7700d5b960465240e4281a85e3eb4efb77ef6ae5098dd0891a080b3b6c7d464c02f3b69a8cf6dfcae006f4e2IPFCfgO9hZqScqv9xlY4Bnuwo4jiPDaWoF9VXbelv6U=', 'mavarela@cosntructora-antar.com.mx', 10, 11, 0),
(24, 'María Clara Jimenez', 'mcjimenez', '340a89dfb5df858a9250701b7b47699a802f38241121776931c818bc7ca8bfc132cca8c0f43c24018e1468068cca8a70f2adcb21b0d78a5b5ad3be0dfcdcbd914bkyWrhmj/27l5hRJ1qdzFVnF7zWEXcaaKJmaUv+DxI=', 'mcjimenez@constructora-antar.com.mx', 19, 6, 0),
(25, 'Sandra Nieto', 'snieto', '2e53bda7d749754d477dd85fb9572036e686bdb2da679b13e4a02d0de2c2bc30ac29008be095241ed0afbb25db9909412baa87ea2660d7bc47d4970e5730cb05XvXfYC4Yu85kMpxyvRmiJ5JU4f0oPILVUrS72tLu1kk=', 'sandra_cpf@constructora-antar.com.mx', 18, 9, 0),
(26, 'Pedro Garcia', 'pgarciao', '97bc27cfb1266084e83689af82f0eb7e15cb79780c22d28c719fdf008060b2f04baf520e9975010426fd7ab4ae299d60f782c50ddf6fcc78d2d6d911937d3eb2iLl7wWziZhjUQd1zab2rLCrRbKnh55mOAJO2wnJaNQQ=', 'pgarciao@constructora-antar.com.mx', 8, 12, 0),
(27, 'Jesus Hernandez', 'jhernandez', 'd1d77713ecfc09eedc95a3801b9318b84521474e740c139af0ddee0d943d1a0451d4c64ac5524f77228c2e352a56beffe25faa75ba44658300375fd5634132caKoLFrdshgqE4f6XsmLdLKDqsPwgM5RULC+xktnLMQR4=', 'jhernandez@constructora-antar.com.mx', 8, 12, 0),
(28, 'Ernesto Jimenez', 'ejimenez', '514ecabe2a313781f67349f698ae61f58d7d893873cdc1572342c8ace7bfe1dd8507abc06f6cfc999e7fa63fb90dea814fbf24c86cc706bcd9fa6629dd7bb23awVkOxKbBDwOqba2NtBSzp78hcOGCyJOdyIfs3FT48qU=', 'ejimenez@constructora-antar.com.mx', 13, 12, 0),
(29, 'Paola Arenas', 'parenas', 'b02a5be101509f297a90de1fb3d441765f9f3a68e3c07be8d4fca2b5f39ee107a793ec98170a4d6f52a616b1589872586874cd86453481edb2cd9de4c75b01c9z8C7CVGyxPdcg9FzjWiSJgpQ31Z7A8ea31AQYQXe1AE=', 'p.arenas@deisa.com.mx', 14, 12, 0),
(30, 'Jesus T. espinoza', 'jtespinoza', 'd4a19960eaf6a3e4bbe740514defde46c4871fc3da0dd086781b20e30ba659ba985a35e72578eadbf08838effab2ab4168bf41523e2ee327ff336b491d8a1532J90jxX8g/4KWUOMn+7AoVBu/ZZqxClqmymdSgX3F++4=', 'jtespinoza@deisa.com.mx', 15, 12, 0),
(31, 'Fernando Palacios ', 'fpalacios', '3de43157cff0a2e102f3ad9de1e93b886122c3fd5c6e5b35e1c8d9baea35303eb7a9d61cd43c816ccff50c2827783a6024c99b8b3d9ac86ba2f1802bf5502c55bVh8s2H3M7N/P3QPV1aJPoxiBtisosXTVus4HuEDKkw=', 'fpalacios@deisa.com.m', 20, 12, 0),
(32, 'Ricardo Cortes', 'rcortes', '6839b2afd7d9d8cd9979ff96c388a9e7a0723b578e35a68b2edc5f53dad4b4f8051d9bace966ece71565400f721fc5d751aa4d45cf8b0be9058a14d4ea82fd0aSkc2WDM2IV8BnK+d70FDAG1Xdn9Pz+fKMO2zmPw8NjY=', 'rcortes@deisa.com.mx', 21, 13, 0),
(33, 'Test User', 'userTest', '626356e71749b0ea01561901ef64e049741b9603beb04505f2e2cd69111043cd24571255dbb3e8569408a8ec6a4b3f1223cd43b5ac5fc359b5a2ad2685fca7cfjGnKxBHgRLnzrTzFyL63y85HiH/KYeGRVrY+Kq9BOaI=', 'capacitacion@gmail.com', 20, 1, 0);

--
-- Disparadores `Usuarios`
--
DELIMITER $$
CREATE TRIGGER `usuario_delete` AFTER DELETE ON `Usuarios` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE modulo INT;
    DECLARE query VARCHAR(20);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET modulo=21;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName), OLD.nombreUser, '');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `usuario_insert` AFTER INSERT ON `Usuarios` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=21;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',NEW.idUser,' - ',NEW.nickName), '', NEW.nombreUser);
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `usuario_update` AFTER UPDATE ON `Usuarios` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE modulo INT;
  DECLARE query VARCHAR(20);
  DECLARE valorAnterior varchar(300);
  DECLARE valorNuevo varchar(300);
  SET query='Actualización';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET modulo=21;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;

  IF(NEW.idUser<>OLD.idUser)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'ID de usuario', OLD.idUser, NEW.idUser);
  END IF;
  IF(NEW.nombreUser<>OLD.nombreUser)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Nombre', OLD.nombreUser, NEW.nombreUser);
  END IF;
  IF(NEW.nickName<>OLD.nickName)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Nickname', OLD.nickName, NEW.nickName);
  END IF;
  IF(NEW.passwordUser<>OLD.passwordUser)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Password', SUBSTR(OLD.passwordUser, 1, 5), SUBSTR(NEW.passwordUser, 1, 5));
  END IF;

  IF(NEW.correoDestino<>OLD.correoDestino)
  THEN
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Correo', OLD.correoDestino, NEW.correoDestino);
  END IF;

  IF(NEW.idArea<>OLD.idArea)
  THEN
    SELECT area.nombreArea FROM area WHERE area.idArea=OLD.idArea INTO valorAnterior;
    SELECT area.nombreArea FROM area WHERE area.idArea=NEW.idArea INTO valorNuevo;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Área', valorAnterior, valorNuevo);
  END IF;

  IF(NEW.idTipo<>OLD.idTipo)
  THEN
    SELECT tipoUser.nombreTipo FROM tipoUser WHERE tipoUser.idTipo=OLD.idTipo INTO valorAnterior;
    SELECT tipoUser.nombreTipo FROM tipoUser WHERE tipoUser.idTipo=NEW.idTipo INTO valorNuevo;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Tipo de usuario', valorAnterior, valorNuevo);
  END IF;
  IF(NEW.Status<>OLD.Status)
  THEN
    IF(NEW.Status=1) THEN
      SET valorNuevo='Inactivo';
      SET valorAnterior='Activo';
    ELSE
      
      SET valorAnterior='Inactivo';
      SET valorNuevo='Activo';
    END IF;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, modulo, query, CONCAT('Usuario ',OLD.idUser,' - ',OLD.nickName),'Status de usuario', valorAnterior, valorNuevo);
  END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsuarioTipoContrato`
--

CREATE TABLE `UsuarioTipoContrato` (
  `idUsuario` int(11) NOT NULL DEFAULT '0',
  `idTipoContrato` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `UsuarioTipoContrato`
--

INSERT INTO `UsuarioTipoContrato` (`idUsuario`, `idTipoContrato`) VALUES
(1, 2),
(14, 2),
(16, 2),
(20, 2),
(33, 2),
(1, 3),
(16, 3),
(18, 3),
(19, 3),
(22, 3),
(23, 3),
(24, 3),
(26, 3),
(27, 3),
(28, 3),
(32, 3),
(33, 3),
(1, 5),
(14, 5),
(16, 5),
(18, 5),
(19, 5),
(22, 5),
(23, 5),
(24, 5),
(26, 5),
(27, 5),
(28, 5),
(32, 5),
(33, 5),
(1, 6),
(14, 6),
(16, 6),
(18, 6),
(19, 6),
(22, 6),
(23, 6),
(26, 6),
(27, 6),
(33, 6),
(1, 7),
(16, 7),
(18, 7),
(19, 7),
(22, 7),
(23, 7),
(24, 7),
(26, 7),
(27, 7),
(28, 7),
(32, 7),
(33, 7),
(1, 8),
(16, 8),
(18, 8),
(19, 8),
(22, 8),
(23, 8),
(24, 8),
(26, 8),
(27, 8),
(32, 8),
(33, 8);

--
-- Disparadores `UsuarioTipoContrato`
--
DELIMITER $$
CREATE TRIGGER `UsuarioTipoContrato_delete` AFTER DELETE ON `UsuarioTipoContrato` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreUser VARCHAR(50);
    DECLARE nombreContrato VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=21;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT Usuarios.nickName FROM Usuarios WHERE Usuarios.idUser=OLD.idUsuario INTO nombreUser;
    SELECT tipoContrato.nombreTipo FROM tipoContrato WHERE tipoContrato.idTipoC = OLD.idTipoContrato INTO nombreContrato;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',OLD.idUsuario,' - ',nombreUser,' / Tipo de contrato ',OLD.idTipoContrato,' - ',nombreContrato), 'Liga Usuario-Tipo de contrato',CONCAT('Usuario ',nombreUser,' - Tipo de contrato ',nombreContrato),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UsuarioTipoContrato_insert` AFTER INSERT ON `UsuarioTipoContrato` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreUser VARCHAR(50);
  DECLARE nombreContrato VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=21;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT Usuarios.nickName FROM Usuarios WHERE Usuarios.idUser=NEW.idUsuario INTO nombreUser;
  SELECT tipoContrato.nombreTipo FROM tipoContrato WHERE tipoContrato.idTipoC = NEW.idTipoContrato INTO nombreContrato;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto,columna, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Usuario ',NEW.idUsuario,' - ',nombreUser,' / Tipo de contrato ',NEW.idTipoContrato,' - ',nombreContrato), 'Liga Usuario-Tipo de contrato','', CONCAT('Usuario ',nombreUser,' - Tipo de contrato ',nombreContrato));
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Versiones_Contrato`
--

CREATE TABLE `Versiones_Contrato` (
  `idVersionContrato` int(11) NOT NULL,
  `idContratoProyecto` int(11) NOT NULL,
  `archivo` varchar(150) NOT NULL,
  `final` int(11) NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Versiones_Contrato`
--

INSERT INTO `Versiones_Contrato` (`idVersionContrato`, `idContratoProyecto`, `archivo`, `final`, `observaciones`) VALUES
(1, 8, '/82d5d1fbc1f25ebbb52ac3ac79c9aef6.docx', 0, 'La primera versión'),
(2, 8, '/daad798e785a9c7125033ffed290891a.pdf', 1, '');

--
-- Disparadores `Versiones_Contrato`
--
DELIMITER $$
CREATE TRIGGER `Versiones_Contrato_delete` AFTER DELETE ON `Versiones_Contrato` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    DECLARE idNewProyecto VARCHAR(50);
    DECLARE nomenclaturaContrato VARCHAR(50);
    SET query='Eliminación';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=10;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT contratoProyecto.nomenclatura FROM contratoProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nomenclaturaContrato;
    SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nombreProyecto;
    SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO idNewProyecto;
    INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
    VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Redición ', OLD.idVersionContrato),CONCAT('Redición ',OLD.idVersionContrato),'');
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Versiones_Contrato_insert` AFTER INSERT ON `Versiones_Contrato` FOR EACH ROW BEGIN
  DECLARE idUsuarioCambio INT;
  DECLARE fecha DATE;
  DECLARE hora TIME;
  DECLARE module INT;
  DECLARE query VARCHAR(20);
  DECLARE nombreProyecto VARCHAR(50);
  DECLARE idNewProyecto VARCHAR(50);
  DECLARE nomenclaturaContrato VARCHAR(50);
  SET query='Alta';
  SET fecha=CURRENT_DATE();
  SET hora=CURRENT_TIME();
  SET module=10;
  SELECT @idUsuarioCambio INTO idUsuarioCambio;
  SELECT contratoProyecto.nomenclatura FROM contratoProyecto WHERE contratoProyecto.idContratoProyecto=NEW.idContratoProyecto INTO nomenclaturaContrato;
  SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=NEW.idContratoProyecto INTO nombreProyecto;
  SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=NEW.idContratoProyecto INTO idNewProyecto;
  INSERT INTO Bitacora(idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, antes, despues)
  VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',NEW.idContratoProyecto,' - ',nomenclaturaContrato,' / Redición ', NEW.idVersionContrato),'', CONCAT('Redición ',NEW.idVersionContrato));
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Versiones_Contrato_update` AFTER UPDATE ON `Versiones_Contrato` FOR EACH ROW BEGIN
    DECLARE idUsuarioCambio INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    DECLARE module INT;
    DECLARE query VARCHAR(20);
    DECLARE nombreProyecto VARCHAR(50);
    DECLARE idNewProyecto VARCHAR(50);
    DECLARE nomenclaturaContrato VARCHAR(50);
    DECLARE valorAnterior VARCHAR(300);
    DECLARE valorNuevo VARCHAR(300);
    SET query='Actualización';
    SET fecha=CURRENT_DATE();
    SET hora=CURRENT_TIME();
    SET module=10;
    SELECT @idUsuarioCambio INTO idUsuarioCambio;
    SELECT contratoProyecto.nomenclatura FROM contratoProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nomenclaturaContrato;
    SELECT proyecto.nombreProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO nombreProyecto;
    SELECT proyecto.idProyecto FROM contratoProyecto JOIN proyecto ON proyecto.idProyecto=contratoProyecto.idProyecto WHERE contratoProyecto.idContratoProyecto=OLD.idContratoProyecto INTO idNewProyecto;
    IF (NEW.observaciones <> OLD.observaciones)
    THEN
      SET valorNuevo = NEW.observaciones;
      SET valorAnterior = OLD.observaciones;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Redición ', OLD.idVersionContrato),'Observaciones',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.archivo <> OLD.archivo)
    THEN
      SET valorNuevo = NEW.archivo;
      SET valorAnterior = OLD.archivo;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Redición ', OLD.idVersionContrato),'Archivo',valorAnterior, valorNuevo);
    END IF;
    IF (NEW.final <> OLD.final)
    THEN
      IF(NEW.final =1)
      THEN
        SET valorNuevo = 'Si';
        SET valorAnterior = 'No';
      ELSE
        SET valorNuevo = 'No';
        SET valorAnterior = 'Si';
      END IF ;
      INSERT INTO Bitacora (idUsuario, fechaAccion, horaAccion, idModulo, accion, texto, columna, antes, despues)
      VALUES (idUsuarioCambio, fecha, hora, module, query, CONCAT('Proyecto ',idNewProyecto,' - ',nombreProyecto,' / Contrato de proyecto ',OLD.idContratoProyecto,' - ',nomenclaturaContrato,' / Redición ', OLD.idVersionContrato),'¿Redición final?',valorAnterior, valorNuevo);
    END IF;
  END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idArea`);

--
-- Indices de la tabla `Bitacora`
--
ALTER TABLE `Bitacora`
  ADD PRIMARY KEY (`idBitacora`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idModulo` (`idModulo`);

--
-- Indices de la tabla `CatalogoFianzas`
--
ALTER TABLE `CatalogoFianzas`
  ADD PRIMARY KEY (`idCatalogoFianza`);

--
-- Indices de la tabla `ClienteDocumento`
--
ALTER TABLE `ClienteDocumento`
  ADD PRIMARY KEY (`idClienteDocumento`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `Contrato`
--
ALTER TABLE `Contrato`
  ADD PRIMARY KEY (`idContrato`);

--
-- Indices de la tabla `contratoProyecto`
--
ALTER TABLE `contratoProyecto`
  ADD PRIMARY KEY (`idContratoProyecto`),
  ADD KEY `status` (`status`),
  ADD KEY `foreanea_contratos_proyectos` (`idProyecto`),
  ADD KEY `foreanea_tiposContrato` (`idTipoContrato`),
  ADD KEY `usuarioFK` (`idSolicitante`);

--
-- Indices de la tabla `DocumentoEmpresaInterna`
--
ALTER TABLE `DocumentoEmpresaInterna`
  ADD PRIMARY KEY (`idDocumentoEmpresa`),
  ADD KEY `idEmpresaInterna` (`idEmpresaInterna`);

--
-- Indices de la tabla `DocumentosUsuario`
--
ALTER TABLE `DocumentosUsuario`
  ADD PRIMARY KEY (`idDocumentoUser`),
  ADD KEY `idUser` (`idUser`) USING BTREE;

--
-- Indices de la tabla `Empresa`
--
ALTER TABLE `Empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `empresainterna`
--
ALTER TABLE `empresainterna`
  ADD PRIMARY KEY (`idEmpresaInterna`);

--
-- Indices de la tabla `FianzaDocumento`
--
ALTER TABLE `FianzaDocumento`
  ADD PRIMARY KEY (`idFianzaDocumento`),
  ADD KEY `FianzaDocumento_Fianzas_idFianza_fk` (`idFianza`);

--
-- Indices de la tabla `Fianzas`
--
ALTER TABLE `Fianzas`
  ADD PRIMARY KEY (`idFianza`),
  ADD KEY `idContratoProyecto` (`idContratoProyecto`),
  ADD KEY `idCatalogoFianza` (`idCatalogoFianza`);

--
-- Indices de la tabla `Modulo`
--
ALTER TABLE `Modulo`
  ADD PRIMARY KEY (`idModulo`);

--
-- Indices de la tabla `Permiso`
--
ALTER TABLE `Permiso`
  ADD PRIMARY KEY (`idTipoUsuario`,`idModulo`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`idProyecto`),
  ADD KEY `idEmpresaInterna` (`idEmpresaInterna`);

--
-- Indices de la tabla `StatusContratos`
--
ALTER TABLE `StatusContratos`
  ADD PRIMARY KEY (`idStatusContrato`);

--
-- Indices de la tabla `tipoContrato`
--
ALTER TABLE `tipoContrato`
  ADD PRIMARY KEY (`idTipoC`),
  ADD KEY `idContrato` (`idContrato`);

--
-- Indices de la tabla `tipoUser`
--
ALTER TABLE `tipoUser`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `UsuarioEmpresa`
--
ALTER TABLE `UsuarioEmpresa`
  ADD PRIMARY KEY (`idUsuario`,`idEmpresaInterna`),
  ADD KEY `idEmpresaInterna` (`idEmpresaInterna`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idTipo` (`idTipo`);

--
-- Indices de la tabla `UsuarioTipoContrato`
--
ALTER TABLE `UsuarioTipoContrato`
  ADD PRIMARY KEY (`idUsuario`,`idTipoContrato`),
  ADD KEY `idTipoContrato` (`idTipoContrato`);

--
-- Indices de la tabla `Versiones_Contrato`
--
ALTER TABLE `Versiones_Contrato`
  ADD PRIMARY KEY (`idVersionContrato`),
  ADD KEY `idContratoProyecto` (`idContratoProyecto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `Bitacora`
--
ALTER TABLE `Bitacora`
  MODIFY `idBitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=563;

--
-- AUTO_INCREMENT de la tabla `CatalogoFianzas`
--
ALTER TABLE `CatalogoFianzas`
  MODIFY `idCatalogoFianza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ClienteDocumento`
--
ALTER TABLE `ClienteDocumento`
  MODIFY `idClienteDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `Contrato`
--
ALTER TABLE `Contrato`
  MODIFY `idContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `contratoProyecto`
--
ALTER TABLE `contratoProyecto`
  MODIFY `idContratoProyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `DocumentoEmpresaInterna`
--
ALTER TABLE `DocumentoEmpresaInterna`
  MODIFY `idDocumentoEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `DocumentosUsuario`
--
ALTER TABLE `DocumentosUsuario`
  MODIFY `idDocumentoUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Empresa`
--
ALTER TABLE `Empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `empresainterna`
--
ALTER TABLE `empresainterna`
  MODIFY `idEmpresaInterna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `FianzaDocumento`
--
ALTER TABLE `FianzaDocumento`
  MODIFY `idFianzaDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Fianzas`
--
ALTER TABLE `Fianzas`
  MODIFY `idFianza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `Modulo`
--
ALTER TABLE `Modulo`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `idProyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `StatusContratos`
--
ALTER TABLE `StatusContratos`
  MODIFY `idStatusContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipoContrato`
--
ALTER TABLE `tipoContrato`
  MODIFY `idTipoC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipoUser`
--
ALTER TABLE `tipoUser`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `Versiones_Contrato`
--
ALTER TABLE `Versiones_Contrato`
  MODIFY `idVersionContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Bitacora`
--
ALTER TABLE `Bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`idUser`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bitacora_ibfk_2` FOREIGN KEY (`idModulo`) REFERENCES `Modulo` (`idModulo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ClienteDocumento`
--
ALTER TABLE `ClienteDocumento`
  ADD CONSTRAINT `clientedocumento_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contratoProyecto`
--
ALTER TABLE `contratoProyecto`
  ADD CONSTRAINT `contratoProyecto_ibfk_1` FOREIGN KEY (`status`) REFERENCES `StatusContratos` (`idStatusContrato`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `foreanea_contratos_proyectos` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreanea_tiposContrato` FOREIGN KEY (`idTipoContrato`) REFERENCES `tipoContrato` (`idTipoC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioFK` FOREIGN KEY (`idSolicitante`) REFERENCES `Usuarios` (`idUser`);

--
-- Filtros para la tabla `DocumentoEmpresaInterna`
--
ALTER TABLE `DocumentoEmpresaInterna`
  ADD CONSTRAINT `documentoempresainterna_ibfk_1` FOREIGN KEY (`idEmpresaInterna`) REFERENCES `empresainterna` (`idEmpresaInterna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `FianzaDocumento`
--
ALTER TABLE `FianzaDocumento`
  ADD CONSTRAINT `FianzaDocumento_ibfk_1` FOREIGN KEY (`idFianza`) REFERENCES `Fianzas` (`idFianza`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Fianzas`
--
ALTER TABLE `Fianzas`
  ADD CONSTRAINT `Fianzas_ibfk_1` FOREIGN KEY (`idContratoProyecto`) REFERENCES `contratoProyecto` (`idContratoProyecto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fianzas_ibfk_2` FOREIGN KEY (`idCatalogoFianza`) REFERENCES `CatalogoFianzas` (`idCatalogoFianza`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`idEmpresaInterna`) REFERENCES `empresainterna` (`idEmpresaInterna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipoContrato`
--
ALTER TABLE `tipoContrato`
  ADD CONSTRAINT `tipoContrato_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `Contrato` (`idContrato`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `UsuarioEmpresa`
--
ALTER TABLE `UsuarioEmpresa`
  ADD CONSTRAINT `usuarioempresa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioempresa_ibfk_2` FOREIGN KEY (`idEmpresaInterna`) REFERENCES `empresainterna` (`idEmpresaInterna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `UsuarioTipoContrato`
--
ALTER TABLE `UsuarioTipoContrato`
  ADD CONSTRAINT `UsuarioTipoContrato_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UsuarioTipoContrato_ibfk_2` FOREIGN KEY (`idTipoContrato`) REFERENCES `tipoContrato` (`idTipoC`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
