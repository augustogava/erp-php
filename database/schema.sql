-- Sistema ERP - Database Schema
-- MySQL Database
-- Created from project analysis

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8;

CREATE DATABASE IF NOT EXISTS `erp_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `erp_db`;

-- --------------------------------------------------------
-- Core Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `apelido_fat` varchar(50) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `contato` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `end_fat` varchar(150) DEFAULT NULL,
  `bairro_fat` varchar(50) DEFAULT NULL,
  `estado_fat` int(11) DEFAULT NULL,
  `cidade_fat` varchar(50) DEFAULT NULL,
  `cep_fat` varchar(10) DEFAULT NULL,
  `apelido_ent1` varchar(50) DEFAULT NULL,
  `end_1` varchar(150) DEFAULT NULL,
  `bairro_1` varchar(50) DEFAULT NULL,
  `estado_1` int(11) DEFAULT NULL,
  `cidade_1` varchar(50) DEFAULT NULL,
  `cep_1` varchar(10) DEFAULT NULL,
  `apelido_ent2` varchar(50) DEFAULT NULL,
  `end_2` varchar(150) DEFAULT NULL,
  `bairro_2` varchar(50) DEFAULT NULL,
  `estado_2` int(11) DEFAULT NULL,
  `cidade_2` varchar(50) DEFAULT NULL,
  `cep_2` varchar(10) DEFAULT NULL,
  `apelido_ent3` varchar(50) DEFAULT NULL,
  `end_3` varchar(150) DEFAULT NULL,
  `bairro_3` varchar(50) DEFAULT NULL,
  `estado_3` int(11) DEFAULT NULL,
  `cidade_3` varchar(50) DEFAULT NULL,
  `cep_3` varchar(10) DEFAULT NULL,
  `apelido_ent4` varchar(50) DEFAULT NULL,
  `end_4` varchar(150) DEFAULT NULL,
  `bairro_4` varchar(50) DEFAULT NULL,
  `estado_4` int(11) DEFAULT NULL,
  `cidade_4` varchar(50) DEFAULT NULL,
  `cep_4` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `sigla` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `estado` (`id`, `nome`, `sigla`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amapá', 'AP'),
(4, 'Amazonas', 'AM'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Mato Grosso', 'MT'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Minas Gerais', 'MG'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Paraná', 'PR'),
(17, 'Pernambuco', 'PE'),
(18, 'Piauí', 'PI'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rio Grande do Sul', 'RS'),
(22, 'Rondônia', 'RO'),
(23, 'Roraima', 'RR'),
(24, 'Santa Catarina', 'SC'),
(25, 'São Paulo', 'SP'),
(26, 'Sergipe', 'SE'),
(27, 'Tocantins', 'TO');

-- --------------------------------------------------------
-- Access Control Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `niveis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `tipo` char(1) DEFAULT 'C',
  `menus` text,
  `submenus` text,
  `vendedor` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `niveis` (`id`, `nome`, `tipo`, `menus`, `submenus`, `vendedor`) VALUES
(1, 'Administrador', 'F', NULL, NULL, 1);

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `posicao` int(11) DEFAULT '0',
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `menus` (`id`, `texto`, `url`, `posicao`, `sit`) VALUES
(1, 'Dashboard', 'corpo.php', 1, 'A'),
(2, 'Cadastros', '#', 2, 'A'),
(3, 'Comercial', '#', 3, 'A'),
(4, 'Financeiro', '#', 4, 'A'),
(5, 'Estoque', '#', 5, 'A'),
(6, 'Relatórios', '#', 6, 'A'),
(7, 'Configurações', '#', 7, 'A');

CREATE TABLE IF NOT EXISTS `submenus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` int(11) NOT NULL,
  `texto` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `posicao` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(1, 2, 'Clientes', 'clientes.php', 1),
(2, 2, 'Fornecedores', 'fornecedores.php', 2),
(3, 2, 'Funcionários', 'funcionarios.php', 3),
(4, 2, 'Produtos/Serviços', 'prodserv.php', 4),
(5, 3, 'Vendas', 'vendas.php', 1),
(6, 3, 'Orçamentos', 'vendas_orc.php', 2),
(7, 3, 'Compras', 'compras.php', 3),
(8, 4, 'Contas a Pagar', 'cp.php', 1),
(9, 4, 'Contas a Receber', 'cr.php', 2),
(10, 4, 'Bancos', 'bancos.php', 3),
(11, 5, 'Estoque', 'prodserv_est.php', 1),
(12, 5, 'Ordens de Produção', 'prodserv_ordem.php', 2),
(13, 7, 'Empresa', 'empresa.php', 1),
(14, 7, 'Usuários', 'clientes_login.php', 2);

