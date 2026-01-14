# Plano de Migração para PHP 8.2 - Sistema ERP

**Versão:** 1.0  
**Data:** 2026-01-13  
**Status do Sistema:** PHP 5.x/7.x → PHP 8.2  
**Autor:** Sistema de Modernização ERP

---

## 📋 Sumário Executivo

Este documento detalha o plano completo de migração do Sistema ERP da versão PHP 5.x/7.x para PHP 8.2. A migração é necessária para:

- ✅ Garantir segurança e suporte continuado
- ✅ Melhorar performance (até 3x mais rápido)
- ✅ Acessar recursos modernos do PHP
- ✅ Compatibilidade com hospedagens atuais
- ✅ Reduzir vulnerabilidades de segurança

---

## 🧭 Versão alvo, versão “mais recente” e recomendação

### **Qual é a versão “mais recente” do PHP?**

O “latest” muda com o tempo. **Antes de iniciar o rollout**, confirme a versão estável em `php.net`.

### **Recomendação para este ERP**

- **Alvo recomendado (produção)**: **PHP 8.2** (equilíbrio entre maturidade e compatibilidade).
- **Alvo alternativo**: **PHP 8.3+** (se o ecossistema/servidor já estiver validado).

> **Nota importante**: esta migração **não é um “version bump”**. Para este codebase, é uma **refatoração controlada**, principalmente por causa de `mysql_*`, variáveis implícitas e segurança.

---

## 🔍 Análise do Sistema Atual

### Estatísticas do Codebase

| Métrica | Quantidade | Impacto |
|---------|-----------|---------|
| **Total de arquivos PHP** | 874 | Alto |
| **Uso de mysql_\* (deprecated)** | 8,473 ocorrências em 732 arquivos | **CRÍTICO** |
| **Uso de $_REQUEST/$_POST/$_GET** | 2,234 ocorrências em 530 arquivos | Médio |
| **Uso de extract()** | 1 ocorrência | Baixo |
| **Uso de `or die()`** | 300 ocorrências em 80 arquivos | Médio |
| **Short PHP tags `<?`** | **presentes** (centenas de ocorrências em centenas de arquivos) | **ALTO** |
| **Mojibake/encoding quebrado** (ex.: `Funciona¡rios`, `C�digo`, `â`) | presente (não-uniforme) | **ALTO** |

### Problemas Críticos Identificados

#### 1. **CRÍTICO: Funções mysql_\* removidas**
```php
mysql_connect()     → REMOVIDO no PHP 7.0
mysql_query()       → REMOVIDO no PHP 7.0
mysql_fetch_array() → REMOVIDO no PHP 7.0
mysql_num_rows()    → REMOVIDO no PHP 7.0
mysql_error()       → REMOVIDO no PHP 7.0
```

#### 2. **ALTO: Registro Automático de Variáveis**
```php
// conecta.php - linhas 18-22
foreach($_REQUEST as $name=>$valor){
    $$name = $valor;  // ← VULNERABILIDADE DE SEGURANÇA
}
```

#### 3. **MÉDIO: Tratamento de Erros Inadequado**
```php
mysql_query(...) or die("Erro"); // ← Não recomendado em produção
```

#### 4. **ALTO: Short open tags**

Mesmo que hoje funcione (por configuração de servidor), em PHP moderno isso costuma estar **desativado por padrão**.

**Obrigatório**: substituir `<?`/`<?=` por `<?php`/`<?php echo ... ?>`.

#### 5. **ALTO: Codificação / charset inconsistente**

O sistema hoje mistura **ISO-8859-1**, trechos em **UTF-8** e textos corrompidos (mojibake). Isso quebra UI, validações e exportações.

**Padrão correto (recomendado e adotado neste plano):**
- **HTML/HTTP:** `UTF-8`
- **MySQL/MariaDB:** `utf8mb4` + `utf8mb4_unicode_ci`

> **Por que**: no MySQL, `utf8` **não é UTF-8 completo** (é 3-byte). O correto é `utf8mb4` (UTF-8 completo).

---

## 🎯 Estratégia de Migração

### Abordagem Recomendada: **MIGRAÇÃO INCREMENTAL**

**Justificativa:**
- ✅ Minimiza riscos operacionais
- ✅ Permite testes contínuos
- ✅ Facilita rollback em caso de problemas
- ✅ Não interrompe operações do negócio

### Fases da Migração

```
FASE 1: Preparação e Infraestrutura (1-2 semanas)
    ↓
FASE 2: Camada de Compatibilidade (2-3 semanas)
    ↓
FASE 3: Migração do Core (3-4 semanas)
    ↓
FASE 4: Migração dos Módulos (4-6 semanas)
    ↓
FASE 5: Testes e Validação (2-3 semanas)
    ↓
FASE 6: Deploy e Monitoramento (1 semana)
```

**Tempo Total Estimado:** 13-19 semanas (3-5 meses)

---

## 📅 FASE 1: Preparação e Infraestrutura (1-2 semanas)

### 1.1 Setup do Ambiente de Desenvolvimento

#### Requisitos de Sistema
```bash
# Instalar PHP 8.2
PHP 8.2.x
- mysqli extension
- pdo_mysql extension
- mbstring
- json
- curl
- gd

# Ferramentas de Desenvolvimento
- Composer 2.x
- PHPUnit 10.x
- PHP_CodeSniffer
- PHPStan (análise estática)
```

#### Docker Setup (Recomendado)
```dockerfile
# Atualizar Dockerfile
FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli

# Configurações PHP 8.2
COPY php.ini /usr/local/etc/php/
```

### 1.2 Backup Completo

#### Checklist de Backup
- [ ] Backup completo do banco de dados
- [ ] Backup de todos os arquivos PHP
- [ ] Backup de configurações do servidor
- [ ] Backup de arquivos enviados pelos usuários
- [ ] Documentação do estado atual do sistema

```bash
# Script de backup
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="backups/pre_php82_${DATE}"

# Backup Database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > ${BACKUP_DIR}/database.sql

# Backup Files
tar -czf ${BACKUP_DIR}/files.tar.gz ./
```

