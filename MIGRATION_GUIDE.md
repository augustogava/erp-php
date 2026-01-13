# 🔄 GUIA DE MIGRAÇÃO PARA O NOVO DESIGN SYSTEM

## 📚 Visão Geral

Este guia fornece instruções detalhadas para migrar páginas do sistema ERP do layout antigo (tabelas HTML) para o novo design system baseado em componentes modernos.

## 🎨 Componentes Disponíveis

### 1. Layout e Containers
```html
<div class="erp-container">         <!-- Container com max-width 1400px -->
<div class="erp-container-fluid">   <!-- Container fluido 100% -->
<div class="erp-row">               <!-- Flexbox row -->
<div class="erp-col">               <!-- Flexbox column -->
```

### 2. Cards
```html
<div class="erp-card">
    <div class="erp-card-header">
        <h1 class="erp-card-title">Título</h1>
        <div><!-- Ações do header --></div>
    </div>
    <div class="erp-card-body">
        <!-- Conteúdo -->
    </div>
</div>
```

### 3. Formulários

#### Antes (Antigo):
```html
<table>
    <tr class="textobold">
        <td>Nome:</td>
        <td><input name="nome" type="text" class="formularioselect" size="50"></td>
    </tr>
</table>
<input type="submit" class="microtxt" value="Salvar">
```

#### Depois (Novo):
```html
<div class="erp-row">
    <div class="erp-col">
        <div class="erp-form-group">
            <label class="erp-form-label">Nome</label>
            <input type="text" name="nome" class="erp-form-control">
        </div>
    </div>
</div>
<button type="submit" class="erp-btn erp-btn-primary">Salvar</button>
```

### 4. Tabelas de Dados

#### Antes (Antigo):
```html
<table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
    <tr bgcolor="#003366" class="textoboldbranco">
        <td width="39">Cód</td>
        <td width="414">Nome</td>
    </tr>
    <tr onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td bgcolor="#FFFFFF" class="texto">001</td>
        <td bgcolor="#FFFFFF" class="texto">Cliente Teste</td>
    </tr>
</table>
```

#### Depois (Novo):
```html
<div class="erp-table-container">
    <table class="erp-table">
        <thead>
            <tr>
                <th width="60">Cód</th>
                <th>Nome</th>
                <th width="150" class="erp-text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>001</strong></td>
                <td>Cliente Teste</td>
                <td>
                    <div class="erp-table-actions" style="justify-content:center;">
                        <a href="#" class="erp-table-action">✏️</a>
                        <a href="#" class="erp-table-action">🗑️</a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

### 5. Botões

```html
<!-- Primário -->
<button class="erp-btn erp-btn-primary">Salvar</button>
<a href="#" class="erp-btn erp-btn-primary">Link Botão</a>

<!-- Secundário -->
<button class="erp-btn erp-btn-secondary">Cancelar</button>

<!-- Sucesso -->
<button class="erp-btn erp-btn-success">Confirmar</button>

<!-- Perigo -->
<button class="erp-btn erp-btn-danger">Excluir</button>

<!-- Outline -->
<button class="erp-btn erp-btn-outline">Detalhes</button>

<!-- Tamanhos -->
<button class="erp-btn erp-btn-primary erp-btn-sm">Pequeno</button>
<button class="erp-btn erp-btn-primary erp-btn-lg">Grande</button>
```

### 6. Status Badges

```html
<span class="erp-badge erp-badge-success">Ativo</span>
<span class="erp-badge erp-badge-warning">Pendente</span>
<span class="erp-badge erp-badge-danger">Cancelado</span>
<span class="erp-badge erp-badge-info">Em Análise</span>
```

### 7. Alerts

```html
<div class="erp-alert erp-alert-success">
    Operação realizada com sucesso!
</div>

<div class="erp-alert erp-alert-warning">
    Atenção: Verifique os dados antes de continuar.
</div>

<div class="erp-alert erp-alert-danger">
    Erro: Não foi possível completar a operação.
</div>
```

### 8. Paginação

```html
<div class="erp-pagination">
    <a href="?wp=1" class="erp-pagination-item">‹ Anterior</a>
    <span class="erp-pagination-item active">1</span>
    <a href="?wp=2" class="erp-pagination-item">2</a>
    <a href="?wp=3" class="erp-pagination-item">3</a>
    <a href="?wp=2" class="erp-pagination-item">Próxima ›</a>
</div>
```

## 🔧 Processo de Migração (Passo a Passo)

### Passo 1: Atualizar o Head
```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Nome da Página - ERP System</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>
```

### Passo 2: Atualizar o Body
```html
<body style="background:#f8f9fa;padding:24px;">
<div class="erp-container-fluid">
    <!-- Conteúdo aqui -->
</div>
</body>
```

### Passo 3: Converter Cabeçalho da Página
```html
<!-- Page Header -->
<div class="erp-card">
    <div class="erp-card-header">
        <h1 class="erp-card-title">🎯 Título da Página</h1>
        <div>
            <a href="#" class="erp-btn erp-btn-primary">+ Nova Ação</a>
        </div>
    </div>