CREATE TABLE IF NOT EXISTS `cliente_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) DEFAULT NULL,
  `funcionario` int(11) DEFAULT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nivel` int(11) NOT NULL,
  `sit` char(1) DEFAULT 'A',
  `blok` tinyint(1) DEFAULT '0',
  `blok_externo` tinyint(1) DEFAULT '0',
  `primeiro` char(1) DEFAULT 'N',
  `perm` varchar(10) DEFAULT '4',
  `assinatura` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`),
  KEY `funcionario` (`funcionario`),
  KEY `nivel` (`nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cliente_login` (`id`, `cliente`, `funcionario`, `login`, `senha`, `nivel`, `sit`, `blok`, `blok_externo`, `primeiro`, `perm`) VALUES
(1, NULL, 1, 'admin', 'admin123', 1, 'A', 0, 0, 'N', '4');

-- --------------------------------------------------------
-- System Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `acessos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `bloquear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block` char(1) DEFAULT 'N',
  `externo` char(1) DEFAULT 'S',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bloquear` (`id`, `block`, `externo`) VALUES (1, 'N', 'S');

CREATE TABLE IF NOT EXISTS `externo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `local` varchar(100) DEFAULT NULL,
  `pagina` varchar(255) DEFAULT NULL,
  `acao` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Clients Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loja` varchar(20) DEFAULT NULL,
  `transportadora` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `fantasia` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `tipo` char(1) DEFAULT 'J',
  `endereco` varchar(150) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `ddd` varchar(5) DEFAULT NULL,
  `ddd2` varchar(5) DEFAULT NULL,
  `dddf` varchar(5) DEFAULT NULL,
  `fone` varchar(20) DEFAULT NULL,
  `fone2` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `im` varchar(20) DEFAULT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `comissao` decimal(10,2) DEFAULT '0.00',
  `regiao` varchar(50) DEFAULT NULL,
  `contabil` varchar(50) DEFAULT NULL,
  `banco1` varchar(50) DEFAULT NULL,
  `banco2` varchar(50) DEFAULT NULL,
  `banco3` varchar(50) DEFAULT NULL,
  `banco4` varchar(50) DEFAULT NULL,
  `banco5` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `porte_che` varchar(10) DEFAULT NULL,
  `porte_fun` varchar(10) DEFAULT NULL,
  `porte_fat` varchar(10) DEFAULT NULL,
  `ramo` int(11) DEFAULT NULL,
  `origem_cad` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `atualizacao` datetime DEFAULT NULL,
  `sit` char(1) DEFAULT '1',
  `atividade` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `estado` (`estado`),
  KEY `ramo` (`ramo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cliente_cobranca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cliente_entrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `endereco_ins` varchar(150) DEFAULT NULL,
  `bairro_ins` varchar(50) DEFAULT NULL,
  `cep_ins` varchar(10) DEFAULT NULL,
  `cidade_ins` varchar(50) DEFAULT NULL,
  `estado_ins` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cliente_financeiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `limite` decimal(10,2) DEFAULT '0.00',
  `prazo` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cliente_contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Employees Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cargo` int(11) DEFAULT NULL,
  `admissao` date DEFAULT NULL,
  `demissao` date DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `ctps` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `cargo` (`cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `funcionarios` (`id`, `nome`, `cargo`, `sit`) VALUES
(1, 'Administrador', NULL, 'A');

CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `funcionario_apontamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `entrada` time DEFAULT NULL,
  `saida` time DEFAULT NULL,
  `obs` text,
  PRIMARY KEY (`id`),
  KEY `funcionario` (`funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `funcionario_outros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `valor` text,
  PRIMARY KEY (`id`),
  KEY `funcionario` (`funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Suppliers Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `fantasia` varchar(100) DEFAULT NULL,
  `tipo` char(1) DEFAULT 'J',
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `contato` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `obs` text,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `fornecedor_financeiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fornecedor` int(11) NOT NULL,
  `banco` varchar(50) DEFAULT NULL,
  `agencia` varchar(20) DEFAULT NULL,
  `conta` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fornecedor` (`fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `transportadora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `representante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comissao` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Products/Services Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `unidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `sigla` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `unidades` (`id`, `nome`, `sigla`) VALUES
(1, 'Unidade', 'UN'),
(2, 'Peça', 'PC'),
(3, 'Caixa', 'CX'),
(4, 'Metro', 'MT'),
(5, 'Quilograma', 'KG'),
(6, 'Litro', 'LT'),
(7, 'Metro Quadrado', 'M2'),
(8, 'Metro Cúbico', 'M3');

