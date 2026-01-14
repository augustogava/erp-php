<?
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Importar Clientes";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="importar" && isset($_FILES["arquivo"])){
	$arquivo_temp = $_FILES["arquivo"]["tmp_name"];
	$arquivo_nome = $_FILES["arquivo"]["name"];
	$extensao = pathinfo($arquivo_nome, PATHINFO_EXTENSION);
	
	if($extensao != "txt" && $extensao != "csv"){
		$_SESSION["mensagem"]="Erro: Arquivo deve ser .txt ou .csv!";
		header("Location:imp_cliente.php");
		exit;
	}
	
	$linhas = file($arquivo_temp);
	$importados = 0;
	$erros = 0;
	$log_erros = array();
	
	foreach($linhas as $num_linha => $linha){
		$pt = explode(";", trim($linha));
		
		if(count($pt) < 14) continue;
		
		$grupo = ($pt[3]=="Matriz") ? "52" : "42";
		
		$sql = mysql_query("SELECT id FROM ramo WHERE nome='".addslashes($pt[2])."'");
		$res = mysql_fetch_array($sql);
		$ramo = $res["id"] ?? "";
		
		$nome = addslashes($pt[0]);
		$fantasia = addslashes($pt[1]);
		$cidade = addslashes($pt[12]);
		$endereco = addslashes($pt[9]);
		$loja = addslashes($pt[4]);
		
		$sel = mysql_query("SELECT * FROM clientes WHERE nome='$nome'");
		if(!mysql_num_rows($sel)){
			$sela = mysql_query("SELECT * FROM clientes WHERE cep='$pt[11]' AND nome='$nome'");
			if(!mysql_num_rows($sela)){
				$insert = mysql_query("INSERT INTO clientes (nome,fantasia,loja,grupo,porte_che,ramo,endereco,bairro,cep,estado,cidade,fone,fone2,fax,status,origem_cad,sit) VALUES('$nome','$fantasia','$loja','$grupo','$pt[8]','$ramo','$endereco','$pt[10]','$pt[11]','$pt[13]','$cidade','$pt[5]','$pt[6]','$pt[7]','A','importacao','A')");
				
				if($insert){
					$importados++;
				}else{
					$erros++;
					$log_erros[] = "Linha ".($num_linha+1).": Erro ao inserir - ".$nome;
				}
			}else{
				$erros++;
				$log_erros[] = "Linha ".($num_linha+1).": Duplicado (CEP) - ".$nome;
			}
		}else{
			$erros++;
			$log_erros[] = "Linha ".($num_linha+1).": Ja existe - ".$nome;
		}
	}
	
	$_SESSION["mensagem"] = "Importacao concluida! $importados clientes importados, $erros erros.";
	$_SESSION["log_erros"] = $log_erros;
	header("Location:imp_cliente.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Importar Clientes - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-file-import"></i> Importar Clientes</h1>
            <div>
                <a href="clientes.php" class="erp-btn erp-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?=strpos($_SESSION["mensagem"],'concluida')!==false||strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION["log_erros"]) && count($_SESSION["log_erros"]) > 0): ?>
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:18px;color:#dc3545;"><i class="fas fa-triangle-exclamation"></i> Log de Erros</h3>
        <div style="max-height:300px;overflow-y:auto;background:#fff;padding:12px;border:1px solid #dee2e6;border-radius:8px;">
            <?php 
            foreach($_SESSION["log_erros"] as $erro){
                echo '<div style="padding:8px;border-bottom:1px solid #f0f0f0;color:#6c757d;">'.$erro.'</div>';
            }
            unset($_SESSION["log_erros"]);
            ?>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="erp-row">
        <div class="erp-col">
            <div class="erp-card">
                <h3 style="margin-bottom:16px;font-size:18px;color:#2c3e50;"><i class="fas fa-upload"></i> Upload do Arquivo</h3>
                
                <form method="post" action="imp_cliente.php" enctype="multipart/form-data">
                    <input type="hidden" name="acao" value="importar">
                    
                    <div class="erp-form-group">
                        <label class="erp-form-label">Selecione o arquivo (.txt ou .csv)</label>
                        <input type="file" name="arquivo" class="erp-form-control" accept=".txt,.csv" required>
                    </div>
                    
                    <div class="erp-alert erp-alert-warning" style="margin-bottom:16px;">
                        <strong><i class="fas fa-triangle-exclamation"></i> Atencao:</strong> Certifique-se de que o arquivo esta no formato correto antes de importar.
                    </div>
                    
                    <button type="submit" class="erp-btn erp-btn-success" style="width:100%;">
                        <i class="fas fa-file-import"></i> Importar Clientes
                    </button>
                </form>
            </div>
        </div>
        
        <div class="erp-col">
            <div class="erp-card">
                <h3 style="margin-bottom:16px;font-size:18px;color:#2c3e50;"><i class="fas fa-list"></i> Formato do Arquivo</h3>
                
                <p style="color:#6c757d;margin-bottom:16px;">
                    O arquivo deve conter os dados separados por ponto e va­rgula (;) na seguinte ordem:
                </p>
                
                <div style="background:#f8f9fa;padding:12px;border-radius:8px;margin-bottom:16px;">
                    <code style="display:block;color:#2c3e50;font-size:13px;line-height:1.6;">
                        0. Nome<br>
                        1. Fantasia<br>
                        2. Ramo<br>
                        3. Matriz/Filial<br>
                        4. Loja<br>
                        5. Telefone 1<br>
                        6. Telefone 2<br>
                        7. Fax<br>
                        8. Porte<br>
                        9. Endereco<br>
                        10. Bairro<br>
                        11. CEP<br>
                        12. Cidade<br>
                        13. UF
                    </code>
                </div>
                
                <div class="erp-alert erp-alert-info">
                    <strong><i class="fas fa-lightbulb"></i> Exemplo de linha:</strong><br>
                    <code style="font-size:12px;">Empresa ABC;ABC Ltda;Coma©rcio;Matriz;01;1133334444;1122223333;1144445555;Ma©dio;Rua Exemplo 123;Centro;01234-567;Sao Paulo;SP</code>
                </div>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:18px;color:#2c3e50;"><i class="fas fa-circle-info"></i> Regras de Importacao</h3>
        
        <div class="erp-row">
            <div class="erp-col">
                <div style="padding:12px;background:#d4edda;border-radius:8px;border-left:4px solid #28a745;">
                    <strong style="color:#155724;"><i class="fas fa-check"></i> Sera importado:</strong>
                    <ul style="margin:8px 0 0 20px;color:#155724;">
                        <li>Clientes novos (nome nao cadastrado)</li>
                        <li>CEP unico para cada cliente</li>
                        <li>Dados completos e validos</li>
                    </ul>
                </div>
            </div>
            
            <div class="erp-col">
                <div style="padding:12px;background:#fff3cd;border-radius:8px;border-left:4px solid #ffc107;">
                    <strong style="color:#856404;"><i class="fas fa-xmark"></i> Sera ignorado:</strong>
                    <ul style="margin:8px 0 0 20px;color:#856404;">
                        <li>Clientes duplicados (mesmo nome)</li>
                        <li>CEP ja cadastrado para o mesmo cliente</li>
                        <li>Linhas com dados incompletos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<? include("mensagem.php"); ?>
</body>
</html>
