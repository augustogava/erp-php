# Sistema ERP - CyberManager / QualityManager

Sistema ERP (Enterprise Resource Planning) legado desenvolvido em PHP para gerenciamento empresarial completo.

## Visão Geral

Este é um sistema ERP completo que inclui os seguintes módulos:

### Módulos Principais

- **Cadastros**
  - Clientes (pessoas físicas e jurídicas)
  - Fornecedores
  - Funcionários
  - Produtos e Serviços
  - Transportadoras
  - Representantes

- **Comercial**
  - Vendas (pedidos de venda)
  - Orçamentos
  - Compras
  - Cotações
  - Requisições de compra

- **Financeiro**
  - Contas a Pagar (CP)
  - Contas a Receber (CR)
  - Bancos e Lançamentos
  - Plano de Contas
  - Fluxo de Caixa

- **Estoque**
  - Controle de Estoque
  - Movimentações (entrada/saída)
  - Ordens de Produção
  - Separação de Pedidos

- **CRM**
  - Follow-ups
  - Agenda de Compromissos
  - Ações de Marketing
  - Histórico de Contatos

- **Faturamento**
  - Notas Fiscais
  - Romaneios

- **Qualidade (PPAP/APQP)**
  - Módulo de qualidade para indústria automotiva
  - Documentação PPAP
  - Planos de controle
  - FMEA

## Requisitos do Sistema

### Com Docker (Recomendado)

- Docker Desktop
- Docker Compose

### Sem Docker

- PHP 7.4+ (compatível com funções mysql_* através de wrapper mysqli)
- MySQL 5.7+
- Apache com mod_rewrite
- Extensões PHP: mysqli, gd, mbstring

## Instalação

### Usando Docker (Recomendado)

1. Clone ou copie o projeto para um diretório local

2. Execute os containers:
```bash
docker-compose up -d
```

3. Aguarde a inicialização dos serviços (cerca de 30 segundos)

4. Popule os menus do sistema:
```bash
docker exec -i erp_db mysql -u erp_user -perp_password erp_db < database/seed_menus.sql
```

5. Acesse o sistema:
   - **Aplicação**: http://localhost:8080/login_page.php
   - **phpMyAdmin**: http://localhost:8081

6. Credenciais padrão:
   - **Usuário**: `admin`
   - **Senha**: `admin123`

### Instalação Manual

1. Configure um servidor Apache com PHP 5.6

2. Importe o banco de dados:
```bash
mysql -u root -p < database/schema.sql
```

3. Edite o arquivo `configuracoes.php` com as credenciais do banco:
```php
$host = "localhost";
$user = "seu_usuario";
$pwd = "sua_senha";
$bd = "erp_db";
```

4. Acesse via navegador

## Estrutura do Projeto

```
SistemaERP/
├── database/
│   ├── schema.sql          # Script SQL do banco de dados
│   └── seed_menus.sql      # Dados iniciais dos menus
├── Qualidade/
│   ├── layout_PPAP_edicao4/ # Módulo de qualidade PPAP
│   └── pdf/                 # Geração de PDFs (FPDF)
├── imagens/                 # Imagens do sistema
├── swf/                     # Arquivos Flash (legado)
├── TMimages/               # Imagens do menu tree
├── configuracoes.php       # Configurações do sistema
├── conecta.php             # Conexão com banco de dados
├── seguranca.php           # Controle de acesso
├── login.php               # Processamento de login
├── login_page.php          # Página de login
├── index.php               # Página principal (após login)
├── style.css               # CSS legado (compatibilidade)
├── components.css          # 🎨 Design System - Novos componentes
├── docker-compose.yml      # Configuração Docker
├── Dockerfile              # Imagem Docker PHP
├── php.ini                 # Configurações PHP
├── IMPLEMENTATION_PLAN.md  # Plano de implementação do design
└── MIGRATION_GUIDE.md      # Guia de migração de páginas
```

## Arquivos Principais