### 1.3 Análise de Dependências

#### Bibliotecas Externas a Verificar
```
- FPDF → Verificar compatibilidade PHP 8.2
- Bibliotecas de PDF no diretório Qualidade/
- Bibliotecas JavaScript (Ajax, jQuery)
```

### 1.4 Criação de Ambientes

| Ambiente | Propósito | PHP Version |
|----------|-----------|-------------|
| **Produção** | Sistema atual | PHP 5.x/7.x |
| **Staging** | Testes pré-produção | PHP 8.2 |
| **Development** | Desenvolvimento | PHP 8.2 |
| **Testing** | Testes automatizados | PHP 8.2 |

---

## 📅 FASE 2: Camada de Compatibilidade (2-3 semanas)

### 2.1 Criar Camada de Abstração de Banco de Dados

#### Objetivo

**End-state recomendado:** **PDO + prepared statements** (segurança e compatibilidade).

Para reduzir risco, você pode usar uma camada temporária para “rodar primeiro e refatorar depois”, mas:

- **Não existe “patch” real para `mysql_*`** no PHP 8+: o caminho é **migrar o acesso ao banco**.
- Qualquer shim “mysql_compat” deve ser tratado como **temporário** e removido na fase de hardening.

#### Implementação

**Criar arquivo:** `database/Database.php`

```php
<?php
/**
 * Database Abstraction Layer
 * Compatibilidade com PHP 8.2
 */
class Database {
    private static $instance = null;
    private $connection = null;
    private $host;
    private $user;
    private $password;
    private $database;
    
    private function __construct($host, $user, $password, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->connect();
    }
    
    private function connect() {
        $this->connection = @mysqli_connect(
            $this->host, 
            $this->user, 
            $this->password, 
            $this->database
        );
        
        if (!$this->connection) {
            throw new Exception(
                "Erro de conexao: " . mysqli_connect_error()
            );
        }
        
        mysqli_set_charset($this->connection, 'utf8mb4');
    }
    
    public static function getInstance($host = null, $user = null, $password = null, $database = null) {
        if (self::$instance === null) {
            if ($host === null) {
                throw new Exception("Database parameters required on first call");
            }
            self::$instance = new self($host, $user, $password, $database);
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        if (!$result) {
            error_log("SQL Error: " . mysqli_error($this->connection));
            error_log("SQL Query: " . $sql);
        }
        return $result;
    }
    
    public function fetchArray($result) {
        return mysqli_fetch_array($result);
    }
    
    public function fetchAssoc($result) {
        return mysqli_fetch_assoc($result);
    }
    
    public function numRows($result) {
        return mysqli_num_rows($result);
    }
    
    public function insertId() {
        return mysqli_insert_id($this->connection);
    }
    
    public function error() {
        return mysqli_error($this->connection);
    }
    
    public function escape($string) {
        return mysqli_real_escape_string($this->connection, $string);
    }
    
    public function close() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
```

**Criar arquivo:** `database/mysql_compat_legacy.php`

```php
<?php
/**
 * Funções de compatibilidade mysql_* para mysqli_*
 * TEMPORÁRIO - Para facilitar migração gradual
 * DEVE SER REMOVIDO após migração completa
 */

if (!function_exists('mysql_connect')) {
    function mysql_connect($host, $user, $password) {
        $GLOBALS['mysql_link'] = mysqli_connect($host, $user, $password);
        return $GLOBALS['mysql_link'];
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database, $link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_select_db($link, $database);
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_query($link, $query);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        return mysqli_fetch_array($result, $result_type);
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result) {
        return mysqli_fetch_assoc($result);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        return mysqli_num_rows($result);
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_insert_id($link);
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_error($link);
    }
}

if (!function_exists('mysql_errno')) {
    function mysql_errno($link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_errno($link);
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_close($link);
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($string, $link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_real_escape_string($link, $string);
    }
}

if (!function_exists('mysql_set_charset')) {
    function mysql_set_charset($charset, $link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_set_charset($link, $charset);
    }
}

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($link = null) {
        $link = $link ?? $GLOBALS['mysql_link'];
        return mysqli_affected_rows($link);
    }
}

if (!function_exists('mysql_free_result')) {
    function mysql_free_result($result) {
        return mysqli_free_result($result);
    }
}
```

### 2.2 Atualizar `conecta.php`

#### Opção recomendada (PDO + utf8mb4)

```php
<?php
declare(strict_types=1);

require_once(__DIR__ . "/configuracoes.php");

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$bd};charset=utf8mb4",
        $user,
        $pwd,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (Throwable $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Erro de conexao com o banco de dados. Contate o administrador do sistema.");
}
```

#### Opção temporária (apenas para transição)

Você pode manter `mysqli`/camadas de compatibilidade **apenas** para destravar o primeiro boot no PHP 8.2 — mas **a meta final** deve ser PDO.

**Arquivo:** `conecta.php` (Versão Intermediária)

```php
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

// Incluir camada de compatibilidade temporária
require_once("database/mysql_compat_legacy.php");
require_once("configuracoes.php");

// Usar mysqli em vez de mysql
$cnx = @mysqli_connect($host, $user, $pwd, $bd);
if(!$cnx) {
    error_log("Database connection error: " . mysqli_connect_error());
    die("Erro de conexao com o banco de dados. Verifique as configuracoes.");
}

@mysqli_set_charset($cnx, 'utf8mb4');

// IMPORTANTE: Substituir este bloco por validação específica
// Este é o maior problema de segurança do sistema
foreach($_REQUEST as $name => $valor){
    if(!in_array($name, array('GLOBALS', '_SERVER', '_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_REQUEST', '_ENV'))) {
        // Sanitizar e validar dados
        if(is_array($valor)) {
            $$name = array_map(function($v) use ($cnx) {
                return is_string($v) ? mysqli_real_escape_string($cnx, $v) : $v;
            }, $valor);
        } else {
            $$name = is_string($valor) ? mysqli_real_escape_string($cnx, $valor) : $valor;
        }
    }
}

// Inicializar sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
```

