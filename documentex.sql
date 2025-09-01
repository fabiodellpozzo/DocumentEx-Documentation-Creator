-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01-Set-2025 às 05:57
-- Versão do servidor: 9.1.0
-- versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `documentex`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_modulo` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_modulo` (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

DROP TABLE IF EXISTS `registros`;
CREATE TABLE IF NOT EXISTS `registros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `conteudo` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_modulo` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `id_subcategoria` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_modulo` (`id_modulo`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_subcategoria` (`id_subcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `registros`
--

INSERT INTO `registros` (`id`, `titulo`, `conteudo`, `id_modulo`, `id_categoria`, `id_subcategoria`) VALUES
(1, 'grgrg', 'rgrh', NULL, NULL, NULL),
(2, 'jjj', 'jjj', NULL, NULL, NULL),
(3, 'A 1 1.1', 'A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1A 1 1.1', NULL, NULL, NULL),
(4, 'DDD', 'DDD', NULL, NULL, NULL),
(5, 'VVV', 'VVV', NULL, NULL, NULL),
(6, 'rrr', 'rr', NULL, NULL, NULL),
(7, 'teste teste teste', 'ddd', NULL, NULL, NULL),
(8, 'fff', 'ff', NULL, NULL, NULL),
(9, '4.1.1', '4.1.14.1.14.1.14.1.14.1.1', NULL, NULL, NULL),
(10, 'ggggg', 'ggg', NULL, NULL, NULL),
(11, 'gggg', 'gggg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
CREATE TABLE IF NOT EXISTS `subcategorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_categoria` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `registros_ibfk_3` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategorias` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
