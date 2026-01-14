# Plano de Modernização dos CRUDs - Sistema ERP

## Objetivo
Atualizar todos os arquivos CRUD listados para seguir o padrão moderno de `compras.php`, corrigindo problemas de charset e layout.

## Problemas Identificados

### 1. Charset/Encoding
- **Problema**: Arquivos usam `<meta http-equiv="Content-Type" content="text/html; UTF-8">` mas o conteúdo está codificado em ISO-8859-1
- **Sintoma**: Caracteres aparecem como "Ã°ÂŸÂ"Â" ao invés de emojis/acentos corretos
- **Solução**: Padronizar para `<meta charset="ISO-8859-1">` em todos os arquivos

### 2. Layout Antigo
- **Problema**: Uso de tabelas para layout, classes CSS antigas (`textobold`, `formulario`, `formularioselect`)
- **Solução**: Migrar para classes CSS modernas (`erp-*`)

### 3. Erro em natureza.php
- **Problema**: Query com `or die("nao foi")` aparecendo na tela
- **Solução**: Melhorar tratamento de erro

## Arquivos a Serem Atualizados (21 arquivos)

| # | Arquivo | Prioridade | Complexidade |
|---|---------|------------|--------------|
| 1 | transp_incluir.php | Alta | Média |
| 2 | representantes.php | Alta | Média |
| 3 | cargos.php | Alta | Baixa |
| 4 | categorias.php | Alta | Baixa |
| 5 | unidades.php | Alta | Baixa |
| 6 | romaneio.php | Alta | Média |
| 7 | romaneio_vis.php | Alta | Baixa |
| 8 | prodserv_sep.php | Alta | Alta |
| 9 | pedidospendentes.php | Alta | Média |
| 10 | pedidospendentes_his.php | Alta | Média |
| 11 | followup.php | Alta | Média |
| 12 | agenda_inc.php | Alta | Média |
| 13 | crm_mark.php | Alta | Alta |
| 14 | mala.php | Alta | Alta |
| 15 | log_vis.php | Alta | Baixa |
| 16 | funcionario_login.php | Alta | Média |
| 17 | natureza.php | Crítica | Baixa |
| 18 | menu_menus.php | Alta | Baixa |
| 19 | menu_submenus.php | Alta | Baixa |
| 20 | textos.php | Alta | Média |
| 21 | backup.php | Alta | Média |

## Padrão de Código (Baseado em compras.php)

### Estrutura HTML Base
```php
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>[TITULO] - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <!-- CONTEUDO -->
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
```

### Classes CSS Modernas
- Container: `erp-container-fluid`
- Cards: `erp-card`, `erp-card-header`, `erp-card-title`
- Formulários: `erp-form-group`, `erp-form-label`, `erp-form-control`
- Grid: `erp-row`, `erp-col`
- Tabelas: `erp-table-container`, `erp-table`
- Botões: `erp-btn`, `erp-btn-primary`, `erp-btn-outline`
- Badges: `erp-badge`, `erp-badge-success`, `erp-badge-warning`, `erp-badge-danger`
- Alertas: `erp-alert`, `erp-alert-success`
- Alinhamento: `erp-text-center`, `erp-text-right`
- Ações: `erp-table-actions`, `erp-table-action`

## Fases de Implementação

### Fase 1: Correção Crítica (1 arquivo)
1. **natureza.php** - Corrigir erro "nao foi" e charset

### Fase 2: Arquivos Simples (8 arquivos)
2. cargos.php
3. categorias.php
4. unidades.php
5. romaneio_vis.php
6. log_vis.php
7. menu_menus.php
8. menu_submenus.php
9. textos.php

### Fase 3: Arquivos Médios (9 arquivos)
10. transp_incluir.php
11. representantes.php
12. romaneio.php
13. pedidospendentes.php
14. pedidospendentes_his.php
15. followup.php
16. agenda_inc.php
17. funcionario_login.php
18. backup.php

### Fase 4: Arquivos Complexos (3 arquivos)
19. prodserv_sep.php
20. crm_mark.php
21. mala.php

## Checklist de Mudanças por Arquivo

Para cada arquivo:
- [ ] Atualizar DOCTYPE para HTML5
- [ ] Corrigir charset para ISO-8859-1
- [ ] Adicionar viewport meta tag
- [ ] Incluir CSS modernos (Font Awesome, components.css, layout-fixes.css)
- [ ] Substituir layout de tabelas por divs com classes erp-*
- [ ] Atualizar formulários com classes erp-form-*
- [ ] Atualizar tabelas de dados com classes erp-table-*
- [ ] Atualizar botões com classes erp-btn-*
- [ ] Remover atributos inline obsoletos (bgcolor, width em tabelas, etc.)
- [ ] Atualizar body style para background:#f8f9fa;padding:24px;
- [ ] Manter funcionalidade PHP existente
- [ ] Testar funcionamento após mudanças

## Estimativa de Tempo
- Fase 1: 15 minutos
- Fase 2: 2 horas
- Fase 3: 3 horas
- Fase 4: 2 horas
- **Total Estimado**: ~7-8 horas

## Observações Importantes

1. **Não alterar lógica PHP** - Apenas atualizar HTML/CSS
2. **Manter compatibilidade** - Garantir que todas as funcionalidades existentes continuem funcionando
3. **Charset ISO-8859-1** - O sistema usa este charset para suportar caracteres portugueses nos dados existentes
4. **Emojis** - Substituir emojis Unicode por ícones Font Awesome quando apropriado
5. **Mensagens** - Manter mensagens em português para o usuário

## Início da Implementação

Começando pela Fase 1 - Correção crítica do natureza.php
