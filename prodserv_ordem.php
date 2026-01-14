<?php
include("conecta.php");
include("seguranca.php");
if($buscar){
	unset($wp);
}
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Ordem Producao";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="baixa"){
	$sql=mysql_query("UPDATE prodserv_ordem,e_compra SET prodserv_ordem.sit='F',e_compra.sit='P' WHERE prodserv_ordem.id='$id' AND prodserv_ordem.compra=e_compra.id");
	$sql=mysql_query("UPDATE prodserv_sep_list,prodserv_ordem SET prodserv_sep_list.sit='3' WHERE prodserv_sep_list.pedido='$ped' AND prodserv_sep_list.prodserv=prodserv_ordem.prodserv");
	//baixa produzidos estoque
	$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$ped'");
	while($res=mysql_fetch_array($sql2)){
		//POrta//
		$produto=$res["produto"];
		$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
		$pror=mysql_fetch_array($pro);
			if(!empty($pror["porta"])){
				//Medida
					$porta=$pror["porta"];
					$dado=explode("X",$res["medidas"]);
						$altura=$dado[0];
						$largura=$dado[1];
					//
						$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
						while($ress=mysql_fetch_array($sqls)){
							$tota+=$ress["val"]*$ress["qtd"];
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','6')");
						}
						$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
						$resp=mysql_fetch_array($sqlp);
						$sql2=mysql_query("SELECT * FROM perfil WHERE id='$resp[perfil]'");
						$res2=mysql_fetch_array($sql2);
						$cs=pvccs($porta,$largura,$altura);
						$ci=pvcci($porta,$largura,$altura);
						$cr=pvccr($porta,$largura,$altura);
						$perfil=perfil($resp["perfil"],$largura,$altura);
						$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc_superior]','$hj','$cs','2','6')");
						$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc_inferior]','$hj','$ci','2','6')");
						$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc_cristal]','$hj','$cr','2','6')");
						$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res2[perfil]','$hj','$perfil','2','6')");
			}
		//Porta
		 // Cortinaa
			if(!empty($pror["cortina"])){
					$cortina=$pror["cortina"];
					//Medida
						$dado=explode("X",$tamanho);
							$altura=$dado[0];
							$largura=$dado[1];
					//Fim medida
					$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
					while($ress=mysql_fetch_array($sqls)){
						$tota+=$ress["val"]*$ress["qtd"];
						$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','2')");
					}
					$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$cortina'");
					$resp=mysql_fetch_array($sqlp);
							
					$a=cortinas($largura,$altura);
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[trilho]','$hj','$a[trilho]','2','6')");
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc]','$hj','$a[pvc]','2','6')");
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[arrebites]','$hj','$a[arrebites]','2','6')");
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[parafusos]','$hj','$a[parafusos]','2','6')");
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[buchas]','$hj','$a[buchas]','2','6')");
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[penduralg]','$hj','$a[penduralg]','2','6')");
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[penduralp]','$hj','$a[penduralp]','2','6')");
				//Fim Cortina
		}
	}
	// Fim produzidos

	if($sql){
		$_SESSION["mensagem"]="Baixa com Sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="Nao pode ser dado Baixa!";
	}
}
if(!isset($sit)) $sit="A";
$busca="WHERE prodserv_ordem.sit='$sit' ";
if(!empty($item)){
	$busca.="AND prodserv.ordem.prodserv='$item' ";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Ordem de Producao - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.bde.value!='' || cad.bate.value!=''){
		if(!verifica_data(cad.bde.value)){
			alert('Periodo incorreto');
			cad.bde.focus();
			return false;
		}
		if(!verifica_data(cad.bate.value)){
			alert('Periodo incorreto');
			cad.bate.focus();
			return false;
		}
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-industry"></i> Ordem de Producao</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?php echo (strpos($_SESSION["mensagem"],'Sucesso')!==false) ? 'success' : 'danger'; ?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:16px;color:#2c3e50;"><i class="fas fa-search"></i> Busca</h3>
        <form name="form1" method="post" action="" onSubmit="return verifica(this);">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Produto</label>
                        <div style="display:flex;gap:8px;">
                            <input name="nome" type="text" class="erp-form-control" id="nome3" readonly style="background:#f8f9fa;">
                            <a href="#" onClick="return abre('prodserv_bus2.php','busca','width=320,height=300,scrollbars=1');" class="erp-btn erp-btn-outline">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Situacao</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="sit" type="radio" value="A" <?php if($sit=="A") echo "checked"; ?>> Abertas
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="sit" type="radio" value="F" <?php if($sit=="F") echo "checked"; ?>> Finalizadas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <input name="buscar" type="hidden" value="true">
                        <input name="item" type="hidden" id="item">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <?php 
    $sqlc=mysql_query("SELECT * FROM prodserv_cat ORDER By texto ASC"); 
    while($catr=mysql_fetch_array($sqlc)){ 
        $cat=$catr["id"]; 
        $sql=mysql_query("SELECT *,prodserv_ordem.id as idd FROM prodserv_ordem,prodserv $busca AND prodserv_ordem.prodserv=prodserv.id AND prodserv.ecat='$cat' ORDER BY prodserv_ordem.id ASC");
        if(mysql_num_rows($sql)){
    ?>
    <div class="erp-card" style="margin-bottom:16px;">
        <h4 style="margin-bottom:16px;font-size:15px;color:#2c3e50;background:#e9ecef;padding:12px;border-radius:8px;">
            <i class="fas fa-folder"></i> <?php echo $catr["texto"]; ?>
        </h4>
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th width="80">Compra</th>
                        <th width="80">Pedido</th>
                        <th>Produto</th>
                        <th width="120">Status</th>
                        <th width="80" class="erp-text-center">Qtd</th>
                        <th width="150" class="erp-text-center">Acoes</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while($res=mysql_fetch_array($sql)){
                    $sql2=mysql_query("SELECT nome FROM prodserv WHERE id='$res[prodserv]'");
                    $res2=mysql_fetch_array($sql2);
                    if($res["sit"]=="A"){
                        $walt="prodserv_ordem_baixa.php?acao=entrar&id=$res[idd]&ped=$res[pedido]";
                    }else{
                        $walt="";
                    }
                    $st="";
                    $st_class="info";
                    switch($res["status"]){
                        case "1":
                            $st="Na fila";
                            $st_class="warning";
                            break;
                        case "2":
                            $st="Em producao";
                            $st_class="info";
                            break;
                        case "3":
                            $st="Produzido";
                            $st_class="success";
                            break;
                    }
                ?>
                <tr>
                    <td><strong>#<?php echo $res["compra"]; ?></strong></td>
                    <td>#<?php echo $res["pedido"]; ?></td>
                    <td><?php echo $res2["nome"]; ?></td>
                    <td><span class="erp-badge erp-badge-<?php echo $st_class; ?>"><?php echo $st; ?></span></td>
                    <td class="erp-text-center"><?php echo banco2valor($res["qtd"]); ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="prodserv_ordem_abre.php?acao=alt&id=<?php echo $res["idd"]; ?>" class="erp-table-action" title="Alterar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="window.open('prodserv_ordem_imp.php?id=<?php echo $res["idd"]; ?>','','scrollbars=yes,width=730,height=500');" class="erp-table-action" title="Visualizar">
                                <i class="fas fa-print"></i>
                            </a>
                            <?php if($res["sit"]=="A"): ?>
                            <a href="#" onclick="window.open('<?php echo $walt; ?>','','scrollbars=yes,width=730,height=500');" class="erp-table-action" title="Baixar" style="color:#27ae60;">
                                <i class="fas fa-check-circle"></i>
                            </a>
                            <?php else: ?>
                            <span class="erp-table-action" style="color:#ccc;cursor:not-allowed;" title="Ordem ja finalizada">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php 
        }
    } 
    ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