### 2.3 Criar Sistema de Input Validation

**Criar arquivo:** `database/Input.php`

```php
<?php
/**
 * Input Validation and Sanitization
 * PHP 8.2 Compatible
 */
class Input {
    private static $db = null;
    
    public static function setDatabase($connection) {
        self::$db = $connection;
    }
    
    public static function get($key, $default = null, $filter = FILTER_SANITIZE_STRING) {
        if (!isset($_GET[$key])) {
            return $default;
        }
        
        $value = $_GET[$key];
        return self::sanitize($value, $filter);
    }
    
    public static function post($key, $default = null, $filter = FILTER_SANITIZE_STRING) {
        if (!isset($_POST[$key])) {
            return $default;
        }
        
        $value = $_POST[$key];
        return self::sanitize($value, $filter);
    }
    
    public static function request($key, $default = null, $filter = FILTER_SANITIZE_STRING) {
        if (isset($_POST[$key])) {
            return self::post($key, $default, $filter);
        }
        
        if (isset($_GET[$key])) {
            return self::get($key, $default, $filter);
        }
        
        return $default;
    }
    
    private static function sanitize($value, $filter) {
        if (is_array($value)) {
            return array_map(function($v) use ($filter) {
                return self::sanitize($v, $filter);
            }, $value);
        }
        
        // Aplicar filtro
        $value = filter_var($value, $filter);
        
        // Escapar para SQL se database connection disponível
        if (self::$db !== null && is_string($value)) {
            $value = mysqli_real_escape_string(self::$db, $value);
        }
        
        return $value;
    }
    
    public static function escape($value) {
        if (self::$db === null) {
            throw new Exception("Database connection not set");
        }
        
        if (is_array($value)) {
            return array_map([self::class, 'escape'], $value);
        }
        
        return mysqli_real_escape_string(self::$db, $value);
    }
}
```

---

## 🔤 Migração de encoding (padrão: UTF-8/utf8mb4)

### Por que isso é obrigatório no seu caso

Você já tem sinais claros de corrupção (`Funciona¡rios`, `C�digo`, `â`, etc.). Isso normalmente vem de **texto UTF-8 sendo interpretado como ISO-8859-1**, ou o inverso.

### Plano prático

- **Arquivos**: converter `.php`, `.js`, `.css` para **UTF-8 sem BOM**.
- **HTML**: padronizar **exatamente**:
  - `<meta charset="UTF-8">`
  - `<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">` (se usado; evite duplicidade conflitante)
- **PHP (HTTP header)**: para páginas HTML, antes de qualquer output:
  - `header('Content-Type: text/html; charset=UTF-8');`
- **Banco (MySQL/MariaDB)**:
  - `CHARACTER SET utf8mb4`
  - `COLLATE utf8mb4_unicode_ci`
  - Conexão PHP → DB usando `utf8mb4`:
    - `mysqli_set_charset($conn, 'utf8mb4');`
    - **PDO DSN**: `charset=utf8mb4`

---

## 🔎 Substituições comuns (exemplos)

### `mysql_num_rows()` → PDO

**Antes**

```php
if (mysql_num_rows($sql) == 0) { ... }
```

**Depois (PDO)**

```php
$stmt = $pdo->prepare("SELECT ... WHERE ...");
$stmt->execute([...]);
if ($stmt->rowCount() === 0) { ... }
```

---

## 📅 FASE 3: Migração do Core (3-4 semanas)

### 3.1 Arquivos Core a Migrar

#### Prioridade ALTA
1. `conecta.php` - Conexão com banco de dados
2. `seguranca.php` - Sistema de segurança
3. `login.php` - Sistema de autenticação
4. `index.php` - Arquivo principal
5. `corpo.php` - Estrutura principal

### 3.2 Migração do conecta.php (Versão Final)

**Arquivo:** `conecta.php` (PHP 8.2 Final)

```php
<?php
/**
 * Database Connection - PHP 8.2
 * Modernizado e seguro
 */

declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once(__DIR__ . '/database/Database.php');
require_once(__DIR__ . '/database/Input.php');
require_once(__DIR__ . '/configuracoes.php');

try {
    // Inicializar conexão com banco usando Singleton
    $db = Database::getInstance($host, $user, $pwd, $bd);
    $cnx = $db->getConnection();
    
    // Configurar Input class com a conexão
    Input::setDatabase($cnx);
    
} catch (Exception $e) {
    error_log("Database initialization error: " . $e->getMessage());
    die("Erro de conexao com o banco de dados. Contate o administrador do sistema.");
}

// Inicializar sessão de forma segura
if (session_status() === PHP_SESSION_NONE) {
    // Configurações de segurança da sessão
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_secure', '0'); // Mudar para '1' se usar HTTPS
    
    session_start();
    
    // Regenerar session ID periodicamente
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 300) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

/**
 * IMPORTANTE: REMOVER registro automático de variáveis
 * Substituir por acesso explícito via Input class
 * 
 * Exemplo de migração:
 * ANTES: $acao (auto-registrado)
 * DEPOIS: $acao = Input::request('acao', '');
 */

// Helper function para compatibilidade temporária
function getRequestVar(string $name, $default = null) {
    return Input::request($name, $default);
}
?>
```

### 3.3 Atualizar seguranca.php

**Arquivo:** `seguranca.php` (PHP 8.2)

