-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Apr 27, 2025 alle 16:45
-- Versione del server: 9.1.0
-- Versione PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noleggioauto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `auto`
--

DROP TABLE IF EXISTS `auto`;
CREATE TABLE IF NOT EXISTS `auto` (
  `targa` varchar(10) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modello` varchar(50) DEFAULT NULL,
  `costo_giornaliero` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`targa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `auto`
--

INSERT INTO `auto` (`targa`, `marca`, `modello`, `costo_giornaliero`) VALUES
('AB123CD', 'Fiat', 'Panda', 30.00),
('EF456GH', 'Ford', 'Fiesta', 35.00),
('IJ789KL', 'Volkswagen', 'Golf', 45.00),
('MN012OP', 'Toyota', 'Yaris', 40.00),
('QR345ST', 'Renault', 'Clio', 38.00),
('UV678WX', 'Peugeot', '208', 36.00),
('YZ901AB', 'BMW', 'Serie 1', 55.00),
('CD234EF', 'Audi', 'A3', 60.00),
('GH567IJ', 'Hyundai', 'i20', 34.00),
('KL890MN', 'Kia', 'Rio', 33.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `noleggi`
--

DROP TABLE IF EXISTS `noleggi`;
CREATE TABLE IF NOT EXISTS `noleggi` (
  `codice_noleggio` int NOT NULL AUTO_INCREMENT,
  `auto` varchar(10) DEFAULT NULL,
  `socio` char(16) DEFAULT NULL,
  `inizio` date DEFAULT NULL,
  `fine` date DEFAULT NULL,
  `auto_restituita` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`codice_noleggio`),
  KEY `auto` (`auto`),
  KEY `socio` (`socio`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `noleggi`
--

INSERT INTO `noleggi` (`codice_noleggio`, `auto`, `socio`, `inizio`, `fine`, `auto_restituita`) VALUES
(1, 'AB123CD', 'RSSMRA90A01H501U', '2025-03-01', '2025-03-03', 1),
(2, 'EF456GH', 'VRDLGI85B15F205X', '2025-02-15', '2025-02-20', 1),
(3, 'IJ789KL', 'BNCLRA92C20L219P', '2025-04-01', '2025-04-05', 1),
(4, 'MN012OP', 'FRNGPP80D10M072Y', '2025-03-20', '2025-03-22', 1),
(5, 'QR345ST', 'NRLPLA95E05C351Q', '2025-03-05', '2025-03-08', 1),
(6, 'UV678WX', 'RBLFNC88F22H703Z', '2025-04-05', '2025-04-10', 1),
(7, 'YZ901AB', 'MTTGLC93G17H224U', '2025-03-10', '2025-03-12', 1),
(8, 'CD234EF', 'BLNSRA91H30L219K', '2025-02-28', '2025-03-02', 1),
(9, 'GH567IJ', 'TRRFNC84I08M126H', '2025-04-03', '2025-04-06', 1),
(10, 'KL890MN', 'LNCCRL89L22G273R', '2025-03-18', '2025-03-20', 1),
(11, 'AB123CD', 'DGRMLSML06', '2025-04-26', '2025-04-30', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `soci`
--

DROP TABLE IF EXISTS `soci`;
CREATE TABLE IF NOT EXISTS `soci` (
  `CF` char(16) NOT NULL,
  `cognome` varchar(50) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `indirizzo` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`CF`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `soci`
--

INSERT INTO `soci` (`CF`, `cognome`, `nome`, `indirizzo`, `telefono`) VALUES
('RSSMRA90A01H501U', 'Rossi', 'Mario', 'Via Roma 1, Milano', '3201234567'),
('VRDLGI85B15F205X', 'Verdi', 'Luigi', 'Via Verdi 2, Torino', '3349876543'),
('BNCLRA92C20L219P', 'Bianchi', 'Laura', 'Corso Italia 3, Napoli', '3274567890'),
('FRNGPP80D10M072Y', 'Ferrini', 'Giapiero', 'Viale Libertà 4, Firenze', '3287654321'),
('NRLPLA95E05C351Q', 'Neri', 'Paola', 'Piazza Duomo 5, Roma', '3291122334'),
('RBLFNC88F22H703Z', 'Rubini', 'Francesca', 'Via Manzoni 6, Palermo', '3214455667'),
('MTTGLC93G17H224U', 'Mattioli', 'Giacomo', 'Via Dante 7, Bologna', '3389988776'),
('BLNSRA91H30L219K', 'Bellini', 'Sara', 'Via Venezia 8, Verona', '3337778889'),
('TRRFNC84I08M126H', 'Torre', 'Francesco', 'Via Trieste 9, Genova', '3376655443'),
('LNCCRL89L22G273R', 'Longhi', 'Carlo', 'Viale Marconi 10, Bari', '3392211334');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
