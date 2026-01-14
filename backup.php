<?php
include("conecta.php");
include("seguranca.php");

$nivel=$_SESSION["login_nivel"];

if(!empty($acao)){
	$loc="Backup Sistema";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="gerar"){
	header('Content-Type: application/octetstream');
	header("Content-Disposition: inline; filename=backup_".date("Y-m-d_His").".zip");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	
	$tudo = `mysqldump -u$user -p$pwd $bd`;
	$tudo = str_replace("--","#",$tudo);
	
	$arq1 = "$bd.sql";
	$com1 = $tudo;
	
	flush();
	
	class zipfile {
		var $datasec = array();
		var $ctrl_dir = array();
		var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
		var $old_offset = 0;
		
		function unix2DosTime($unixtime = 0) {
			$timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
			if ($timearray['year'] < 1980) {
				$timearray['year'] = 1980;
				$timearray['mon'] = 1;
				$timearray['mday'] = 1;
				$timearray['hours'] = 0;
				$timearray['minutes'] = 0;
				$timearray['seconds'] = 0;
			}
			return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
				($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
		}
		
		function addFile($data, $name, $time = 0) {
			$name = str_replace('\\', '/', $name);
			$dtime = dechex($this->unix2DosTime($time));
			$hexdtime = '\x' . $dtime[6] . $dtime[7] . '\x' . $dtime[4] . $dtime[5] . '\x' . $dtime[2] . $dtime[3] . '\x' . $dtime[0] . $dtime[1];
			eval('$hexdtime = "' . $hexdtime . '";');
			
			$fr = "\x50\x4b\x03\x04";
			$fr .= "\x14\x00";
			$fr .= "\x00\x00";
			$fr .= "\x08\x00";
			$fr .= $hexdtime;
			
			$unc_len = strlen($data);
			$crc = crc32($data);
			$zdata = gzcompress($data);
			$zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
			$c_len = strlen($zdata);
			$fr .= pack('V', $crc);
			$fr .= pack('V', $c_len);
			$fr .= pack('V', $unc_len);
			$fr .= pack('v', strlen($name));
			$fr .= pack('v', 0);
			$fr .= $name;
			$fr .= $zdata;
			$fr .= pack('V', $crc);
			$fr .= pack('V', $c_len);
			$fr .= pack('V', $unc_len);
			
			$this->datasec[] = $fr;
			$new_offset = strlen(implode('', $this->datasec));
			
			$cdrec = "\x50\x4b\x01\x02";
			$cdrec .= "\x00\x00";
			$cdrec .= "\x14\x00";
			$cdrec .= "\x00\x00";
			$cdrec .= "\x08\x00";
			$cdrec .= $hexdtime;
			$cdrec .= pack('V', $crc);
			$cdrec .= pack('V', $c_len);
			$cdrec .= pack('V', $unc_len);
			$cdrec .= pack('v', strlen($name));
			$cdrec .= pack('v', 0);
			$cdrec .= pack('v', 0);
			$cdrec .= pack('v', 0);
			$cdrec .= pack('v', 0);
			$cdrec .= pack('V', 32);
			$cdrec .= pack('V', $this->old_offset);
			$this->old_offset = $new_offset;
			$cdrec .= $name;
			$this->ctrl_dir[] = $cdrec;
		}
		
		function file() {
			$data = implode('', $this->datasec);
			$ctrldir = implode('', $this->ctrl_dir);
			return $data . $ctrldir . $this->eof_ctrl_dir . pack('v', sizeof($this->ctrl_dir)) . pack('v', sizeof($this->ctrl_dir)) . pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
		}
	}
	
	$zip = new zipfile();
	$zip->addFile($com1, $arq1);
	$strzip = $zip->file();
	print $strzip;
	exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Backup do Sistema - ERP System</title>
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
            <h1 class="erp-card-title"><i class="fas fa-database"></i> Backup do Sistema</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?php echo strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-row">
        <div class="erp-col">
            <div class="erp-card">
                <h3 style="margin-bottom:16px;font-size:18px;color:#2c3e50;"><i class="fas fa-box"></i> Gerar Backup Completo</h3>
                <p style="color:#6c757d;margin-bottom:24px;">
                    Gera um arquivo ZIP contendo toda a estrutura e dados do banco de dados.<br>
                    O backup inclui todas as tabelas e registros do sistema.
                </p>
                
                <div class="erp-alert erp-alert-info" style="margin-bottom:24px;">
                    <strong><i class="fas fa-info-circle"></i> Informacoes:</strong><br>
                    <i class="fas fa-circle" style="font-size:6px;margin-right:8px;"></i> Banco de dados: <strong><?php echo $bd?></strong><br>
                    <i class="fas fa-circle" style="font-size:6px;margin-right:8px;"></i> Servidor: <strong><?php echo $host?></strong><br>
                    <i class="fas fa-circle" style="font-size:6px;margin-right:8px;"></i> Data/Hora: <strong><?php echo date("d/m/Y H:i:s")?></strong>
                </div>
                
                <form method="post" action="backup.php" onsubmit="return confirm('Deseja gerar o backup agora?');">
                    <input type="hidden" name="acao" value="gerar">
                    <button type="submit" class="erp-btn erp-btn-success" style="width:100%;padding:16px;font-size:16px;">
                        <i class="fas fa-download"></i> Gerar Backup Agora
                    </button>
                </form>
            </div>
        </div>
        
        <div class="erp-col">
            <div class="erp-card">
                <h3 style="margin-bottom:16px;font-size:18px;color:#2c3e50;"><i class="fas fa-book"></i> Informacoes sobre Backup</h3>
                
                <div style="padding:12px;background:#f8f9fa;border-radius:8px;margin-bottom:12px;">
                    <strong style="color:#2c3e50;"><i class="fas fa-check-circle" style="color:#27ae60;"></i> O que e incluido:</strong>
                    <ul style="margin:8px 0 0 20px;color:#6c757d;">
                        <li>Estrutura completa das tabelas</li>
                        <li>Todos os dados cadastrados</li>
                        <li>Relacionamentos e indices</li>
                    </ul>
                </div>
                
                <div style="padding:12px;background:#fff3cd;border-radius:8px;margin-bottom:12px;border-left:4px solid #ffc107;">
                    <strong style="color:#856404;"><i class="fas fa-exclamation-triangle"></i> Recomendacoes:</strong>
                    <ul style="margin:8px 0 0 20px;color:#856404;">
                        <li>Faca backups regulares (diarios)</li>
                        <li>Armazene em local seguro</li>
                        <li>Teste a restauracao periodicamente</li>
                        <li>Mantenha multiplas copias</li>
                    </ul>
                </div>
                
                <div style="padding:12px;background:#d1ecf1;border-radius:8px;border-left:4px solid #17a2b8;">
                    <strong style="color:#0c5460;"><i class="fas fa-lightbulb"></i> Dica:</strong>
                    <p style="margin:8px 0 0 0;color:#0c5460;">
                        O arquivo gerado pode ser restaurado usando ferramentas como phpMyAdmin ou linha de comando MySQL.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:18px;color:#2c3e50;"><i class="fas fa-chart-bar"></i> Estatisticas do Banco de Dados</h3>
        
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>Tabela</th>
                        <th>Registros</th>
                        <th>Tamanho</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = mysql_query("SHOW TABLE STATUS");
                    $total_size = 0;
                    $total_rows = 0;
                    
                    while($res = mysql_fetch_array($sql)){
                        $size = ($res["Data_length"] + $res["Index_length"]) / 1024;
                        $total_size += $size;
                        $total_rows += $res["Rows"];
                        
                        echo '<tr>';
                        echo '<td>'.$res["Name"].'</td>';
                        echo '<td>'.number_format($res["Rows"], 0, ',', '.').'</td>';
                        echo '<td>'.number_format($size, 2, ',', '.').' KB</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr style="background:#f8f9fa;font-weight:bold;">
                        <td>TOTAL</td>
                        <td><?php echo number_format($total_rows, 0, ',', '.')?></td>
                        <td><?php echo number_format($total_size, 2, ',', '.')?> KB</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