```php
<?php
/**
 * Security Layer - PHP 8.2
 */

declare(strict_types=1);

// Verificar se sessão existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se usuário está logado
if (!isset($_SESSION['login_id']) || empty($_SESSION['login_id'])) {
    // Armazenar URL para redirect após login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Redirect para login
    header('Location: login.php');
    exit;
}

// Verificar timeout de sessão (30 minutos)
$timeout = 1800; // 30 minutos em segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header('Location: login.php?timeout=1');
    exit;
}

// Atualizar último acesso
$_SESSION['last_activity'] = time();

// Variáveis de sessão
$iduser = $_SESSION['login_id'] ?? 0;
$funcionario = $_SESSION['login_funcionario'] ?? '';
$nivel = $_SESSION['login_nivel'] ?? 0;

// Função de verificação de permissões
function verifi(?array $permissions, string $action): string {
    global $nivel;
    
    if ($permissions === null || empty($permissions)) {
        return $action;
    }
    
    // Administrador tem acesso total
    if ($nivel == 1) {
        return $action;
    }
    
    // Verificar se ação está permitida para o nível do usuário
    if (isset($permissions[$action]) && in_array($nivel, (array)$permissions[$action])) {
        return $action;
    }
    
    // Ação não permitida
    return '';
}

// Proteção CSRF (Cross-Site Request Forgery)
function generateCSRFToken(): string {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Registrar token CSRF para uso nos forms
$csrf_token = generateCSRFToken();
?>
```

### 3.4 Padrão de Migração de Arquivos

#### Template de Migração

**ANTES (PHP 5.x/7.x):**
```php
<?
include("conecta.php");
include("seguranca.php");

// $acao é auto-registrado via $_REQUEST

if($acao=="incluir"){
    $sql=mysql_query("INSERT INTO tabela (campo) VALUES ('$valor')");
    if($sql){
        $_SESSION["mensagem"]="Sucesso!";
    }
}

$result=mysql_query("SELECT * FROM tabela");
while($res=mysql_fetch_array($result)){
    echo $res["campo"];
}
?>
```

**DEPOIS (PHP 8.2):**
```php
<?php
declare(strict_types=1);

require_once("conecta.php");
require_once("seguranca.php");

// Obter variáveis explicitamente
$acao = Input::request('acao', '');
$valor = Input::request('valor', '');

// Verificar permissões
$acao = verifi($permi ?? null, $acao);

if($acao === "incluir"){
    // Usar prepared statements
    $stmt = mysqli_prepare($cnx, "INSERT INTO tabela (campo) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $valor);
    
    if(mysqli_stmt_execute($stmt)){
        $_SESSION["mensagem"] = "Sucesso!";
    } else {
        error_log("SQL Error: " . mysqli_error($cnx));
        $_SESSION["mensagem"] = "Erro ao salvar dados.";
    }
    
    mysqli_stmt_close($stmt);
}

// Usar a instância Database
$db = Database::getInstance();
$result = $db->query("SELECT * FROM tabela");

while($res = $db->fetchArray($result)){
    echo htmlspecialchars($res["campo"] ?? '', ENT_QUOTES, 'UTF-8');
}
?>
```

### 3.5 Criar Prepared Statements Helper

**Criar arquivo:** `database/QueryBuilder.php`

```php
<?php
/**
 * Query Builder with Prepared Statements
 * PHP 8.2 Compatible
 */

declare(strict_types=1);

class QueryBuilder {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function insert(string $table, array $data): bool {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            error_log("Prepare failed: " . mysqli_error($this->connection));
            return false;
        }
        
        $types = $this->getBindTypes($data);
        $values = array_values($data);
        
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        $result = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        return $result;
    }
    
    public function update(string $table, array $data, string $where, array $whereParams): bool {
        $sets = [];
        foreach (array_keys($data) as $field) {
            $sets[] = "{$field} = ?";
        }
        $setClause = implode(', ', $sets);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            error_log("Prepare failed: " . mysqli_error($this->connection));
            return false;
        }
        
        $allData = array_merge(array_values($data), $whereParams);
        $types = $this->getBindTypes($allData);
        
        mysqli_stmt_bind_param($stmt, $types, ...$allData);
        $result = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        return $result;
    }
    
    public function delete(string $table, string $where, array $whereParams): bool {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            error_log("Prepare failed: " . mysqli_error($this->connection));
            return false;
        }
        
        $types = $this->getBindTypes($whereParams);
        mysqli_stmt_bind_param($stmt, $types, ...$whereParams);
        $result = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        return $result;
    }
    
    public function select(string $sql, array $params = []): ?mysqli_result {
        if (empty($params)) {
            return mysqli_query($this->connection, $sql);
        }
        
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            error_log("Prepare failed: " . mysqli_error($this->connection));
            return null;
        }
        
        $types = $this->getBindTypes($params);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        
        return $result;
    }
    
    private function getBindTypes(array $values): string {
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }
    
    public function getLastInsertId(): int {
        return mysqli_insert_id($this->connection);
    }
}
?>
```

---

## 📅 FASE 4: Migração dos Módulos (4-6 semanas)

### 4.1 Ordem de Migração dos Módulos

#### Semana 1-2: Módulos Base
- [ ] `fornecedores.php` / `fornecedores_geral.php`
- [ ] `clientes.php` / `clientes_geral.php`
- [ ] `funcionarios.php` / `funcionarios_geral.php`
- [ ] `empresa.php`

#### Semana 3-4: Módulos Financeiros
- [ ] `cp.php` / `cp_aberto.php` (Contas a Pagar)
- [ ] `cr.php` / `cr_aberto.php` (Contas a Receber)
- [ ] `bancos.php` / `bancos_lan.php`
- [ ] `fluxodecaixa.php`

#### Semana 5-6: Módulos de Vendas e Compras
- [ ] `vendas.php` / `vendas_orc.php`
- [ ] `compras.php` / `compras_req.php`
- [ ] `prodserv.php` / `prodserv_ordem.php`
- [ ] `nf.php` / `nfe.php`

#### Semana 7-8: Módulos CRM e Auxiliares
- [ ] `crm_*.php` (todos os arquivos CRM)
- [ ] `followup.php`
- [ ] `agenda_inc.php`
- [ ] Módulos de configuração

#### Semana 9-10: Módulos Qualidade
- [ ] `Qualidade/**/*.php` (732 arquivos)
- [ ] Módulos PPAP/APQP
- [ ] Geradores de PDF

### 4.2 Script de Migração Automática

**Criar arquivo:** `tools/migrate_file.php`

