-- Seed data for ERP menus
-- Run this after schema.sql

USE erp_db;

-- Clear existing menu data
TRUNCATE TABLE submenus;
TRUNCATE TABLE menus;

-- Insert main menus
INSERT INTO `menus` (`id`, `texto`, `url`, `posicao`, `sit`) VALUES
(1, 'Cadastros', '#', 1, 'A'),
(2, 'Comercial', '#', 2, 'A'),
(3, 'Financeiro', '#', 3, 'A'),
(4, 'Estoque', '#', 4, 'A'),
(5, 'CRM', '#', 5, 'A'),
(6, 'Relatorios', '#', 6, 'A'),
(7, 'Configuracoes', '#', 7, 'A');

-- Insert submenus
-- Cadastros (menu 1)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(1, 1, 'Clientes', 'clientes.php', 1),
(2, 1, 'Fornecedores', 'fornecedores.php', 2),
(3, 1, 'Funcionarios', 'funcionarios.php', 3),
(4, 1, 'Produtos/Servicos', 'prodserv.php', 4),
(5, 1, 'Transportadoras', 'transp_incluir.php', 5),
(6, 1, 'Representantes', 'representantes.php', 6),
(7, 1, 'Cargos', 'cargos.php', 7),
(8, 1, 'Categorias', 'categorias.php', 8),
(9, 1, 'Unidades', 'unidades.php', 9);

-- Comercial (menu 2)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(10, 2, 'Vendas', 'vendas.php', 1),
(11, 2, 'Orcamentos', 'vendas_orc.php', 2),
(12, 2, 'Compras', 'compras.php', 3),
(13, 2, 'Requisicoes', 'compras_req.php', 4),
(14, 2, 'Cotacoes', 'compras_cot.php', 5),
(15, 2, 'Notas Fiscais', 'nf.php', 6),
(16, 2, 'Romaneio', 'romaneio.php', 7);

-- Financeiro (menu 3)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(17, 3, 'Contas a Pagar', 'cp.php', 1),
(18, 3, 'Contas a Receber', 'cr.php', 2),
(19, 3, 'Bancos', 'bancos.php', 3),
(20, 3, 'Lancamentos', 'bancos_lan.php', 4),
(21, 3, 'Fluxo de Caixa', 'fluxodecaixa.php', 5),
(22, 3, 'Parcelamentos', 'parcelamentos.php', 6),
(23, 3, 'Natureza', 'natureza.php', 7),
(24, 3, 'Formas Pagamento', 'op_pagamento.php', 8);

-- Estoque (menu 4)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(25, 4, 'Movimentacao', 'prodserv_est.php', 1),
(26, 4, 'Ordens Producao', 'prodserv_ordem.php', 2),
(27, 4, 'Separacao', 'prodserv_sep.php', 3),
(28, 4, 'Pedidos Pendentes', 'pedidospendentes.php', 4);

-- CRM (menu 5)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(29, 5, 'Follow-ups', 'followup.php', 1),
(30, 5, 'Agenda', 'agenda_inc.php', 2),
(31, 5, 'Acoes Marketing', 'crm_mark.php', 3),
(32, 5, 'Mala Direta', 'mala.php', 4);

-- Relatorios (menu 6)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(33, 6, 'CP Aberto', 'cp_aberto.php', 1),
(34, 6, 'CR Aberto', 'cr_aberto.php', 2),
(35, 6, 'Log Acessos', 'log_vis.php', 3);

-- Configuracoes (menu 7)
INSERT INTO `submenus` (`id`, `menu`, `texto`, `url`, `posicao`) VALUES
(36, 7, 'Empresa', 'empresa.php', 1),
(37, 7, 'Usuarios', 'funcionario_login.php', 2),
(38, 7, 'Niveis Acesso', 'niveis.php', 3),
(39, 7, 'Menus', 'menu_menus.php', 4),
(40, 7, 'Submenus', 'menu_submenus.php', 5),
(41, 7, 'Textos', 'textos.php', 6),
(42, 7, 'Backup', 'backup.php', 7);

-- Update niveis table with menu permissions (all menus and submenus for admin)
UPDATE `niveis` SET 
    `menus` = '1,2,3,4,5,6,7',
    `submenus` = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42'
WHERE `id` = 1;

-- Verify data
SELECT 'Menus inserted:' as info, COUNT(*) as total FROM menus;
SELECT 'Submenus inserted:' as info, COUNT(*) as total FROM submenus;
SELECT 'Nivel 1 permissions:' as info, menus, submenus FROM niveis WHERE id = 1;
