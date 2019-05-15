-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 15-Maio-2019 às 16:19
-- Versão do servidor: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efarm`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdsadm`
--

DROP TABLE IF EXISTS `tblcdsadm`;
CREATE TABLE IF NOT EXISTS `tblcdsadm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data` date DEFAULT NULL,
  `opAdm` int(2) NOT NULL,
  `opCat` int(2) NOT NULL,
  `opCoo` int(2) NOT NULL,
  `opFor` int(2) NOT NULL,
  `opOrc` int(2) NOT NULL,
  `opPed` int(2) NOT NULL,
  `opProd` int(2) NOT NULL,
  `opProf` int(2) NOT NULL,
  `opRel` int(2) NOT NULL,
  `opUne` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdsadm`
--

INSERT INTO `tblcdsadm` (`id`, `nome`, `email`, `senha`, `data`, `opAdm`, `opCat`, `opCoo`, `opFor`, `opOrc`, `opPed`, `opProd`, `opProf`, `opRel`, `opUne`) VALUES
(1, 'Paulo Santiago', 'profa@hotmail.com', '$2y$10$bea9jFTyWEZFOTmE.5MNY.ActEGxJM4dPn5eFFERd6eqRPQHTeyBq', '2019-04-25', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(6, 'Paulo Guilherme Santiago', 'profpgs@gmail.com', '$2y$10$ZHVSokqZZt65goOhfw8YWuNKavSBvmhJ.lTgot2Mhv4YyHZVx87XO', '2019-05-10', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdscat`
--

DROP TABLE IF EXISTS `tblcdscat`;
CREATE TABLE IF NOT EXISTS `tblcdscat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdscat`
--

INSERT INTO `tblcdscat` (`id`, `titulo`, `slug`) VALUES
(2, 'Medicamentos', 'medicamentos'),
(3, 'Alimentos animais', 'alimentos'),
(4, 'Cortes de lavoura', 'cortes-de-lavoura'),
(5, 'Oleos e Filtros', 'oleos-e-filtros'),
(6, 'Ferragens e ferramentas', 'ferragens-e-ferramentas'),
(7, 'Aferições Ordenhadeiras', 'afericoes-ordenhadeiras'),
(8, 'Materiais hidráulicos', 'materiais-hidraulicos'),
(9, 'EPIS', 'epis'),
(10, 'Materiais de construção', 'materiais-de-construcao'),
(11, 'Colheitas de grãos', 'colheitas-de-graos'),
(12, 'Exames e Vacinas', 'exames-e-vacinas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdscor`
--

DROP TABLE IF EXISTS `tblcdscor`;
CREATE TABLE IF NOT EXISTS `tblcdscor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdscor`
--

INSERT INTO `tblcdscor` (`id`, `nome`) VALUES
(1, 'COEXP'),
(2, 'COAGR'),
(3, 'COZOO'),
(4, 'COENF'),
(5, 'COSEG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdsfor`
--

DROP TABLE IF EXISTS `tblcdsfor`;
CREATE TABLE IF NOT EXISTS `tblcdsfor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cnpj` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdspag`
--

DROP TABLE IF EXISTS `tblcdspag`;
CREATE TABLE IF NOT EXISTS `tblcdspag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdspag`
--

INSERT INTO `tblcdspag` (`id`, `titulo`, `slug`) VALUES
(1, 'Home', ''),
(2, 'Loja de pedidos', 'loja');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdsprod`
--

DROP TABLE IF EXISTS `tblcdsprod`;
CREATE TABLE IF NOT EXISTS `tblcdsprod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_padrao` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `subcategoria` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `valor_anterior` decimal(10,2) NOT NULL,
  `valor_atual` decimal(10,2) NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `peso` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `estoque` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdsprod`
--

INSERT INTO `tblcdsprod` (`id`, `img_padrao`, `titulo`, `slug`, `categoria`, `subcategoria`, `valor_anterior`, `valor_atual`, `descricao`, `peso`, `estoque`, `data`) VALUES
(1, '812d046b118980c5aa1cbec1b58fa4e6duas-folhas-png-5.png', 'Folhas1', 'folhas1', 'medicamentos', 'VER SUBCATEGORIA', '1.00', '1.00', '11', '34', -38, '2019-04-13'),
(2, '059c6444e7006d5b5d6399ee27f2242cproduct01.png', 'notebook', 'notebook', 'exames-e-vacinas', 'EM PRODUCAO', '1500.00', '1300.00', 'notebook top', '2,3', 100, '2019-05-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdsprof`
--

DROP TABLE IF EXISTS `tblcdsprof`;
CREATE TABLE IF NOT EXISTS `tblcdsprof` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `data` date DEFAULT NULL,
  `tipo_usuario` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdsprof`
--

INSERT INTO `tblcdsprof` (`id`, `nome`, `email`, `senha`, `data`, `tipo_usuario`) VALUES
(8, 'Paulao Guilherme Santiago', 'profp@gmal.com', '$2y$10$izHFqgSNHyEdmiJLx5B/HeBHwUqzas81tqbwryJ4hIOPFanl6Y7nK', '2019-05-13', 0),
(7, 'Paulo Guilherme Santiago', 'profpgs@gmail.com', '$2y$10$FFX9pJlrs5XqBlpCcw5QgO/jjNg2F4pdnIaVrptukfovXwytnP7ju', '2019-05-13', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcdsune`
--

DROP TABLE IF EXISTS `tblcdsune`;
CREATE TABLE IF NOT EXISTS `tblcdsune` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `coordenacao` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcdsune`
--

INSERT INTO `tblcdsune` (`id`, `nome`, `coordenacao`) VALUES
(1, 'TESTE', 'COEXP'),
(2, 'TESTE', 'COAGR');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblmvmped`
--

DROP TABLE IF EXISTS `tblmvmped`;
CREATE TABLE IF NOT EXISTS `tblmvmped` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prof` int(11) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `coordenacao` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `unepe` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `criado` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblmvmped`
--

INSERT INTO `tblmvmped` (`id`, `id_prof`, `valor_total`, `coordenacao`, `unepe`, `status`, `criado`) VALUES
(4, 7, '1.00', 'COENF', 'TESTE', 0, '2019-05-02'),
(3, 7, '1.00', 'COZOO', 'TESTE', 1, '2019-04-29'),
(5, 7, '10.00', 'COENF', 'TESTE', 1, '2019-05-08'),
(6, 7, '10.00', 'COENF', 'TESTE', 0, '2019-05-08'),
(7, 7, '1.00', 'COENF', 'TESTE', 0, '2019-05-10'),
(8, 7, '1.00', 'COAGR', 'TESTE', 0, '2019-05-11'),
(9, 7, '1.00', 'COZOO', 'TESTE', 0, '2019-05-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblmvmprodped`
--

DROP TABLE IF EXISTS `tblmvmprodped`;
CREATE TABLE IF NOT EXISTS `tblmvmprodped` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL,
  `coordenacao` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `unepe` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblmvmprodped`
--

INSERT INTO `tblmvmprodped` (`id`, `id_pedido`, `id_produto`, `qtd`, `coordenacao`, `unepe`) VALUES
(4, 4, 1, 1, 'COENF', 'TESTE'),
(3, 3, 1, 9, 'COZOO', 'TESTE'),
(5, 5, 1, 10, 'COENF', 'TESTE'),
(6, 6, 1, 10, 'COENF', 'TESTE'),
(7, 7, 1, 1, 'COENF', 'TESTE'),
(8, 8, 1, 1, 'COAGR', 'TESTE'),
(9, 9, 1, 1, 'COZOO', 'TESTE');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
