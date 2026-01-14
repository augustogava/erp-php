<?php
include("conecta.php");
include("seguranca.php");
$bd=new set_bd;
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Acao Marketing";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
$data=date("Y-m-d");
if($acao=="incluir"){
	$custo_total=valor2banco($custo_total);
	$custo=valor2banco($custo);
	$sql=mysql_query("INSERT INTO crm_acao (nome,data,custo_total,custo,ramo,grupo,linha_prod_cot,linha_prod_com,estado,cidade,porte,tipo,arq,contato,autonomia,acao) VALUES ('$nome','$data','$custo_total','$custo','$ramo','$grupo','$linha_cot','$linha_com','$estado','$cidade','$porte','$tipo','$arq','$contato','$autonomia','$facao')");
	if(!empty($linha_cot)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas_orcamento as vo,vendas_orcamento_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.orcamento AND vol.produto=p.id AND p.linha='$linha_cot'";
	}else if(!empty($linha_com)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas as vo,vendas_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.venda AND vol.produto=p.id AND p.linha='$linha_com'";
	}else{
		$query="SELECT * FROM clientes as c WHERE 1";
	}
	if(!empty($ramo)) $query.=" AND c.ramo='$ramo'";
	if(!empty($fcao)) $query.=" AND c.acao='$fcao'";
	if(!empty($contato)) $query.=" AND c.linha='$contato'";
	if(!empty($autonomia)) $query.=" AND c.autonomia='$autonomia'";
	if(!empty($grupo)) $query.=" AND c.grupo='$grupo'";
	if(!empty($porte)) $query.=" AND (c.porte_che='$porte' or c.porte_fun='$porte' or c.porte_fat='$porte')";
	if(!empty($estado)) $query.=" AND c.estado='$estado'";
	if(!empty($cidade)) $query.=" AND c.cidade LIKE '%$cidade%'";
	$query.=" ORDER By c.nome ASC";
	$acao_id=$bd->pega_ultimo_bd("crm_acao","id");
	$cli=mysql_query($query);
	while($res=mysql_fetch_array($cli)){
		mysql_query("INSERT INTO crm_acaor (acao,cliente) VALUES('$acao_id','$res[id]')");
	}
	if($sql){
		$_SESSION["mensagem"]="Acao incluida com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A acao nao pode ser incluida!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$custo_total=valor2banco($custo_total);
	$custo=valor2banco($custo);
	if(!empty($linha_cot)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas_orcamento as vo,vendas_orcamento_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.orcamento AND vol.produto=p.id AND p.linha='$linha_cot'";
	}else if(!empty($linha_com)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas as vo,vendas_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.venda AND vol.produto=p.id AND p.linha='$linha_com'";
	}else{
		$query="SELECT * FROM clientes as c WHERE 1";
	}
	if(!empty($ramo)) $query.=" AND c.ramo='$ramo'";
	if(!empty($fcao)) $query.=" AND c.acao='$fcao'";
	if(!empty($contato)) $query.=" AND c.linha='$contato'";
	if(!empty($autonomia)) $query.=" AND c.autonomia='$autonomia'";
	if(!empty($grupo)) $query.=" AND c.grupo='$grupo'";
	if(!empty($porte)) $query.=" AND (c.porte_che='$porte' or c.porte_fun='$porte' or c.porte_fat='$porte')";
	if(!empty($estado)) $query.=" AND c.estado='$estado'";
	if(!empty($cidade)) $query.=" AND c.cidade LIKE '%$cidade%'";
	$query.=" ORDER By c.nome ASC";
	$cli=mysql_query($query);
	mysql_query("DELETE FROM crm_acaor WHERE acao='$id'");
	while($res=mysql_fetch_array($cli)){
		mysql_query("INSERT INTO crm_acaor (acao,cliente) VALUES('$id','$res[id]')");
	}
	$sql=mysql_query("UPDATE crm_acao SET nome='$nome',custo_total='$custo_total',custo='$custo',ramo='$ramo',grupo='$grupo',linha_prod_cot='$linha_cot',linha_prod_com='$linha_com',estado='$estado',cidade='$cidade',porte='$porte',arq='$arq',contato='$contato',autonomia='$autonomia',acao='$facao',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Acao alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A acao nao pode ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM crm_acao WHERE id='$id'");
		$sql=mysql_query("DELETE FROM crm_acaor WHERE acao='$id'");
		if($sql){
			$_SESSION["mensagem"]="Acao excluida com sucesso!";
		}else{
			$_SESSION["mensagem"]="A acao nao pode ser excluida!";
		}		
	}
	$acao="entrar";
}else if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM crm_acao WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Acoes de Marketing - ERP System</title>
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
	if(cad.nome.value==''){
		alert('Informe o Nome');
		cad.nome.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-bullhorn"></i> Acoes de Marketing</h1>
            <?php if($acao=="entrar"): ?>
            <a href="crm_mark.php?acao=inc" class="erp-btn erp-btn-primary">
                + Nova Acao
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
                    <th width="100">Data</th>
                    <th>Nome Acao</th>
                    <th width="80">Tipo</th>
                    <th width="60">Qtd</th>
                    <th width="100">Custo Total</th>
                    <th width="120">Custo Un.+Post.</th>
                    <th width="100">Situacao</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM crm_acao ORDER BY data DESC");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="8" class="erp-text-center" style="padding:40px;">Nenhuma acao cadastrada</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
                    $qtd=mysql_query("SELECT * FROM crm_acaor WHERE acao='$res[id]'");
            ?>
                <tr>
                    <td><?php echo banco2data($res["data"]); ?></td>
                    <td><?php echo $res["nome"]; ?></td>
                    <td><?php echo ($res["tipo"]=="1") ? "Etiqueta" : "Email"; ?></td>
                    <td><?php echo mysql_num_rows($qtd); ?></td>
                    <td><?php echo banco2valor($res["custo_total"]); ?></td>
                    <td><?php echo banco2valor($res["custo"]); ?></td>
                    <td>
                        <?php if($res["sit"]=="1"){ ?>
                        <span class="erp-badge erp-badge-warning">Nao Enviado</span>
                        <?php }else{ ?>
                        <span class="erp-badge erp-badge-success">Enviado</span>
                        <?php } ?>
                    </td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="#" onclick="return abre('<?php echo ($res["tipo"]=="1") ? "etiq2.php?id=$res[id]" : "crm_mark_sql.php?acao=email&id=$res[id]"; ?>','a','width=620,height=500,scrollbars=1');" class="erp-table-action" title="<?php echo ($res["tipo"]=="1") ? "Gerar Etiquetas" : "Enviar Email"; ?>">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="crm_mark.php?acao=alt&id=<?php echo $res["id"]; ?>" class="erp-table-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Deseja excluir esta acao?','crm_mark.php?acao=exc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Excluir" style="color:#e74c3c;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php }elseif($acao=="inc" or $acao=="alt"){ 
        if($acao!="alt") $res = array();
    ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <?php echo ($acao=="inc") ? "Incluir Acao" : "Alterar Acao"; ?>
        </h3>
        <form action="" method="post" enctype="multipart/form-data" name="form1" onsubmit="return verifica(this)">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome</label>
                        <input name="nome" type="text" class="erp-form-control" value="<?php echo isset($res["nome"]) ? $res["nome"] : ''; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Custo Total</label>
                        <input name="custo_total" type="text" class="erp-form-control" value="<?php echo isset($res["custo_total"]) ? banco2valor($res["custo_total"]) : ''; ?>" maxlength="20" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Custo Unitario + Post.</label>
                        <input name="custo" type="text" class="erp-form-control" value="<?php echo isset($res["custo"]) ? banco2valor($res["custo"]) : ''; ?>" maxlength="20" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tipo</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="tipo" value="1" type="radio" <?php if(!isset($res["tipo"]) || $res["tipo"]=="1") echo "checked"; ?> onclick="form1.arq.disabled=true;"> Etiquetas
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="tipo" type="radio" value="2" <?php if(isset($res["tipo"]) && $res["tipo"]=="2") echo "checked"; ?> onclick="form1.arq.disabled=false;"> Email
                            </label>
                        </div>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">URL</label>
                        <input name="arq" type="text" class="erp-form-control" value="<?php echo isset($res["arq"]) ? $res["arq"] : ''; ?>" <?php if(!isset($res["tipo"]) || $res["tipo"]=="1") echo "disabled"; ?>>
                    </div>
                </div>
            </div>
            
            <h4 style="margin:24px 0 16px 0;font-size:16px;color:#2c3e50;border-bottom:1px solid #dee2e6;padding-bottom:8px;">
                Selecionar Clientes por
            </h4>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Linha Prod. Cotado</label>
                        <select name="linha_cot" class="erp-form-control">
                            <option value="">Selecione</option>
                            <option value="1" <?php if(isset($res["linha_prod_cot"]) && $res["linha_prod_cot"]=="1") echo "selected"; ?>>Equipamentos</option>
                            <option value="2" <?php if(isset($res["linha_prod_cot"]) && $res["linha_prod_cot"]=="2") echo "selected"; ?>>Merchandesing</option>
                            <option value="3" <?php if(isset($res["linha_prod_cot"]) && $res["linha_prod_cot"]=="3") echo "selected"; ?>>Comunicacao Visual</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Linha Prod. Comprada</label>
                        <select name="linha_com" class="erp-form-control">
                            <option value="">Selecione</option>
                            <option value="1" <?php if(isset($res["linha_prod_com"]) && $res["linha_prod_com"]=="1") echo "selected"; ?>>Equipamentos</option>
                            <option value="2" <?php if(isset($res["linha_prod_com"]) && $res["linha_prod_com"]=="2") echo "selected"; ?>>Merchandesing</option>
                            <option value="3" <?php if(isset($res["linha_prod_com"]) && $res["linha_prod_com"]=="3") echo "selected"; ?>>Comunicacao Visual</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Ramo Atividade</label>
                        <select name="ramo" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php $sql2=mysql_query("select * from ramo");
                            while($res2=mysql_fetch_array($sql2)){ ?>
                            <option value="<?=$res2["id"]?>" <?php if(isset($res["ramo"]) && $res["ramo"]==$res2["id"]) echo "selected"; ?>><?=$res2["nome"]?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Grupo</label>
                        <select name="grupo" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php $sql2=mysql_query("select * from grupos");
                            while($res2=mysql_fetch_array($sql2)){ ?>
                            <option value="<?=$res2["id"]?>" <?php if(isset($res["grupo"]) && $res["grupo"]==$res2["id"]) echo "selected"; ?>><?=$res2["nome"]?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Porte</label>
                        <select name="porte" class="erp-form-control">
                            <option value="">Selecione</option>
                            <option value="1" <?php if(isset($res["porte"]) && $res["porte"]=="1") echo "selected"; ?>>Pequeno</option>
                            <option value="2" <?php if(isset($res["porte"]) && $res["porte"]=="2") echo "selected"; ?>>Medio</option>
                            <option value="3" <?php if(isset($res["porte"]) && $res["porte"]=="3") echo "selected"; ?>>Grande</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Estado</label>
                        <select name="estado" class="erp-form-control">
                            <option value="">Selecione</option>
                            <?php $sql2=mysql_query("SELECT * FROM estado");
                            while($res2=mysql_fetch_array($sql2)){ ?>
                            <option value="<?=$res2["id"]?>" <?php if(isset($res["estado"]) && $res2["id"]==$res["estado"]) echo "selected"; ?>><?=$res2["nome"]?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade</label>
                        <input name="cidade" type="text" class="erp-form-control" value="<?php echo isset($res["cidade"]) ? $res["cidade"] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input name="facao" type="checkbox" value="S" <?php if(isset($res["acao"]) && $res["acao"]=="S") echo "checked"; ?> onclick="if(this.checked==true){ form1.contato.disabled=false; }else{ form1.contato.disabled=true; }">
                            Fazer Acao de Marketing em Clientes Marcados
                        </label>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Linha</label>
                        <select name="contato" class="erp-form-control" <?php if(!isset($res["acao"]) || $res["acao"]!="S") echo "disabled"; ?>>
                            <option value="">Selecione</option>
                            <option value="equipamentos" <?php if(isset($res["contato"]) && $res["contato"]=="equipamentos") echo "selected"; ?>>Equipamentos</option>
                            <option value="pdv" <?php if(isset($res["contato"]) && $res["contato"]=="pdv") echo "selected"; ?>>PDV+</option>
                            <option value="geral" <?php if(isset($res["contato"]) && $res["contato"]=="geral") echo "selected"; ?>>Geral</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Autonomia</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="autonomia" type="radio" value="d" <?php if(isset($res["autonomia"]) && $res["autonomia"]=="d") echo "checked"; ?>> Decisor
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="autonomia" type="radio" value="i" <?php if(isset($res["autonomia"]) && $res["autonomia"]=="i") echo "checked"; ?>> Influenciador
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='crm_mark.php'">
                    Voltar
                </button>
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>
            <input name="acao" type="hidden" value="<?php echo ($acao=="alt") ? "alterar" : "incluir"; ?>">
            <input name="id" type="hidden" value="<?php echo $id; ?>">
        </form>
    </div>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
