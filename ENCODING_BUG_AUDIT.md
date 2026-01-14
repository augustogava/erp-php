# Encoding / Mojibake Audit (Workspace `D:\Development\SistemaERP`)

**Goal:** find “similar bugs” (broken accents, broken emojis/icons, conflicting charset tags, short open tags) and provide a prioritized fix queue.

**Date:** 2026-01-14

---

## Summary (what we found)

- **Mojibake / encoding corruption** (ex.: `J� existe... c�digo`, `CPF V�lido`, `Fun��o`, `Voc�`)  
  - **36 matches across 2 files**: `prodserv_sql.php` (28), `configuracoes.php` (8).
- **Charset meta mismatch** (algumas páginas declaram `UTF-8`, outras ainda estão em `ISO-8859-1/latin1`)  
  - **10 matches across 9 files**.
- **Short open tags** (`<? ...` instead of `<?php ...`)  
  - **871 matches across 401 files**.
- **User-facing `or die(...)` / hard stop** (risk of leaking messages like “nun foi” / killing flow)  
  - **300 matches across 80 files**.

Additional note:
- **Literal `nun foi`**: **0 matches** in this workspace scan (but `or die(...)` is still widespread and can still produce “mystery messages”).

---

## How to interpret these issues

### 1) Mojibake
This is classic “bytes interpreted under the wrong charset”. Examples seen in this codebase:
- `Funciona¡rios` (expected “Funcionários”)
- `Ca³digo` (expected “Código”)
- `Acaµes` (expected “Ações”)
- `Voc� n�o tem permiss�o...` (expected “Você não tem permissão...”)
- emoji bytes like `ð`, `âï¸`, arrows `â`, etc.

### 2) Conflicting charset
Algumas páginas declaram **UTF-8**, outras ainda carregam legado em **ISO-8859-1/latin1**. Isso produz UI “quebrada” de forma intermitente dependendo do que o navegador assume.

### 3) Short open tags
Even if it works on your server today, **PHP 8.x deployments often have `short_open_tag=Off`**, so `<?` will break.

### 4) `or die(...)`
These are not encoding bugs, but they create “mystery messages” (like your “nun foi”), leak info, and are hard to debug in production.

---

## Priority fix order (recommended)

1. **Fix “data layer” / shared messages first**
   - `configuracoes.php` (helpers + messages reused across modules)
2. **Fix operational/business logic messages**
   - `prodserv_sql.php` (product operations; many user-facing messages)
3. **Normalize charset declarations** (**UTF-8** everywhere + DB em **utf8mb4**)
4. **Remove short open tags** (mass edit with safe tooling)
5. **Remove `or die(...)`** (replace with logging + friendly UI messages)

---

## Mojibake / encoding corruption: exact files & examples

### `configuracoes.php` (high priority)
Problems:
- Strings: `CPF V�lido`, `Fun��o`, `Voc� n�o tem permiss�o...`, `C�digo`, `N�o Localizado`

### `prodserv_sql.php`
Problems:
- Messages: `J� existe... c�digo`, `m�ximo`, `n�o p�de`, `Servi�o inclu�do`, `Pre�o`, `Produ��o`, etc.
Also note:
- File starts with `<?` (short open tag).

---

## Charset mismatches: files to normalize

These pages currently declare **UTF-8** in `<meta charset>`:
- `vendas.php` (also has `<meta http-equiv="Content-Type"...UTF-8`)
- `corpo.php`
- `cp.php`
- `cr.php`
- `compras_req.php`
- `compras_cot.php`
- `op_pagamento.php`
- `parcelamentos.php`
- `prodserv_est.php`

**Standard (use this):**
- `<meta charset="UTF-8">`
- `<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">` (se usado)
- Em PHP (antes de output): `header('Content-Type: text/html; charset=UTF-8');`
- MySQL/MariaDB: `CHARACTER SET utf8mb4` + `COLLATE utf8mb4_unicode_ci`
- Conexão PHP → DB:
  - `mysqli_set_charset($conn, 'utf8mb4');`
  - ou **PDO DSN**: `charset=utf8mb4`

---

## Short open tags (PHP 8.x readiness)

We found **871 occurrences across 401 files** of lines starting with `<?` (not `<?php` / not `<?=`).

**Action:** bulk replace:
- `<?` → `<?php` (where it is PHP open tag)
- `<?=` → `<?php echo ... ?>`

This should be done with a scripted approach + manual review for edge cases.

---

## `or die(...)` occurrences

We found **300 occurrences across 80 files**.

**Action:** replace with:
- logging (`error_log(...)`), and
- user-friendly message via `$_SESSION["mensagem"]` + redirect, and/or
- exception handling (once PDO is adopted).

---

## Recommended “fix patterns” (safe, repeatable)

### Replace corrupted emojis with Font Awesome icons
Instead of embedding emoji characters (which are very sensitive to encoding), use:
- Back: `<i class="fas fa-arrow-left"></i>`
- Edit: `<i class="fas fa-edit"></i>`
- New: `<i class="fas fa-plus-circle"></i>`
- Search: `<i class="fas fa-search"></i>`
- Delete: `<i class="fas fa-trash"></i>`
- Info: `<i class="fas fa-info-circle"></i>`
- Warning: `<i class="fas fa-exclamation-triangle"></i>`

### Fix corrupted text literals
Replace common mojibake strings:
- `Funciona¡rios` → `Funcionarios` (if keeping ISO) or `Funcionários` (if migrating to UTF-8)
- `Ca³digo` → `Codigo` / `Código`
- `Acaµes` → `Acoes` / `Ações`
- `Voc�` → `Voce` / `Você`
- `n�o` → `nao` / `não`

### Standardize meta charset (use UTF-8)
- `<meta charset="UTF-8">`
- `<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">` (se usado)

---

## Next step (if you confirm)

I can now **apply fixes** in the following order (fastest impact first):
1. `configuracoes.php`
2. `prodserv_sql.php`
3. Normalize charset meta (the 9 files listed above)
4. Short open tags (bulk change across 401 files)
5. Replace `or die(...)` patterns (80 files)

Padrão adotado: **UTF-8** no HTML/HTTP e **utf8mb4** no MySQL/MariaDB.