```php
<?php
/**
 * Script de Migração Automática
 * Converte arquivo PHP 5.x/7.x para PHP 8.2
 */

declare(strict_types=1);

class FileMigrator {
    private string $filePath;
    private string $content;
    private array $changes = [];
    
    public function __construct(string $filePath) {
        $this->filePath = $filePath;
        $this->content = file_get_contents($filePath);
    }
    
    public function migrate(): void {
        // 1. Adicionar declare(strict_types=1)
        $this->addStrictTypes();
        
        // 2. Substituir mysql_* por Database class
        $this->replaceMysqlFunctions();
        
        // 3. Adicionar Input::request() para variáveis
        $this->addInputValidation();
        
        // 4. Substituir or die() por error handling
        $this->replaceOrDie();
        
        // 5. Adicionar htmlspecialchars nos outputs
        $this->addOutputEscaping();
        
        // 6. Atualizar include/require
        $this->updateIncludes();
    }
    
    private function addStrictTypes(): void {
        if (strpos($this->content, 'declare(strict_types=1)') === false) {
            $this->content = preg_replace(
                '/^<\?php\s*/s',
                "<?php\ndeclare(strict_types=1);\n\n",
                $this->content
            );
            $this->changes[] = "Added declare(strict_types=1)";
        }
    }
    
    private function replaceMysqlFunctions(): void {
        $replacements = [
            '/mysql_query\s*\(\s*([^,\)]+)\s*\)/i' => 'mysqli_query($cnx, $1)',
            '/mysql_fetch_array\s*\(/i' => 'mysqli_fetch_array(',
            '/mysql_fetch_assoc\s*\(/i' => 'mysqli_fetch_assoc(',
            '/mysql_num_rows\s*\(/i' => 'mysqli_num_rows(',
            '/mysql_insert_id\s*\(\s*\)/i' => 'mysqli_insert_id($cnx)',
            '/mysql_error\s*\(\s*\)/i' => 'mysqli_error($cnx)',
            '/mysql_real_escape_string\s*\(/i' => 'mysqli_real_escape_string($cnx, ',
        ];
        
        foreach ($replacements as $pattern => $replacement) {
            $newContent = preg_replace($pattern, $replacement, $this->content);
            if ($newContent !== $this->content) {
                $this->content = $newContent;
                $this->changes[] = "Replaced mysql function: $pattern";
            }
        }
    }
    
    private function addInputValidation(): void {
        // Detectar uso de variáveis não declaradas que vêm de $_REQUEST
        // Este é um processo complexo que requer análise contextual
        $this->changes[] = "TODO: Manual input validation required";
    }
    
    private function replaceOrDie(): void {
        // Substituir or die() por proper error handling
        $this->content = preg_replace_callback(
            '/\)\s*or\s+die\s*\(\s*["\']([^"\']+)["\']\s*\)/i',
            function($matches) {
                $errorMsg = $matches[1];
                return ") or (error_log('SQL Error: {$errorMsg} - ' . mysqli_error(\$cnx)) && false)";
            },
            $this->content
        );
        
        $this->changes[] = "Replaced or die() with error logging";
    }
    
    private function addOutputEscaping(): void {
        // Identificar echo/print que precisam de escaping
        // Complexo - requer análise contextual
        $this->changes[] = "TODO: Manual output escaping review required";
    }
    
    private function updateIncludes(): void {
        $this->content = str_replace(
            ['include("', 'require("'],
            ['require_once(__DIR__ . "/', 'require_once(__DIR__ . "/'],
            $this->content
        );
        
        $this->changes[] = "Updated include/require statements";
    }
    
    public function save(string $backupDir = null): void {
        // Criar backup
        if ($backupDir) {
            $backupPath = $backupDir . '/' . basename($this->filePath);
            copy($this->filePath, $backupPath);
        }
        
        // Salvar arquivo migrado
        file_put_contents($this->filePath, $this->content);
    }
    
    public function getChanges(): array {
        return $this->changes;
    }
    
    public function preview(): string {
        return $this->content;
    }
}

// Uso:
// $migrator = new FileMigrator('fornecedores.php');
// $migrator->migrate();
// echo $migrator->preview();
// $migrator->save('backups/');
?>
```

### 4.3 Checklist de Migração por Arquivo

Para cada arquivo PHP, seguir este checklist:

- [ ] **Backup criado**
- [ ] **declare(strict_types=1) adicionado**
- [ ] **mysql_* substituído por mysqli_* ou Database class**
- [ ] **$_REQUEST/$_POST/$_GET validados com Input class**
- [ ] **Prepared statements implementados para queries com variáveis**
- [ ] **or die() substituído por error handling apropriado**
- [ ] **htmlspecialchars() adicionado em outputs**
- [ ] **include/require atualizados com __DIR__**
- [ ] **Testado em ambiente PHP 8.2**
- [ ] **Code review realizado**
- [ ] **Aprovado para produção**

---

## 📅 FASE 5: Testes e Validação (2-3 semanas)

### 5.1 Testes Unitários

**Criar arquivo:** `tests/DatabaseTest.php`

```php
<?php
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    private $db;
    
    protected function setUp(): void {
        $this->db = Database::getInstance('localhost', 'test_user', 'test_pass', 'test_db');
    }
    
    public function testConnection(): void {
        $this->assertNotNull($this->db->getConnection());
    }
    
    public function testQuery(): void {
        $result = $this->db->query("SELECT 1 as num");
        $this->assertNotFalse($result);
        
        $row = $this->db->fetchArray($result);
        $this->assertEquals(1, $row['num']);
    }
    
    public function testEscape(): void {
        $dangerous = "'; DROP TABLE users; --";
        $safe = $this->db->escape($dangerous);
        $this->assertStringContainsString("\\", $safe);
    }
}
?>
```

### 5.2 Testes de Integração

#### Criar Suite de Testes

