<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$sel=Input::request("sel");
$bd=new set_bd;
if(empty($acao)) $acao="entrar";
$where="WHERE prodserv_sep.sit='P' AND vendas.id=prodserv_sep.pedido AND prodserv_sep.cliente=clientes.id AND prodserv_sep.status='2' ";
if($acao=="incluir"){
	$hj=date("Y-m-d");
	$sql=mysql_query("SELECT * FROM romaneio WHERE data='$hj'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
		$id_ro=$res["id"];
	}else{
		mysql_query("INSERT INTO romaneio (data) VALUES('$hj')");
		$sqla=mysql_query("SELECT MAX(id) as id FROM romaneio");
		$res=mysql_fetch_array($sqla);
		$id_ro=$res["id"];
	}
	if(isset($sel) && is_array($sel)){
		foreach($sel as $key=>$valor){
			mysql_query("INSERT INTO romaneio_itens (romaneio,separacao) VALUES('$id_ro','$valor')");
			mysql_query("UPDATE prodserv_sep SET status='3' WHERE id='$valor'");
			$sel_q=mysql_query("SELECT * FROM prodserv_sep WHERE id='$valor'");
			$rsel=mysql_fetch_array($sel_q);
			$cp=$rsel["compra"];
			$pedido=$rsel["pedido"];
			$id=$rsel["id"];
			$sql=mysql_query("SELECT * FROM prodserv_sep WHERE compra='$cp'");
			$res=mysql_fetch_array($sql); 
			$cli=$res["cliente"];
			$sqlp=mysql_query("SELECT id FROM vendas WHERE id='$res[pedido]'");
			$resp=mysql_fetch_array($sqlp);
			$pedido=$resp["id"];
			$sqlc=mysql_query("SELECT * FROM e_compra WHERE id='$cp'");
			$resc=mysql_fetch_array($sqlc);
			$pagamento=$resc["pagamento"];
			$sqls=mysql_query("SELECT * FROM prodserv_sep_list WHERE est='$id' and sit='5'");
			$passar = "s";
			while($ress=mysql_fetch_array($sqls)){
				$sqle=mysql_query("SELECT SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$ress[prodserv]'");
				$rese=mysql_fetch_array($sqle);
				if($rese["qtdd"]<=0){ 
				}
			}
			if($passar!="n"){
				$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE compra='$cp' AND sit='A'");
				$sqla=mysql_query("UPDATE e_compra SET sit='F' WHERE id='$cp'");
				if($pagamento=="boleto"){
					$sqlb=mysql_query("UPDATE prodserv_sep SET sit='S' WHERE id='$id'");
					$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$pedido'");
					while($res=mysql_fetch_array($sql2)){
						if(!empty($res["produto"])){
							$produto=$res["produto"];
							$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
							$pror=mysql_fetch_array($pro);
							if(!($pror["tipo"]=="SM")){
								$qtd=$res["qtd"];
								$total=banco2valor($qtd*$res["unitario"]);
								$total=valor2banco($total);
								$unita=$res["unitario"];
								$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt FROM prodserv_est WHERE prodserv='$produto'");
								$res1=mysql_fetch_array($sql1);
								if($res1["qtdt"]>0 and empty($pror["porta"]) and empty($pror["cortina"])){
									$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$produto','$hj','$qtd','$unita','2','6')");
								}
							}else{
								$dado=explode("X",$res["medidas"]);
								$altura=$dado[0];
								$largura=$dado[1];
								$qtdit=$altura*$largura;
								$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$produto','$hj','$qtdit','2','6')");
							}
						}
					}
				}else{
					$sqlc=mysql_query("select * from vendas WHERE pedido='$cp'"); $resc=mysql_fetch_array($sqlc); $natureza=$resc["natureza"];
					$sql=mysql_query("UPDATE prodserv_sep SET sit='S' WHERE id='$id'");
					$sql=mysql_query("SELECT MAX(numero) AS numero FROM nf");
					$res=mysql_fetch_array($sql);
					$numero=$res["numero"]+1;
					$sql=mysql_query("INSERT INTO nf(numero,pedido,compra,cliente,cliente_tipo,es,emissao,natureza,cfop,fatura,vis) VALUES('$numero','$pedido','$cp','$cli','C','S','$hj','$natureza','','','S')");
					$sql=mysql_query("SELECT MAX(id) AS idn FROM nf");
					$res=mysql_fetch_array($sql);
					$pro=mysql_query("SELECT * FROM e_itens WHERE compra='$cp' and produto_id<>0");
					$i=1;
					while($resp=mysql_fetch_array($pro)){
						$pro2=mysql_query("SELECT * FROM prodserv WHERE id='$resp[produto_id]'");
						$resp2=mysql_fetch_array($pro2);
						$sql=mysql_query("INSERT INTO nf_prod(nota,prodserv,codigo,unitario,descricao,qtd) VALUES('$res[idn]','$resp[produto_id]','$resp2[codprod]','$resp[produto_preco]','$resp2[desc_curta]','$resp[qtd]')");
					}
				}
			}else{
				$_SESSION["mensagem"]="Existem produtos aguardando compras nessa ordem!";
				header("Location:prodserv_oc.php");
				exit;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Romaneio - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Material');
		cad.nome.focus();
		return false;
	}
	return true;
}

function MM_openBrWindow(theURL,winName,features) {
	window.open(theURL,winName,features);
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-clipboard-list"></i> Romaneio</h1>
            <?php if($acao=="entrar"): ?>
            <a href="romaneio.php?acao=add" class="erp-btn erp-btn-primary">
                + Incluir Ordens no Romaneio
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <?php if($acao=="entrar"){ ?>
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="100">Numero</th>
                    <th>Data</th>
                    <th width="100" class="erp-text-center">Imprimir</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM romaneio ORDER By data DESC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="3" class="erp-text-center" style="padding:40px;">Nenhum registro encontrado</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><strong>#<?php echo $res["id"]; ?></strong></td>
                    <td><?php echo banco2data($res["data"]); ?></td>
                    <td class="erp-text-center">
                        <a href="#" onclick="MM_openBrWindow('romaneio_vis.php?id=<?php echo $res["id"]?>','','scrollbars=yes,width=700,height=500');" class="erp-table-action" title="Imprimir">
                            <i class="fas fa-print"></i>
                        </a>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
    <form name="form1" method="post" action="">
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <i class="fas fa-plus"></i> Incluir Ordens de Separacao no Romaneio de Hoje
        </h3>
        
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th width="80">Pedido</th>
                        <th width="100">Data</th>
                        <th>Cliente</th>
                        <th width="150">Vendedor</th>
                        <th width="100">Previsao</th>
                        <th width="150">Status</th>
                        <th width="60" class="erp-text-center">Sel.</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql=mysql_query("SELECT prodserv_sep.pedido,prodserv_sep.id,vendas.emissao,prodserv_sep.cliente as codigo,clientes.nome,vendas.previsao,prodserv_sep.status,vendas.vendedor FROM prodserv_sep,clientes,vendas $where ORDER BY prodserv_sep.pedido ASC");
                if(mysql_num_rows($sql)==0){
                ?>
                    <tr>
                        <td colspan="7" class="erp-text-center" style="padding:40px;">Nenhum registro encontrado</td>
                    </tr>
                <?php
                }else{
                    while($res=mysql_fetch_array($sql)){
                        $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[vendedor]'");
                        $res2=mysql_fetch_array($sql2);
                        $st="";
                        switch($res["status"]){
                            case "1": $st="Aguardando Compras"; break;
                            case "2": $st="Aguardando Correio"; break;
                            case "3": $st="Coletado"; break;
                            case "4": $st="Em Separacao"; break;
                            case "5": $st="Em Producao"; break;
                            case "6": $st="Agendado Entrega MKR"; break;
                            case "7": $st="Aguardando Transportadora"; break;
                            case "8": $st="Entregue"; break;
                        }
                ?>
                    <tr>
                        <td><strong>#<?php echo $res["pedido"]; ?></strong></td>
                        <td><?php echo banco2data($res["emissao"]); ?></td>
                        <td>
                            <a href="crm_infg.php?cli=<?php echo $res["codigo"]; ?>" style="color:#2c3e50;">
                                <?php echo $res["codigo"]." ".$res["nome"]; ?>
                            </a>
                        </td>
                        <td><?php echo $res2["nome"]; ?></td>
                        <td><?php echo banco2data($res["previsao"]); ?></td>
                        <td><?php echo $st; ?></td>
                        <td class="erp-text-center">
                            <input type="checkbox" name="sel[]" value="<?php echo $res["id"]?>">
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        
        <div style="display:flex;gap:12px;margin-top:20px;">
            <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='romaneio.php'">
                Voltar
            </button>
            <input name="acao" type="hidden" value="incluir">
            <button type="submit" class="erp-btn erp-btn-primary">
                <i class="fas fa-check"></i> Incluir Selecionados
            </button>
        </div>
    </div>
    </form>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