CREATE TABLE IF NOT EXISTS `prodserv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nome` varchar(200) NOT NULL,
  `descricao` text,
  `categoria` int(11) DEFAULT NULL,
  `unidade` int(11) DEFAULT NULL,
  `tipo` char(1) DEFAULT 'P',
  `cs` decimal(10,4) DEFAULT '0.0000',
  `venda` decimal(10,4) DEFAULT '0.0000',
  `estoque_min` decimal(10,2) DEFAULT '0.00',
  `estoque_max` decimal(10,2) DEFAULT '0.00',
  `estoque_atual` decimal(10,2) DEFAULT '0.00',
  `localizacao` varchar(50) DEFAULT NULL,
  `ncm` varchar(15) DEFAULT NULL,
  `pesol` decimal(10,3) DEFAULT '0.000',
  `pesob` decimal(10,3) DEFAULT '0.000',
  `prazo_entrega` int(11) DEFAULT '0',
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `unidade` (`unidade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_est` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `tipo` char(1) DEFAULT 'E',
  `qtd` decimal(10,2) DEFAULT '0.00',
  `data` date DEFAULT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `obs` text,
  PRIMARY KEY (`id`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_custo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `custo` decimal(10,4) DEFAULT '0.0000',
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  PRIMARY KEY (`id`),
  KEY `produto` (`produto`),
  KEY `item` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `preco` decimal(10,4) DEFAULT '0.0000',
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_ordem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  `data` date DEFAULT NULL,
  `previsao` date DEFAULT NULL,
  `sit` char(1) DEFAULT 'A',
  `obs` text,
  PRIMARY KEY (`id`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_sep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venda` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `prodserv_sep_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sep` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `qtd` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `sep` (`sep`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Sales Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `representante` int(11) DEFAULT NULL,
  `empresa` int(11) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `previsao` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `frete` decimal(10,2) DEFAULT '0.00',
  `seguro` decimal(10,2) DEFAULT '0.00',
  `despesas` decimal(10,2) DEFAULT '0.00',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `transportadora` int(11) DEFAULT NULL,
  `fretepor` char(1) DEFAULT 'E',
  `frete_tp` char(1) DEFAULT NULL,
  `l_entrega` int(11) DEFAULT NULL,
  `l_instalacao` int(11) DEFAULT NULL,
  `parcelamento` int(11) DEFAULT NULL,
  `natureza` int(11) DEFAULT NULL,
  `acao` int(11) DEFAULT NULL,
  `ordemc` varchar(50) DEFAULT NULL,
  `nf` varchar(30) DEFAULT NULL,
  `faturamento` int(11) DEFAULT NULL,
  `fechar` tinyint(1) DEFAULT '0',
  `nivel` int(11) DEFAULT '1',
  `sit` char(1) DEFAULT 'A',
  `obs` text,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`),
  KEY `vendedor` (`vendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `vendas_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venda` int(11) NOT NULL,
  `produto` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  `qtde` decimal(10,2) DEFAULT NULL,
  `altura` decimal(10,2) DEFAULT '0.00',
  `largura` decimal(10,2) DEFAULT '0.00',
  `unitario` decimal(10,4) DEFAULT '0.0000',
  `desconto` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `venda` (`venda`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `vendas_orc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `representante` int(11) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `sit` char(1) DEFAULT 'A',
  `obs` text,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `vendas_orc_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orcamento` int(11) NOT NULL,
  `produto` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  `unitario` decimal(10,4) DEFAULT '0.0000',
  `desconto` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `orcamento` (`orcamento`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `vendas_orcamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `representante` int(11) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `vendas_orcamento_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orcamento` int(11) NOT NULL,
  `produto` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  `unitario` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  KEY `orcamento` (`orcamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Purchases Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fornecedor` int(11) NOT NULL,
  `emissao` date DEFAULT NULL,
  `entrega` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `frete` decimal(10,2) DEFAULT '0.00',
  `sit` char(1) DEFAULT 'A',
  `obs` text,
  PRIMARY KEY (`id`),
  KEY `fornecedor` (`fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `compras_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compra` int(11) NOT NULL,
  `produto` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  `unitario` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  KEY `compra` (`compra`),
  KEY `produto` (`produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `compras_requisicao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `solicitante` int(11) DEFAULT NULL,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `compras_requisicao_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisicao` int(11) NOT NULL,
  `produto` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  PRIMARY KEY (`id`),
  KEY `requisicao` (`requisicao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `compras_cotacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisicao` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `compras_cotacao_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cotacao` int(11) NOT NULL,
  `fornecedor` int(11) DEFAULT NULL,
  `produto` int(11) DEFAULT NULL,
  `preco` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  KEY `cotacao` (`cotacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `e_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido` int(11) DEFAULT NULL,
  `sit` char(1) DEFAULT 'A',
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido` (`pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `e_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compra` int(11) NOT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  PRIMARY KEY (`id`),
  KEY `compra` (`compra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Financial Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `cp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fornecedor` int(11) DEFAULT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `pago` decimal(10,2) DEFAULT '0.00',
  `data_pago` date DEFAULT NULL,
  `banco` int(11) DEFAULT NULL,
  `natureza` int(11) DEFAULT NULL,
  `obs` text,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `fornecedor` (`fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cp_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cp` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `data` date DEFAULT NULL,
  `banco` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cp` (`cp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) DEFAULT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `pago` decimal(10,2) DEFAULT '0.00',
  `data_pago` date DEFAULT NULL,
  `banco` int(11) DEFAULT NULL,
  `natureza` int(11) DEFAULT NULL,
  `obs` text,
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cr_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `data` date DEFAULT NULL,
  `banco` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cr` (`cr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `bancos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `agencia` varchar(20) DEFAULT NULL,
  `conta` varchar(20) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `bancos_lan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banco` int(11) NOT NULL,
  `tipo` char(1) DEFAULT 'E',
  `valor` decimal(10,2) DEFAULT '0.00',
  `data` date DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banco` (`banco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `natureza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `tipo` char(1) DEFAULT 'E',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `parcelamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `parcelas` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `parcelamentos` (`id`, `descricao`, `parcelas`) VALUES
(1, 'À Vista', 1),
(2, '30 dias', 1),
(3, '30/60 dias', 2),
(4, '30/60/90 dias', 3);

CREATE TABLE IF NOT EXISTS `op_pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `op_pagamento` (`id`, `nome`) VALUES
(1, 'Dinheiro'),
(2, 'Cheque'),
(3, 'Cartão de Crédito'),
(4, 'Cartão de Débito'),
(5, 'Boleto'),
(6, 'Transferência'),
(7, 'PIX');

CREATE TABLE IF NOT EXISTS `pcontas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pcontas_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- CRM Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `crm_acao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `crm_acaor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acao` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `acao` (`acao`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `followup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `assunto` varchar(200) DEFAULT NULL,
  `descricao` text,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `followup_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `followup_tipo` (`id`, `nome`) VALUES
(1, 'Telefone'),
(2, 'Email'),
(3, 'Visita'),
(4, 'Reunião');

CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descricao` text,
  `cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `postit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `texto` text,
  `cor` varchar(10) DEFAULT 'yellow',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Auxiliary Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ramo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `frete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origem` varchar(50) DEFAULT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `feriados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `textos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `texto` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `up_pastas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `up_arq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pasta` int(11) DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `tamanho` int(11) DEFAULT '0',
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pasta` (`pasta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Invoice/NF Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `nf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) DEFAULT NULL,
  `serie` varchar(5) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL,
  `venda` int(11) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `sit` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`),
  KEY `venda` (`venda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `nf_prod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nf` int(11) NOT NULL,
  `produto` int(11) DEFAULT NULL,
  `qtd` decimal(10,2) DEFAULT '1.00',
  `unitario` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  KEY `nf` (`nf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `romaneio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `transportadora` int(11) DEFAULT NULL,
  `motorista` varchar(100) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `romaneio_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `romaneio` int(11) NOT NULL,
  `nf` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `romaneio` (`romaneio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Other Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `opertab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `operacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tip_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tamanho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `fixacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `sitri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `clafis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `dados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave` varchar(50) NOT NULL,
  `valor` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `de` int(11) DEFAULT NULL,
  `para` int(11) DEFAULT NULL,
  `assunto` varchar(200) DEFAULT NULL,
  `mensagem` text,
  `data` datetime DEFAULT NULL,
  `lida` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Curtain/PVC specific tables (industry-specific)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `cortinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `trilho` int(11) DEFAULT NULL,
  `pvc` int(11) DEFAULT NULL,
  `arrebites` int(11) DEFAULT NULL,
  `parafusos` int(11) DEFAULT NULL,
  `buchas` int(11) DEFAULT NULL,
  `penduralg` int(11) DEFAULT NULL,
  `penduralp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cortinas_not` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `tubo` int(11) DEFAULT NULL,
  `perfil1` int(11) DEFAULT NULL,
  `perfil2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `perfil` int(11) DEFAULT NULL,
  `b1` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `portasp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `pvc_inferior` int(11) DEFAULT NULL,
  `pvc_superior` int(11) DEFAULT NULL,
  `pvc_cristal` int(11) DEFAULT NULL,
  `b1` int(11) DEFAULT NULL,
  `b2` int(11) DEFAULT NULL,
  `b3` int(11) DEFAULT NULL,
  `co1` decimal(10,2) DEFAULT NULL,
  `co2` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Commit all changes
COMMIT;