```php
<?php
/**
 * Integration Tests
 * tests/Integration/CRUDTest.php
 */

class CRUDTest extends TestCase {
    public function testFornecedorCRUD(): void {
        // Create
        $_POST['acao'] = 'incluir';
        $_POST['nome'] = 'Fornecedor Teste';
        $_POST['fantasia'] = 'Teste Ltda';
        
        ob_start();
        include(__DIR__ . '/../../fornecedores_geral.php');
        $output = ob_get_clean();
        
        $this->assertStringContainsString('sucesso', $_SESSION['mensagem'] ?? '');
        
        // Read
        // Update
        // Delete
    }
}
?>
```

### 5.3 Testes Manuais

#### Checklist de Testes por Módulo

**Fornecedores:**
- [ ] Listar fornecedores
- [ ] Criar novo fornecedor
- [ ] Editar fornecedor existente
- [ ] Excluir fornecedor
- [ ] Buscar fornecedor por nome
- [ ] Buscar fornecedor por código
- [ ] Validação de CNPJ
- [ ] Upload de arquivos (se aplicável)

**Clientes:**
- [ ] Listar clientes
- [ ] Criar novo cliente
- [ ] Editar cliente existente
- [ ] Excluir cliente
- [ ] Gerenciar contatos
- [ ] Gerenciar endereços
- [ ] Financeiro do cliente

**Vendas:**
- [ ] Criar orçamento
- [ ] Converter orçamento em pedido
- [ ] Adicionar produtos ao pedido
- [ ] Calcular totais
- [ ] Gerar nota fiscal
- [ ] Imprimir documentos

### 5.4 Testes de Performance

**Criar arquivo:** `tests/performance_test.php`

```php
<?php
/**
 * Performance Comparison Test
 * PHP 5.x vs PHP 8.2
 */

// Teste 1: Query Performance
$start = microtime(true);

for ($i = 0; $i < 1000; $i++) {
    $result = mysqli_query($cnx, "SELECT * FROM fornecedores LIMIT 10");
    while ($row = mysqli_fetch_array($result)) {
        // Process
    }
}

$end = microtime(true);
$time = $end - $start;

echo "1000 queries com fetch: {$time}s\n";

// Teste 2: String Operations
$start = microtime(true);

for ($i = 0; $i < 100000; $i++) {
    $str = "Test string " . $i;
    $escaped = mysqli_real_escape_string($cnx, $str);
    $filtered = htmlspecialchars($escaped);
}

$end = microtime(true);
$time = $end - $start;

echo "100k string operations: {$time}s\n";
?>
```

### 5.5 Testes de Segurança

#### Checklist de Segurança

- [ ] SQL Injection em todos os inputs
- [ ] XSS (Cross-Site Scripting) em outputs
- [ ] CSRF token validação
- [ ] Session hijacking prevention
- [ ] File upload validation
- [ ] Directory traversal prevention
- [ ] Authentication bypass attempts
- [ ] Authorization checks

**Ferramentas:**
- OWASP ZAP
- SQLMap
- Burp Suite (Community Edition)

---

## 📅 FASE 6: Deploy e Monitoramento (1 semana)

### 6.1 Preparação para Deploy

#### Checklist Pré-Deploy

- [ ] Todos os testes passando
- [ ] Code review completo
- [ ] Documentação atualizada
- [ ] Backup completo do sistema atual
- [ ] Plano de rollback preparado
- [ ] Equipe treinada
- [ ] Horário de manutenção agendado

### 6.2 Estratégia de Deploy

#### Opção 1: Blue-Green Deployment (Recomendado)

```
[Sistema Atual - PHP 7.x]  ← 100% tráfego
          ↓
[Sistema Novo - PHP 8.2]   ← 0% tráfego (em teste)
          ↓
[Validação e testes]
          ↓
[Sistema Atual - PHP 7.x]  ← 50% tráfego
[Sistema Novo - PHP 8.2]   ← 50% tráfego
          ↓
[Monitoramento]
          ↓
[Sistema Atual - PHP 7.x]  ← 0% tráfego (standby)
[Sistema Novo - PHP 8.2]   ← 100% tráfego
```

#### Opção 2: Staged Rollout

```
Semana 1: 10% dos usuários
Semana 2: 25% dos usuários
Semana 3: 50% dos usuários
Semana 4: 100% dos usuários
```

### 6.3 Configuração do Servidor

#### Arquivo: `php.ini` (PHP 8.2)

```ini
[PHP]
; Core Settings
engine = On
short_open_tag = Off
precision = 14
output_buffering = 4096
zlib.output_compression = Off

; Error Handling
error_reporting = E_ALL & ~E_NOTICE & ~E_DEPRECATED
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log

; Resource Limits
max_execution_time = 300
max_input_time = 60
memory_limit = 256M
post_max_size = 50M
upload_max_filesize = 50M

; Security
expose_php = Off
allow_url_fopen = On
allow_url_include = Off

; Session
session.save_handler = files
session.use_strict_mode = 1
session.cookie_httponly = 1
session.cookie_secure = 0  ; Alterar para 1 se usar HTTPS
session.use_only_cookies = 1
session.gc_maxlifetime = 1800

; MySQLi
mysqli.max_persistent = -1
mysqli.allow_persistent = On
mysqli.max_links = -1
mysqli.default_port = 3306
mysqli.default_socket =
mysqli.default_host =
mysqli.default_user =
mysqli.default_pw =
mysqli.reconnect = Off

; Extensions
extension=mysqli
extension=pdo_mysql
extension=mbstring
extension=gd
extension=curl
extension=json
```

#### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName erp.seudominio.com
    DocumentRoot /var/www/html/erp
    
    <Directory /var/www/html/erp>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
        
        # PHP 8.2
        <FilesMatch \.php$>
            SetHandler "proxy:unix:/var/run/php/php8.2-fpm.sock|fcgi://localhost"
        </FilesMatch>
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/erp_error.log
    CustomLog ${APACHE_LOG_DIR}/erp_access.log combined
</VirtualHost>
```

### 6.4 Monitoramento

#### Métricas a Monitorar

**Performance:**
- Tempo de resposta das páginas
- Uso de CPU
- Uso de memória
- Queries por segundo
- Tempo médio de query

**Erros:**
- PHP errors
- SQL errors
- HTTP 500 errors
- Timeout errors

**Negócio:**
- Número de transações
- Pedidos criados
- Notas fiscais geradas
- Usuários ativos

#### Script de Monitoramento

**Criar arquivo:** `tools/monitor.php`

```php
<?php
/**
 * System Health Monitor
 * PHP 8.2
 */

