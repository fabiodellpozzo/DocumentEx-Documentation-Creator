-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 31-Ago-2025 às 21:30
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
-- Banco de dados: `modulo-link-sublink`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_modulo` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_modulo` (`id_modulo`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `id_modulo`) VALUES
(1, 'categoria filha modulo 1', 1),
(2, 'categoria 2', 3),
(3, 'categoria 1 - modulo 4', 5),
(4, 'categoria 2 modulo 4', 5),
(5, 'categoria 3 modulo 4', 5),
(6, 'bbbb', 6),
(7, 'nnnn', 7),
(8, 'hhhhh', 8),
(9, 'asasasas', 9),
(10, 'asasaasasasa', 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `modulos`
--

INSERT INTO `modulos` (`id`, `nome`) VALUES
(1, 'modulo 1'),
(2, 'modulo'),
(3, 'modulo 2'),
(4, 'modulo 3'),
(5, 'modulo 4'),
(6, 'aaa'),
(7, 'nnn'),
(8, 'dddd'),
(9, 'asasas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

DROP TABLE IF EXISTS `registros`;
CREATE TABLE IF NOT EXISTS `registros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `conteudo` text,
  `id_modulo` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `id_subcategoria` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo` (`titulo`),
  KEY `id_modulo` (`id_modulo`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_subcategoria` (`id_subcategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `registros`
--

INSERT INTO `registros` (`id`, `titulo`, `conteudo`, `id_modulo`, `id_categoria`, `id_subcategoria`) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, 'registro 1', 'registro 1', 1, 1, 1),
(3, 'registro 2', 'modulo 2 - categoria 2 - subcategoria 2', 3, 2, 2),
(4, 'registro 3', 'modulo 2 - categoria 2 - subcategoria 2', 1, 1, 1),
(5, 'registro 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae varius turpis. Suspendisse condimentum massa in justo interdum efficitur. Aliquam ex quam, auctor eget sollicitudin at, viverra nec enim. Proin fermentum consectetur est, nec facilisis magna viverra quis. Suspendisse volutpat semper nibh non euismod. Nam aliquam eros ut eros iaculis efficitur. Nam feugiat eu ipsum vel rutrum. Suspendisse eget augue tempus, blandit est a, maximus nisi. Curabitur eleifend, est id luctus dictum, eros ligula pulvinar enim, nec vestibulum lorem sem et nisi. Morbi dolor justo, tincidunt eu ligula ut, tristique cursus augue.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor, orci eget congue dignissim, eros nibh semper nisl, nec dapibus risus libero vel eros. Etiam ultricies ornare vulputate. Phasellus et aliquam elit, in eleifend turpis. Donec ac purus in tellus sagittis tempus quis luctus nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec a ante in sapien sagittis luctus. Suspendisse id tellus eros. Curabitur sed posuere lectus. Proin pharetra nisl odio, non dignissim enim dapibus id. Vivamus efficitur orci non ultrices posuere.', 1, 1, 1),
(6, 'Conteudo modulo 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae varius turpis. Suspendisse condimentum massa in justo interdum efficitur. Aliquam ex quam, auctor eget sollicitudin at, viverra nec enim. Proin fermentum consectetur est, nec facilisis magna viverra quis. Suspendisse volutpat semper nibh non euismod. Nam aliquam eros ut eros iaculis efficitur. Nam feugiat eu ipsum vel rutrum. Suspendisse eget augue tempus, blandit est a, maximus nisi. Curabitur eleifend, est id luctus dictum, eros ligula pulvinar enim, nec vestibulum lorem sem et nisi. Morbi dolor justo, tincidunt eu ligula ut, tristique cursus augue.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor, orci eget congue dignissim, eros nibh semper nisl, nec dapibus risus libero vel eros. Etiam ultricies ornare vulputate. Phasellus et aliquam elit, in eleifend turpis. Donec ac purus in tellus sagittis tempus quis luctus nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec a ante in sapien sagittis luctus. Suspendisse id tellus eros. Curabitur sed posuere lectus. Proin pharetra nisl odio, non dignissim enim dapibus id. Vivamus efficitur orci non ultrices posuere.\r\n\r\nNam elementum dui id eros volutpat, eu accumsan dolor pharetra. Suspendisse euismod consequat venenatis. Etiam leo mi, commodo eget diam ac, eleifend ornare sapien. Donec in ligula a leo rutrum laoreet a nec libero. Etiam ultrices iaculis vestibulum. Maecenas vitae venenatis tortor. Nunc non scelerisque ligula. Proin quam lectus, bibendum vel consequat in, efficitur quis nulla.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut nec egestas urna. Donec sed ante urna. In et egestas erat. Curabitur sed turpis velit. Nam pellentesque, urna interdum faucibus sagittis, justo felis vestibulum mauris, nec pellentesque elit ante quis dolor. Nullam blandit lacinia interdum. Nullam eu rutrum nulla. Vivamus sodales sodales euismod. Vestibulum quis nulla dictum, consectetur tortor sit amet, tempor metus. Donec dignissim in enim nec condimentum. Sed et sem sit amet dolor scelerisque tempus. Vestibulum laoreet lobortis leo, ut sagittis neque ultricies at.\r\n\r\nIn hac habitasse platea dictumst. Integer fringilla varius quam, nec cursus massa eleifend eget. Mauris tincidunt sollicitudin ligula sed tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis euismod nibh id metus eleifend, in semper odio dignissim. Praesent sed quam sit amet odio iaculis lobortis quis non ex. Proin sollicitudin neque at ligula lacinia, in facilisis mi vehicula.', 5, 3, 3),
(7, 'Conteudo 2 modulo 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae varius turpis. Suspendisse condimentum massa in justo interdum efficitur. Aliquam ex quam, auctor eget sollicitudin at, viverra nec enim. Proin fermentum consectetur est, nec facilisis magna viverra quis. Suspendisse volutpat semper nibh non euismod. Nam aliquam eros ut eros iaculis efficitur. Nam feugiat eu ipsum vel rutrum. Suspendisse eget augue tempus, blandit est a, maximus nisi. Curabitur eleifend, est id luctus dictum, eros ligula pulvinar enim, nec vestibulum lorem sem et nisi. Morbi dolor justo, tincidunt eu ligula ut, tristique cursus augue.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor, orci eget congue dignissim, eros nibh semper nisl, nec dapibus risus libero vel eros. Etiam ultricies ornare vulputate. Phasellus et aliquam elit, in eleifend turpis. Donec ac purus in tellus sagittis tempus quis luctus nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec a ante in sapien sagittis luctus. Suspendisse id tellus eros. Curabitur sed posuere lectus. Proin pharetra nisl odio, non dignissim enim dapibus id. Vivamus efficitur orci non ultrices posuere.\r\n\r\nNam elementum dui id eros volutpat, eu accumsan dolor pharetra. Suspendisse euismod consequat venenatis. Etiam leo mi, commodo eget diam ac, eleifend ornare sapien. Donec in ligula a leo rutrum laoreet a nec libero. Etiam ultrices iaculis vestibulum. Maecenas vitae venenatis tortor. Nunc non scelerisque ligula. Proin quam lectus, bibendum vel consequat in, efficitur quis nulla.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut nec egestas urna. Donec sed ante urna. In et egestas erat. Curabitur sed turpis velit. Nam pellentesque, urna interdum faucibus sagittis, justo felis vestibulum mauris, nec pellentesque elit ante quis dolor. Nullam blandit lacinia interdum. Nullam eu rutrum nulla. Vivamus sodales sodales euismod. Vestibulum quis nulla dictum, consectetur tortor sit amet, tempor metus. Donec dignissim in enim nec condimentum. Sed et sem sit amet dolor scelerisque tempus. Vestibulum laoreet lobortis leo, ut sagittis neque ultricies at.\r\n\r\nIn hac habitasse platea dictumst. Integer fringilla varius quam, nec cursus massa eleifend eget. Mauris tincidunt sollicitudin ligula sed tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis euismod nibh id metus eleifend, in semper odio dignissim. Praesent sed quam sit amet odio iaculis lobortis quis non ex. Proin sollicitudin neque at ligula lacinia, in facilisis mi vehicula.', 5, 3, 4),
(8, 'ttttt', 'ttttt', 1, 1, 1),
(9, 'grgrgrgr', 'rgrgrgrg', 7, 7, 7),
(10, 'frfrffrfrf', 'frfrfrff', 5, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
CREATE TABLE IF NOT EXISTS `subcategorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `nome`, `id_categoria`) VALUES
(1, 'subcategoria herdeira de categoria filha modulo 1', 1),
(2, 'subcategoria 2', 2),
(3, 'subcategoria 1.1 modulo 4', 3),
(4, 'subcategoria 1.2 - modulo 4', 3),
(5, 'mmmmm', 7),
(6, 'kkkkk', 8),
(7, 'jjjjj', 7);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