</div>
```

### Passo 4: Converter Formulário de Busca
```html
<div class="erp-card">
    <form method="post" action="">
        <div class="erp-row">
            <div class="erp-col" style="flex:2;">
                <div class="erp-form-group">
                    <label class="erp-form-label">Campo 1</label>
                    <input type="text" name="campo1" class="erp-form-control">
                </div>
            </div>
            <div class="erp-col">
                <div class="erp-form-group">
                    <label class="erp-form-label">Campo 2</label>
                    <input type="text" name="campo2" class="erp-form-control">
                </div>
            </div>
            <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                <div class="erp-form-group" style="margin-bottom:0;">
                    <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                        🔍 Buscar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
```

### Passo 5: Converter Tabela de Dados
Ver exemplo completo na seção 4 acima.

## 📋 Checklist de Migração

- [ ] Atualizar DOCTYPE para HTML5
- [ ] Adicionar viewport meta tag
- [ ] Incluir `components.css` no head
- [ ] Converter background para `#f8f9fa`
- [ ] Substituir tables de layout por divs
- [ ] Atualizar inputs para `.erp-form-control`
- [ ] Atualizar botões para `.erp-btn`
- [ ] Converter tabelas de dados para `.erp-table`
- [ ] Adicionar badges de status onde aplicável
- [ ] Implementar paginação moderna
- [ ] Testar responsividade
- [ ] Validar acessibilidade

## 🎯 Páginas Prioritárias para Migração

### ✅ Concluídas
1. ✅ `index.php` - Layout principal
2. ✅ `esquerdo.php` - Menu lateral
3. ✅ `clientes.php` - Listagem de clientes (exemplo completo)
4. ✅ `bancos_lan.php` - Lançamentos bancários (exemplo completo)

### ⏳ Pendentes (Alta Prioridade)
5. `fornecedores.php` - Listagem de fornecedores
6. `funcionarios.php` - Listagem de funcionários
7. `prodserv.php` - Produtos/Serviços
8. `vendas.php` - Vendas
9. `compras.php` - Compras
10. `cp.php` - Contas a pagar
11. `cr.php` - Contas a receber
12. `clientes_geral.php` - Formulário de clientes
13. `vendas_orc.php` - Orçamentos

### ⏳ Pendentes (Média Prioridade)
- Páginas de relatórios
- Páginas do módulo CRM
- Páginas de configuração

## 🚀 Dicas e Boas Práticas

1. **Use Emojis nos Títulos**: Melhora a identificação visual
   ```html
   <h1 class="erp-card-title">👥 Clientes</h1>
   ```

2. **Agrupe Ações Relacionadas**:
   ```html
   <div class="erp-table-actions">
       <a href="#" class="erp-table-action">✏️</a>
       <a href="#" class="erp-table-action">🗑️</a>
   </div>
   ```

3. **Use Badges para Status**:
   ```php
   $status_class = $row["sit"]=="A" ? "success" : "danger";
   $status_text = $row["sit"]=="A" ? "Ativo" : "Inativo";
   echo '<span class="erp-badge erp-badge-'.$status_class.'">'.$status_text.'</span>';
   ```

4. **Mantenha Consistência nas Cores**:
   - Verde (#27AE60): Sucesso, Ativo, Entrada
   - Vermelho (#E74C3C): Erro, Inativo, Saída
   - Azul (#4169E1): Primário, Links, Ações
   - Laranja (#F39C12): Avisos, Pendências

5. **Use Classes Utilitárias**:
   ```html
   <td class="erp-text-center">Conteúdo</td>
   <td class="erp-text-right">R$ 1.000,00</td>
   <div class="erp-mt-4">Espaçamento superior</div>
   ```

## 🐛 Problemas Comuns e Soluções

### Problema: Formulário desalinhado
**Solução**: Certifique-se de usar `.erp-row` e `.erp-col`
```html
<div class="erp-row">
    <div class="erp-col">Campo 1</div>
    <div class="erp-col">Campo 2</div>
</div>
```

### Problema: Botão não alinha com inputs
**Solução**: Use flexbox e `align-items:flex-end`
```html
<div class="erp-col" style="display:flex;align-items:flex-end;">
    <button class="erp-btn">Buscar</button>
</div>
```

### Problema: Tabela não responsiva
**Solução**: Sempre envolva em `.erp-table-container`
```html
<div class="erp-table-container">
    <table class="erp-table">...</table>
</div>
```

## 📞 Suporte

Para dúvidas sobre a migração, consulte:
- `IMPLEMENTATION_PLAN.md` - Plano completo de implementação
- `components.css` - Todos os componentes disponíveis
- `clientes.php` - Exemplo completo de listagem
- `bancos_lan.php` - Exemplo completo de formulário

---

**Última atualização**: Janeiro 2026
**Versão**: 1.0