declare(strict_types=1);

class SystemMonitor {
    private $logFile;
    
    public function __construct(string $logFile = '/var/log/erp/monitor.log') {
        $this->logFile = $logFile;
    }
    
    public function check(): array {
        return [
            'timestamp' => date('Y-m-d H:i:s'),
            'php_version' => phpversion(),
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'load_average' => sys_getloadavg(),
            'database' => $this->checkDatabase(),
            'disk_space' => disk_free_space('/'),
            'errors' => $this->getRecentErrors(),
        ];
    }
    
    private function checkDatabase(): array {
        try {
            require_once(__DIR__ . '/../conecta.php');
            
            $start = microtime(true);
            $result = mysqli_query($cnx, "SELECT 1");
            $time = microtime(true) - $start;
            
            return [
                'status' => 'ok',
                'response_time' => $time,
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
    
    private function getRecentErrors(): array {
        $errorLog = ini_get('error_log');
        if (!file_exists($errorLog)) {
            return [];
        }
        
        $lines = array_slice(file($errorLog), -10);
        return array_map('trim', $lines);
    }
    
    public function log(array $data): void {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->logFile, date('Y-m-d H:i:s') . " - " . $json . "\n", FILE_APPEND);
    }
    
    public function alert(string $message, string $level = 'warning'): void {
        // Implementar notificações (email, SMS, Slack, etc)
        error_log("[{$level}] {$message}");
    }
}

// Executar a cada 5 minutos via cron
if (php_sapi_name() === 'cli') {
    $monitor = new SystemMonitor();
    $status = $monitor->check();
    $monitor->log($status);
    
    // Alertar se houver problemas
    if ($status['database']['status'] !== 'ok') {
        $monitor->alert('Database connection issue', 'critical');
    }
    
    if ($status['memory_usage'] > 200 * 1024 * 1024) { // 200MB
        $monitor->alert('High memory usage: ' . round($status['memory_usage'] / 1024 / 1024) . 'MB', 'warning');
    }
}
?>
```

### 6.5 Plano de Rollback

#### Em caso de problemas críticos:

**1. Rollback Imediato (< 5 minutos)**
```bash
#!/bin/bash
# rollback.sh

echo "Iniciando rollback para PHP 7.x..."

# Parar PHP 8.2
sudo systemctl stop php8.2-fpm

# Ativar PHP 7.x
sudo systemctl start php7.4-fpm
sudo a2enconf php7.4-fpm
sudo a2disconf php8.2-fpm
sudo systemctl reload apache2

# Restaurar arquivos se necessário
# tar -xzf backups/pre_php82_TIMESTAMP/files.tar.gz -C /var/www/html/

echo "Rollback concluído. Sistema em PHP 7.x"
```

**2. Restaurar Banco de Dados (se necessário)**
```bash
#!/bin/bash
# restore_db.sh

echo "Restaurando banco de dados..."
mysql -u$DB_USER -p$DB_PASS $DB_NAME < backups/pre_php82_TIMESTAMP/database.sql
echo "Banco de dados restaurado"
```

---

## 📊 Recursos Necessários

### 7.1 Equipe

| Papel | Responsabilidades | Dedicação |
|-------|-------------------|-----------|
| **Tech Lead** | Coordenação geral, code reviews | 100% |
| **Desenvolvedor Senior** | Migração core, database layer | 100% |
| **Desenvolvedor Pleno** | Migração módulos | 100% |
| **Desenvolvedor Júnior** | Testes, documentação | 50% |
| **QA/Tester** | Testes funcionais e integração | 100% |
| **DBA** | Otimização de queries, performance | 25% |
| **DevOps** | Infraestrutura, deploy, monitoramento | 50% |

### 7.2 Infraestrutura

**Ambientes:**
- Desenvolvimento: 2 servidores (PHP 7.x e PHP 8.2)
- Staging: 1 servidor (PHP 8.2)
- Production: 2 servidores (Blue-Green)

**Especificações Mínimas por Servidor:**
- CPU: 4 cores
- RAM: 8GB
- Disco: 100GB SSD
- PHP 8.2 + Apache/Nginx
- MySQL 8.0+

### 7.3 Ferramentas

**Desenvolvimento:**
- IDE: PHPStorm ou VSCode
- Git para controle de versão
- Composer para dependências
- Docker para ambientes isolados

**Testes:**
- PHPUnit 10.x
- PHP_CodeSniffer
- PHPStan
- Selenium (testes E2E)

**Monitoramento:**
- New Relic ou Datadog
- Sentry para error tracking
- Grafana para métricas

---

## 🎯 Métricas de Sucesso

### 8.1 KPIs Técnicos

| Métrica | Baseline (PHP 7.x) | Target (PHP 8.2) | Como Medir |
|---------|-------------------|------------------|------------|
| **Tempo de Resposta** | 500ms (média) | < 300ms | APM Tool |
| **Uso de Memória** | 128MB (média) | < 100MB | PHP monitoring |
| **Queries/segundo** | 100 | > 150 | Database monitoring |
| **Taxa de Erro** | 0.1% | < 0.05% | Error logs |
| **Uptime** | 99% | > 99.5% | Monitoring tool |

### 8.2 KPIs de Negócio

| Métrica | Como Medir |
|---------|------------|
| **Satisfação do Usuário** | Pesquisa pós-migração |
| **Downtime Durante Migração** | < 2 horas |
| **Bugs Críticos Pós-Deploy** | 0 (zero) |
| **Tempo de Recuperação** | < 15 minutos |

---

## 📝 Riscos e Mitigações

### 9.1 Riscos Identificados

| Risco | Probabilidade | Impacto | Mitigação |
|-------|---------------|---------|-----------|
| **Incompatibilidade de biblioteca externa** | Média | Alto | Testar todas as libs antecipadamente |
| **Downtime excessivo** | Baixa | Crítico | Blue-Green deployment |
| **Perda de dados** | Muito Baixa | Crítico | Backups múltiplos e testes de restore |
| **Performance degradation** | Baixa | Alto | Testes de carga antecipados |
| **Bugs em produção** | Média | Alto | Testes extensivos + staged rollout |
| **Resistência dos usuários** | Baixa | Médio | Treinamento e comunicação |

### 9.2 Plano de Contingência

**Se encontrarmos problemas graves:**

1. **Bugs menores:** Fix e deploy rápido (hotfix)
2. **Bugs médios:** Rollback parcial do módulo afetado
3. **Bugs críticos:** Rollback completo para PHP 7.x
4. **Performance ruim:** Otimização de queries + caching
5. **Incompatibilidade:** Manter versão legacy em paralelo

---

## 📚 Documentação e Treinamento

### 10.1 Documentação a Criar/Atualizar

- [ ] Manual de instalação PHP 8.2
- [ ] Guia de desenvolvimento para novos recursos
- [ ] API documentation (Database, Input, QueryBuilder)
- [ ] Manual de deploy
- [ ] Runbook de troubleshooting
- [ ] Changelog detalhado

### 10.2 Treinamento da Equipe

**Tópicos:**
1. Novos recursos PHP 8.2
2. Strict types e type hints
3. Nova arquitetura Database layer
4. Input validation com Input class
5. Prepared statements
6. Error handling moderno
7. Debugging com PHP 8.2

**Formato:**
- Workshops semanais (2h)
- Code reviews em pares
- Documentação wiki interna

---

## ✅ Checklist Final de Migração

### Pré-Deploy
- [ ] Todos os 874 arquivos PHP revisados
- [ ] Todas as 8,473 ocorrências de mysql_* migradas
- [ ] Input validation implementada em todos os formulários
- [ ] Prepared statements em todas as queries com variáveis
- [ ] 100% dos testes unitários passando
- [ ] 100% dos testes de integração passando
- [ ] Testes de carga aprovados
- [ ] Testes de segurança aprovados
- [ ] Documentação atualizada
- [ ] Equipe treinada
- [ ] Backups criados e testados
- [ ] Plano de rollback testado
- [ ] Monitoramento configurado
- [ ] Stakeholders comunicados

### Pós-Deploy
- [ ] Sistema em PHP 8.2 rodando em produção
- [ ] Monitoramento ativo por 30 dias
- [ ] Zero bugs críticos
- [ ] Performance targets atingidos
- [ ] Usuários satisfeitos
- [ ] Documentação pós-mortem criada
- [ ] Lições aprendidas documentadas

---

## 📞 Contatos e Suporte

### Equipe de Migração
- **Tech Lead:** [Nome] - [email]
- **Desenvolvedor Senior:** [Nome] - [email]
- **QA Lead:** [Nome] - [email]
- **DevOps:** [Nome] - [email]

### Escalação
1. **Nível 1:** Desenvolvedor on-call
2. **Nível 2:** Tech Lead
3. **Nível 3:** CTO/Diretor de TI

---

## 📅 Cronograma Consolidado

| Fase | Duração | Data Início | Data Fim | Status |
|------|---------|-------------|----------|--------|
| **1. Preparação** | 2 semanas | A definir | | 🔴 Não iniciado |
| **2. Compatibilidade** | 3 semanas | | | 🔴 Não iniciado |
| **3. Core** | 4 semanas | | | 🔴 Não iniciado |
| **4. Módulos** | 6 semanas | | | 🔴 Não iniciado |
| **5. Testes** | 3 semanas | | | 🔴 Não iniciado |
| **6. Deploy** | 1 semana | | | 🔴 Não iniciado |
| **TOTAL** | **19 semanas** | | | |

---

## 🎓 Apêndices

### A. Recursos de Referência

**Documentação Oficial:**
- [PHP 8.2 Migration Guide](https://www.php.net/manual/en/migration82.php)
- [MySQLi Documentation](https://www.php.net/manual/en/book.mysqli.php)
- [PHP 8.2 New Features](https://www.php.net/releases/8.2/en.php)

**Ferramentas:**
- [PHP Compatibility Checker](https://github.com/PHPCompatibility/PHPCompatibility)
- [Rector - PHP Upgrader](https://github.com/rectorphp/rector)
- [PHPStan - Static Analysis](https://phpstan.org/)

### B. Comandos Úteis

```bash
# Verificar compatibilidade PHP 8.2
./vendor/bin/phpcs --standard=PHPCompatibility --runtime-set testVersion 8.2 .

# Executar testes
./vendor/bin/phpunit

# Análise estática
./vendor/bin/phpstan analyse src

# Atualizar automaticamente código
./vendor/bin/rector process src --dry-run
```

### C. SQL para Auditoria

```sql
-- Verificar tamanho das tabelas
SELECT 
    table_name AS 'Tabela',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Tamanho (MB)'
FROM information_schema.TABLES 
WHERE table_schema = 'seu_banco'
ORDER BY (data_length + index_length) DESC;

-- Queries lentas (habilitar slow query log)
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;

-- Verificar conexões
SHOW PROCESSLIST;
```

---

## 🏁 Conclusão

Esta migração para PHP 8.2 é um investimento significativo que trará:

✅ **Segurança:** Correção de vulnerabilidades críticas  
✅ **Performance:** Até 3x mais rápido  
✅ **Manutenibilidade:** Código mais limpo e moderno  
✅ **Suporte:** PHP 8.2 tem suporte até 2026  
✅ **Recursos:** Acesso a novos recursos da linguagem  

**O sucesso desta migração depende de:**
- Planejamento cuidadoso
- Testes extensivos
- Execução gradual
- Monitoramento constante

---

**Documento criado em:** 13/01/2026  
**Última atualização:** 13/01/2026  
**Versão:** 1.0  
**Aprovação:** Pendente

---

*Este documento deve ser revisado e atualizado regularmente durante o processo de migração.*
