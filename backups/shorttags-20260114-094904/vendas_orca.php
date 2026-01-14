<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Vendas Orçamento";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="entrar"){
	if(empty($bde)){
		$bde=date("d/m/Y");
		$bate=date("d/m/Y");
	}
	$busca=" WHERE ";
	if(!empty($bde)){
		$bde=data2banco($bde);
		$busca.=" vendas_orc.emissao>='$bde' ";
		$bde=banco2data($bde);
		if(!empty($bate)){
			$bate=data2banco($bate);
			$busca.="AND vendas_orc.emissao<='$bate' ";
			$bate=banco2data($bate);
		}
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM vendas_orc WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$sql=mysql_query("SELECT nome FROM clientes WHERE id='$res[cliente]'");
	if(mysql_num_rows($sql)){
		$rest=mysql_fetch_array($sql);
		$res["nome"]=$rest["nome"];
	}	
	$sql=mysql_query("SELECT * FROM cliente_contato WHERE id='$res[contato]'");
	if(mysql_num_rows($sql)){
		$rest=mysql_fetch_array($sql);
		$res["contatonome"]=$rest["nome"];
	}	
}else if($acao=="canc"){
	$data=date("Y-m-d");
	$hora=hora();
	
	switch($mot){
		case 1:
			$motivo="Concorrência";
			break;
		case 2:
			$motivo="Investimento futuro";
			break;
		case 3:
			$motivo="Prazo";
			break;
		case 4:
			$motivo="Qualidade";
			break;
		case 5:
			$motivo="Outros";
			break;
	}
	$sql=mysql_query("UPDATE vendas_orc SET sit='2',motivo='$mot' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Orçamento cancelada com sucesso!";
		header("location:vendas_orca.php");
		exit;
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
/*
function verificabusca(cad){
	if(cad.emissao.value!=''){
		if(!verifica_data(cad.emissao.value)){
			alert('Data de emissão incorreta');
			cad.emissao.focus();
			return false;
		}
		if(!verifica_data(cad.emissao2.value)){
			cad.emissao2.value='';
		}
	}
	return true;
}
*/
function abrenovo(codal,alt,lar){
	alt = eval(alt.replace(",","."));
	lar = eval(lar.replace(",","."));
	abre('vendas_orc_prod.php?line='+codal+'&altura='+alt+'&largura='+lar+'&abre=S','busca','width=620,height=300,scrollbars=1');
}

function verifica(cad){
	if(cad.vendedor.value==''){
		alert('Selecione o Vendedor');
		cad.vendedor.focus();
		return false;
	}
	if(cad.cliente.value==''){
		alert('Selecione o Cliente');
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td colspan="2" align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Or&ccedil;amentos</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><img src="imagens/dot.gif" width="20" height="5"></td>
  </tr>
<?
if($acao=="entrar"){
?>
  <tr>
    <td colspan="2" align="left" valign="top"><form name="formbus" method="post" action="" onSubmit="return verificabusca(this);">
      <table width="274" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
        </tr>
        <tr class="textobold">
          <td width="63">&nbsp;Per&iacute;odo:</td>
          <td width="211"><input name="bde" type="text" class="formulario" id="bde2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= $bde; ?>" size="7" maxlength="10">
&nbsp;&agrave;&nbsp;
      <input name="bate" type="text" class="formulario" id="bate2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= $bate; ?>" size="7" maxlength="10">
&nbsp;
<input name="Submit2" type="submit" class="microtxt" value="Buscar">
<input name="buscar" type="hidden" id="buscar" value="true"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="textobold"><a href="vendas_orca_sql.php?acao=inc" class="textobold">novo orçamento </a></td>
      </tr>
    </table>
    <table width="611" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">

<?
$sqlc=mysql_query("SELECT distinct(vendas_orc.vendedor),clientes.nome as nome FROM vendas_orc,clientes WHERE vendas_orc.vendedor=clientes.id AND vendas_orc.sit='0'");
if(!mysql_num_rows($sqlc)){

?>
<tr class="textoboldbranco">
        <td colspan="6" align="center">Nada encontrado </td>
        </tr>
<?
}else{
	while($resc=mysql_fetch_array($sqlc)){
		$sql=mysql_query("SELECT vendas_orc.*,clientes.nome FROM vendas_orc,clientes $busca AND vendas_orc.vendedor='$resc[vendedor]' AND vendas_orc.sit='0' AND vendas_orc.vendedor=clientes.id  ORDER BY vendas_orc.emissao ASC");
		if(!mysql_num_rows($sql)){
	}else{
?>
      <tr class="textoboldbranco">
        <td colspan="6" align="left">&nbsp;<?= $resc["nome"]; ?></td>
        </tr>
      
<?
 		while($res=mysql_fetch_array($sql)){
			$vendedor[$resc["nome"]]+=$res["valor"];
?>
      <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td width="64" align="center"><?= $res["id"]; ?></td>
        <td width="326">&nbsp;<?= $res["nome"]; ?></td>
        <td width="76" align="right"><?= banco2valor($res["valor"]); ?>&nbsp;</td>
        <?  if(empty($res["sit"])){ $java2="window.location='$_SERVER[PHP_SELF]?acao=alt&id=$res[id]';"; }else{ $java2="window.alert('Proposta já virou venda!');"; } ?>
        <td width="17" align="center"><a href="#" onClick="<?= $java2; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
        <td width="16" align="center"><a href="#" onMouseOver="this.T_STICKY=true; this.T_TITLE='Qual o Motivo do cancelamento?'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=1&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Concorrência</a> <br> <a href=vendas_orcaa.php?acao=canc&id=<?= $res[id]; ?>&mot=2&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Investimento futuro <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=3&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Prazo <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=4&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Qualidade <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=5&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Outros')"><img src="imagens/icon14_cancelar3.gif" alt="Cancelar Proposta" width="16" height="16" border="0"></a></td>
        <td width="16" align="center"><a href="#" onClick="pergunta('Deseja excluir este orçamento?','vendas_orca_sql.php?id=<?= $res["id"]; ?>&acao=exc');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
      </tr>
<?
		}
	}
}
}
?>
    </table>
    <br>    
<? if(isset($vendedor)){ ?>
<table width="270" border="0" align="right" cellpadding="0" cellspacing="1" bgcolor="#003366" class="texto">
  <tr bgcolor="#003366" class="textoboldbranco">
    <td width="188">Vendedor</td>
    <td width="79" align="right">Valor</td>
  </tr>
<? foreach($vendedor as $key=>$valor){ ?>
  <tr bgcolor="#FFFFFF">
    <td width="188"><?= print "$key"; ?></td>
    <td width="79" align="right">&nbsp;<? print banco2valor($vendedor[$key]); ?></td>
  </tr>
<? } ?>
</table>
<? } ?></td>
  </tr>
  <tr>
    <td colspan="2"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
<?
}elseif($acao=="alt"){
?>
<form name="form1" method="post" action="vendas_orca_sql.php" onSubmit="return verifica(this);">
  <tr>
    <td colspan="2" align="left" valign="top" bgcolor="#003366" class="textoboldbranco">&nbsp;<? if($acao=="alt"){ print "Alterar"; }else{ print "Incluir"; } ?> orçamento </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="textobold">
        <td>C&oacute;digo</td>
        <td>&nbsp;</td>
        <td colspan="6" rowspan="2"><table width="99%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="textobold">A&ccedil;&atilde;o Marketing </td>
            <td class="textobold">Vendedor</td>
          </tr>
          <tr>
            <td><select name="acaom" class="formularioselect" id="acaom">
                <option value="" >Selecione</option>
                <?
				$query="SELECT * FROM crm_acao $query ORDER BY data DESC";
				$sql=mysql_query($query);
				while($res1=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res1["id"]; ?>" <? if($res["acao"]==$res1["id"]) print "selected"; ?>><? print banco2data($res1["data"])." - ".$res1["nome"]; ?></option>
                <? } ?>
            </select></td>
            <td><select name="vendedor" class="formularioselect" id="vendedor">
              <option value="" selected>Selecione</option>
              <?
$sqlv=mysql_query("SELECT c.fantasia,c.id FROM clientes AS c, cliente_login AS cl, niveis AS n WHERE cl.nivel=n.id AND n.vendedor=1 AND cl.cliente=c.id ORDER BY c.fantasia ASC");
if(mysql_num_rows($sqlv)){
	while($resv=mysql_fetch_array($sqlv)){
?>
              <option value="<?= $resv["id"]; ?>" <? if($resv["id"]==$res["vendedor"]) print "selected"; ?>>
              <?= $resv["fantasia"]; ?>
              </option>
              <?
	}
}
?>
            </select></td>
          </tr>
        </table>
          </td>
        </tr>
      <tr class="textobold">
        <td><input name="cod" type="text" class="formularioselect" id="cod" value="<? if(empty($res["cod"])){ print "$id/".date("Y"); }else{ print $res["cod"]; } ?>" size="10" maxlength="10" readonly=""></td>
        <td>&nbsp;</td>
        </tr>
      <tr class="textobold">
        <td width="97">Cliente</td>
        <td width="18">&nbsp;</td>
        <td width="97">&nbsp;</td>
        <td width="18">&nbsp;</td>
        <td width="97">&nbsp;</td>
        <td width="18">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="27">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="7"><input name="cliente" type="text" class="formularioselect" id="cliente" value="<? print $res["cliente"]; ?>"></td>
        <td align="center"><a href="#" onClick="return abre('vendas_cliorc.php','a','width=320,height=380,scrollbars=1');"></a></td>
        </tr>
      <tr class="textobold">
        <td>Telefone</td>
        <td>&nbsp;</td>
        <td>Email</td>
        <td>&nbsp;</td>
        <td>Emiss&atilde;o</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="textobold">
        <td><input name="telefone" type="text" class="formularioselect" id="telefone" value="<? print $res["telefone"]; ?>"></td>
        <td>&nbsp;</td>
        <td><input name="email" type="text" class="formularioselect" id="email" value="<? print $res["email"]; ?>"></td>
        <td>&nbsp;</td>
        <td><input name="emissao" type="text" class="formularioselect" id="emissao" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print banco2data($res["emissao"]); ?>" size="10" maxlength="10"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr>
        <td bgcolor="#FFFFFF"><table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#003366">
          <tr class="textoboldbranco">
            <td width="22" align="center">&nbsp;</td>
            <td width="35">Qtd.</td>
            <td width="48">Largura</td>
            <td width="37">Altura</td>
            <td width="150">Descri&ccedil;&atilde;o</td>
            <td width="14" align="center">&nbsp;</td>
            <td width="142">Local</td>
            <td width="55">Unit&aacute;rio</td>
            <td width="50">Desc % </td>
            <td width="47">Total</td>
            </tr>
<?
$sql=mysql_query("SELECT * FROM vendas_orc_list WHERE orcamento='$id'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO vendas_orc_list (orcamento) VALUES ('$id')");
	$sql=mysql_query("SELECT * FROM vendas_orc_list WHERE orcamento='$id'");
}
if(mysql_num_rows($sql)){
	while($resl=mysql_fetch_array($sql)){
		if($resl["produto"]){
			$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resl[produto]'");
			$resp=mysql_fetch_array($sqlp);

			$sqlp2=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'");
			$resp2=mysql_fetch_array($sqlp2);

			$resl["unidade"]=$resp2["apelido"];
			$resl["prod"]=$resp["nome"];
		}
		$sqlm=mysql_query("SELECT * FROM material WHERE id='$resl[material]'");
		$resm=mysql_fetch_array($sqlm);
		$prods+=$resl["qtd"]*$resl["unitario"];
		$descs+=$resl["qtd"]*$resl["unitario"]*$resl["desconto"]/100;
		$tots=$prods-$descs;
?>
		  <tr bgcolor="#FFFFFF">
            <td align="center"><input name="del[<?= $resl["id"]; ?>]" type="checkbox" id="del<?= $resl["id"]; ?>" value="<?= $resl["id"]; ?>"></td>
			<input name="material[<?= $resl["id"]; ?>]" type="hidden" id="material<?= $resl["id"]; ?>" value="<?= $res["contato"]; ?>">
            <td width="35"><input name="qtd[<?= $resl["id"]; ?>]" type="text" class="formularioselect" id="qtd<?= $resl["id"]; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?= banco2valor($resl["qtd"]); ?>" size="1"></td>
            <td width="48"><input name="largura[<?= $resl["id"]; ?>]2" type="text" class="formularioselect" id="largura<?= $resl["id"]; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"  value="<?= banco2valor($resl["largura"]); ?>" size="1"></td>
            <td width="37"><input name="altura[<?= $resl["id"]; ?>]" type="text" class="formularioselect" id="altura<?= $resl["id"]; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"  value="<?= banco2valor($resl["altura"]); ?>" size="1"></td>
            <td><input name="descricao[<?= $resl["id"]; ?>]" type="text" class="formularioselect" id="descricao<?= $resl["id"]; ?>" size="1" readonly="" value="<?= $resl["prod"]." - $resm[apelido]"; ?>" onMouseOver="this.T_TITLE='Foto'; this.T_DELAY=10; this.T_WIDTH=70;  return escape('<img src=<? if(!empty($resp["foto"])){ ?>foto/gd.php?img=<? print $resp["foto"]; ?>&wid=60<? }else{ print "imagens/semFoto.jpg"; }; ?>>')"></td>
            <td align="center"><a href="#" onClick="abrenovo('<?= $resl["id"]; ?>',form1.altura<?= $resl["id"]; ?>.value,form1.largura<?= $resl["id"]; ?>.value);"><img src="imagens/icon_14_search.gif" width="14" height="14" border="0"></a></td>
            <td width="142"><input name="local[<?= $resl["id"]; ?>]2" type="text" class="formularioselect" id="local[<?= $resl["id"]; ?>]" size="1" value="<?= $resl["local"]; ?>"></td>
            <input name="prodserv[<?= $resl["id"]; ?>]" type="hidden" id="prodserv<?= $resl["id"]; ?>" value="<?= $resl["produto"] ?>">
            <td width="55"><input name="unitario[<?= $resl["id"]; ?>]" type="text" class="formularioselect" id="unitario<?= $resl["id"]; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?= banco2valor($resl["unitario"]); ?>" size="1"></td>
            <td width="50"><input name="desconto[<?= $resl["id"]; ?>]" type="text" class="formularioselect" id="desconto<?= $resl["id"]; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?= banco2valor($resl["desconto"]); ?>" size="1"></td>
            <td width="47"><input name="total[<?= $resl["id"]; ?>]" type="text" class="formularioselect" id="total<?= $resl["id"]; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?= banco2valor(($resl["qtd"]*$resl["unitario"])-($resl["qtd"]*$resl["unitario"]*$resl["desconto"])/100); ?>" size="1" readonly=""></td>
            </tr>
<?
	}
}
?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
  
  <tr>
    <td colspan="2" align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
    </tr>
  <tr>
    <td width="227" align="left" valign="top">&nbsp;</td>
    <td width="381" align="right" valign="top"><table width="360" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr align="center" class="textoboldbranco">
          <td width="120">Produtos</td>
          <td width="120">Descontos</td>
          <td width="120">Total</td>
        </tr>
        <tr align="center" bgcolor="#FFFFFF" class="textobold">
          <td width="120"><?= banco2valor($prods); ?></td>
          <td width="120"><?= banco2valor($descs); ?></td>
          <td width="120"><?= banco2valor($tots); ?></td>
        </tr>
        </table></td>
  </tr>
  
  <tr>
    <td colspan="2" align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><span class="textobold">
      <input name="Submit223" type="button" class="microtxt" value="voltar" onClick="window.location='vendas_orca.php'">
      &nbsp;&nbsp;&nbsp;
      <input name="Submit22322" type="button" class="microtxt" value="Cancelar" onMouseOver="this.T_STICKY=true; this.T_TITLE='Qual o Motivo do cancelamento?'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=1&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Concorrência</a> <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=2&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Investimento futuro <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=3&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Prazo <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=4&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Qualidade <br> <a href=vendas_orca.php?acao=canc&id=<?= $res[id]; ?>&mot=5&cliente=<?= $res[cliente]; ?>&vendedor=<?= $resc[vendedor]; ?>>Outros')">
  &nbsp;&nbsp;&nbsp;
      <input name="Submit22222" type="submit" class="microtxt" value="Adicionar Linhas" onClick="form1.maisum.value='1';">
   &nbsp;&nbsp;&nbsp;       
      <input name="Submit2222" type="submit" class="microtxt" value="Excluir Linhas" onClick="form1.delsel.value='1';">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   
        <input name="Submit222" type="button" class="microtxt" value="Gerar Proposta" onClick="return pergunta('Deseja gerar a proposta?','vendas_orca_sql.php?acao=gvenda&id=<?= $id; ?>');">
       &nbsp;&nbsp;&nbsp;
        <input name="Submit22" type="submit" class="microtxt" value="Continuar" onClick="form1.continuar.value='1';">
        <input name="acao" type="hidden" id="acao" value="alt">
        <input name="maisum" type="hidden" id="maisum">
        <input name="delsel" type="hidden" id="delsel">
		<input name="continuar" type="hidden" id="continuar">
        <input name="id" type="hidden" id="id" value="<?= $id; ?>">
</span></td>
  </tr>
  </form>
 <? } ?>
</table>

</body>
</html>
<? include("mensagem.php"); ?>
<script language="javascript" src="tooltip.js"></script>