| Arquivo | Descrição | Status UI |
|---------|-----------|-----------|
| `clientes.php` | Listagem de clientes | ✅ Modernizado |
| `bancos_lan.php` | Lançamentos bancários | ✅ Modernizado |
| `index.php` | Layout principal | ✅ Modernizado |
| `esquerdo.php` | Menu lateral | ✅ Modernizado |
| `clientes_geral.php` | Cadastro/edição de clientes | ⏳ Pendente |
| `fornecedores.php` | Gerenciamento de fornecedores | ⏳ Pendente |
| `funcionarios.php` | Cadastro de funcionários | ⏳ Pendente |
| `prodserv.php` | Produtos e serviços | ⏳ Pendente |
| `vendas.php` | Módulo de vendas | ⏳ Pendente |
| `vendas_orc.php` | Orçamentos | ⏳ Pendente |
| `compras.php` | Módulo de compras | ⏳ Pendente |
| `cp.php` | Contas a pagar | ⏳ Pendente |
| `cr.php` | Contas a receber | ⏳ Pendente |
| `bancos.php` | Gestão de bancos | ⏳ Pendente |
| `nf.php` | Notas fiscais | ⏳ Pendente |
| `followup.php` | CRM - Follow-ups | ⏳ Pendente |
| `agenda_inc.php` | Agenda de compromissos | ⏳ Pendente |
| `prodserv_est.php` | Controle de estoque | ⏳ Pendente |
| `prodserv_ordem.php` | Ordens de produção | ⏳ Pendente |

## Configuração do Docker

### Serviços

- **web**: PHP 7.4 + Apache (porta 8080)
- **db**: MySQL 5.7 (porta 3307)
- **phpmyadmin**: Interface web para MySQL (porta 8081)

### Variáveis de Ambiente

```yaml
DB_HOST: db
DB_USER: erp_user
DB_PASS: erp_password
DB_NAME: erp_db
```

### Comandos Úteis

```bash
# Iniciar os serviços
docker-compose up -d

# Parar os serviços
docker-compose down

# Ver logs
docker-compose logs -f

# Reconstruir imagem
docker-compose build --no-cache

# Acessar container PHP
docker exec -it erp_web bash

# Acessar MySQL
docker exec -it erp_db mysql -u erp_user -p erp_db
```

## Banco de Dados

### Tabelas Principais

| Tabela | Descrição |
|--------|-----------|
| `empresa` | Dados da empresa |
| `clientes` | Cadastro de clientes |
| `cliente_login` | Usuários do sistema |
| `fornecedores` | Cadastro de fornecedores |
| `funcionarios` | Funcionários |
| `prodserv` | Produtos e serviços |
| `vendas` | Pedidos de venda |
| `vendas_list` | Itens dos pedidos |
| `compras` | Pedidos de compra |
| `cp` | Contas a pagar |
| `cr` | Contas a receber |
| `bancos` | Contas bancárias |
| `nf` | Notas fiscais |
| `niveis` | Níveis de acesso |
| `menus` | Menus do sistema |

### Usuário Padrão

- Login: `admin`
- Senha: `admin123`
- Nível: Administrador

## Funcionalidades por Módulo

### Clientes
- Cadastro completo (PF/PJ)
- Endereços múltiplos (faturamento, entrega, cobrança)
- Histórico financeiro
- Integração com CRM

### Produtos/Serviços
- Cadastro com categorias
- Controle de estoque (min/max)
- Múltiplas unidades de medida
- Composição de produtos (BOM)
- Custos e preços de venda

### Vendas
- Orçamentos com conversão para pedido
- Itens com altura/largura (para cortinas/PVC)
- Cálculo automático de impostos
- Integração com faturamento

### Financeiro
- Parcelamento automático
- Baixa de títulos
- Conciliação bancária
- Relatórios de fluxo de caixa

## Notas Técnicas

### Codificação
- O sistema usa ISO-8859-1 (Latin1) para caracteres especiais em português
- Arquivos PHP com short open tags (`<?`)

### Compatibilidade PHP 7
- O sistema original utilizava funções `mysql_*` (removidas no PHP 7)
- Uma camada de compatibilidade foi implementada em `conecta.php` usando mysqli
- Funções wrapper: `mysql_query`, `mysql_fetch_array`, `mysql_num_rows`, `mysql_real_escape_string`

### Segurança
- Sistema de níveis de acesso
- Controle de menus por usuário
- Log de acessos
- Bloqueio de acesso externo (opcional)

## Troubleshooting

### Erro de conexão com banco
1. Verifique se o MySQL está rodando
2. Confirme as credenciais em `configuracoes.php`
3. Teste a conexão via phpMyAdmin

### Página em branco
1. Habilite exibição de erros no `php.ini`
2. Verifique logs do Apache
3. Confirme que `short_open_tag = On`

### Caracteres estranhos
1. Verifique charset do banco (latin1)
2. Configure charset na conexão MySQL
3. Meta tag charset no HTML

## Licença

Sistema desenvolvido para uso interno. Todos os direitos reservados.

## Contato

Para suporte técnico, entre em contato com o administrador do sistema.

---

**Versão**: 3.5.1  
**Última atualização**: 2026
