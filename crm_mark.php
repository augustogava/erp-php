<?
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
// // // // // // // // // // // // // // // 
// QUERY // // // // // // // // // // // // 
// // // // // // // // // // // // // // // 
	if(!empty($linha_cot)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas_orcamento as vo,vendas_orcamento_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.orcamento AND vol.produto=p.id AND p.linha='$linha_cot'";
	}else if(!empty($linha_com)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas as vo,vendas_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.venda AND vol.produto=p.id AND p.linha='$linha_com'";
	}else{
		$query="SELECT * FROM clientes as c WHERE 1";
	}
	if(!empty($ramo)){
		$query.=" AND c.ramo='$ramo'";
	}
	if(!empty($fcao)){
		$query.=" AND c.acao='$fcao'";
	}
	if(!empty($contato)){
		$query.=" AND c.linha='$contato'";
	}
	if(!empty($autonomia)){
		$query.=" AND c.autonomia='$autonomia'";
	}
	if(!empty($grupo)){
		$query.=" AND c.grupo='$grupo'";
	}
	if(!empty($porte)){
		$query.=" AND (c.porte_che='$porte' or c.porte_fun='$porte' or c.porte_fat='$porte')";
	}
	if(!empty($estado)){
		$query.=" AND c.estado='$estado'";
	}
	if(!empty($cidade)){
		$query.=" AND c.cidade LIKE '%$cidade%'";
	}
	$query.=" ORDER By c.nome ASC";
	$acao=$bd->pega_ultimo_bd("crm_acao","id");
	$cli=mysql_query($query);
	//print $query;
	while($res=mysql_fetch_array($cli)){
		mysql_query("INSERT INTO crm_acaor (acao,cliente) VALUES('$acao','$res[id]')");
	}
// END QUERY // // // // // // // / // // //
// // // // // // // // // // // // // // // 
	if($sql){
		$_SESSION["mensagem"]="Ação incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A ação não pôde ser incluída!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$custo_total=valor2banco($custo_total);
	$custo=valor2banco($custo);
// // // // // // // // // // // // // // // 
// QUERY // // // // // // // // // // // // 
// // // // // // // // // // // // // // // 
	if(!empty($linha_cot)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas_orcamento as vo,vendas_orcamento_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.orcamento AND vol.produto=p.id AND p.linha='$linha_cot'";
	}else if(!empty($linha_com)){
		$query="SELECT DISTINCT(c.id) as id FROM clientes as c,vendas as vo,vendas_list as vol,prodserv as p WHERE vo.cliente=c.id AND vo.id=vol.venda AND vol.produto=p.id AND p.linha='$linha_com'";
	}else{
		$query="SELECT * FROM clientes as c WHERE 1";
	}
	if(!empty($ramo)){
		$query.=" AND c.ramo='$ramo'";
	}
	if(!empty($fcao)){
		$query.=" AND c.acao='$fcao'";
	}
	if(!empty($contato)){
		$query.=" AND c.linha='$contato'";
	}
	if(!empty($autonomia)){
		$query.=" AND c.autonomia='$autonomia'";
	}
	if(!empty($grupo)){
		$query.=" AND c.grupo='$grupo'";
	}
	if(!empty($porte)){
		$query.=" AND (c.porte_che='$porte' or c.porte_fun='$porte' or c.porte_fat='$porte')";
	}
	if(!empty($estado)){
		$query.=" AND c.estado='$estado'";
	}
	if(!empty($cidade)){
		$query.=" AND c.cidade LIKE '%$cidade%'";
	}
	$query.=" ORDER By c.nome ASC";
	$cli=mysql_query($query);
	//print $query;
	mysql_query("DELETE FROM crm_acaor WHERE acao='$id'");
	while($res=mysql_fetch_array($cli)){
			mysql_query("INSERT INTO crm_acaor (acao,cliente) VALUES('$id','$res[id]')");
	}
// END QUERY // // // // // // // / // // //
// // // // // // // // // // // // // // //  
	$sql=mysql_query("UPDATE crm_acao SET nome='$nome',custo_total='$custo_total',custo='$custo',ramo='$ramo',grupo='$grupo',linha_prod_cot='$linha_cot',linha_prod_com='$linha_com',estado='$estado',cidade='$cidade',porte='$porte',arq='$arq',contato='$contato',autonomia='$autonomia',acao='$facao',tipo='$tipo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Ação alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A ação não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM crm_acao WHERE id='$id'");
			$sql=mysql_query("DELETE FROM crm_acaor WHERE acao='$id'");
		if($sql){
			$_SESSION["mensagem"]="Ação excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A ação não pôde ser excluída!";
		}		
	}
	$acao="entrar";
}else if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM crm_acao WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--

function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Nome');
		cad.nome.focus();
		return false;
	}
	return true;
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">A&ccedil;&otilde;es de Marketing </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
        <? if($acao=="entrar"){ ?>
		<tr> 
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="crm_mark.php?acao=inc" class="textobold">Incluir A&ccedil;&atilde;o Marketing </a> </div></td>
              </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="58">&nbsp;Data</td>
                <td width="145">Nome A&ccedil;&atilde;o</td>
                <td width="55">Tipo</td>
                <td width="32">Qtd</td>
                <td width="72">Custo Total</td>
                <td width="92">Custo Un.+Post.</td>
                <td width="76">Situa&ccedil;&atilde;o</td>
                <td width="16">&nbsp;</td>
                <td width="14">&nbsp;</td>
                <td width="23">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM crm_acao ORDER BY data DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="10" align="center" class="textobold">NENHUMA AÇÂO 
                  CADASTRADO </td>
              </tr>
			  <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<? print banco2data($res["data"]); ?></td>
                <td><? print $res["nome"]; ?></td>
                <td><? if($res["tipo"]=="1"){ print "Etiqueta"; }else{ print "Email"; } ?></td>
                <td><? $qtd=mysql_query("SELECT * FROM crm_acaor WHERE acao='$res[id]'"); print mysql_num_rows($qtd); ?></td>
                <td><? print banco2valor($res["custo_total"]); ?></td>
                <td><? print banco2valor($res["custo"]); ?></td>
                <td width="76" align="left"><? if($res["sit"]=="1"){ print "Não Enviado"; }else{ print "Enviado"; } ?></td>
                <td width="16" align="center"><a href="#" onClick="return abre('<? if($res["tipo"]=="1"){ print "etiq2.php?id=$res[id]"; }else{ print "crm_mark_sql.php?acao=email&id=$res[id]"; } ?>','a','width=620,height=500,scrollbars=1');"><img src="imagens/icon14_mail.gif" width="16" height="10" border="0" alt="<? if($res["tipo"]=="1"){ print "Gerar Etiquetas"; }else{ print "Enviar Email"; } ?>"></a></td>
                <td width="14" align="center"><a href="crm_mark.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="23" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta ação?','crm_mark.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?
			  	}
			  }
			  ?>
            </table>
          </td>
        </tr>
		<? }elseif($acao=="inc" or $acao=="alt"){ ?>
        <tr> 
          <td><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return verifica(this)">
              <table width="500" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <? if($acao=="inc"){ print"Incluir Ação"; }else{ print"Alterar Ação";} ?>                  </td>
                </tr>
                <tr> 
                  <td width="141" class="textobold">&nbsp;Nome</td>
                  <td width="359" class="texto"><span class="textobold">
                    <input name="nome" type="text" class="formulario" id="nome" value="<? print $res["nome"]; ?>" size="45" maxlength="50">
                  </span></td>
                </tr>
                
                <tr>
                  <td class="textobold">&nbsp;Custo Total </td>
                  <td class="textobold"><input name="custo_total" type="text" class="formulario" id="nome" value="<? print  banco2valor($res["custo_total"]); ?>" size="10" maxlength="20" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">                  </td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Custo Unit&aacute;rio + Post. </td>
                  <td class="textobold"><input name="custo" type="text" class="formulario" id="nome" value="<? print banco2valor($res["custo"]); ?>" size="10" maxlength="20" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">                  </td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Tipo</td>
                  <td class="textobold"><input name="tipo" value="1" type="radio" <? if($res["tipo"]=="1") print "checked"; ?> onClick="form1.arq.disabled=true;">
                    Etiquetas 
                    <input name="tipo" type="radio" value="2" <? if($res["tipo"]=="2") print "checked"; ?> onClick="form1.arq.disabled=false;">
                    Email</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold"> URL:
                  <input name="arq" type="text" class="textopreto" id="arq" value="<? print $res["arq"]; ?>"></td>
                </tr>
				<? if($res["tipo"]=="1"){ ?><script>form1.arq.disabled=true;</script><? } ?>
                <tr>
                  <td colspan="2" class="textoboldbranco"> &nbsp;Selecionar&nbsp;Clientes por </td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Linha Prod. Cotado </td>
                  <td class="textobold"><select name="linha_cot" class="formularioselect" id="linha">
                      <option value="">Selecione</option>
                      <option value="1" <? if($res["linha_prod_cot"]=="1") print "selected"; ?>>Equipamentos</option>
                      <option value="2" <? if($res["linha_prod_cot"]=="2") print "selected"; ?>>Merchandesing</option>
                      <option value="3" <? if($res["linha_prod_cot"]=="3") print "selected"; ?>>Comunica&ccedil;&atilde;o Visual</option>
                  </select></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Linha Prod. Comprada </td>
                  <td class="textobold"><select name="linha_com" class="formularioselect" id="linha_com">
                      <option value="">Selecione</option>
                      <option value="1" <? if($res["linha_prod_com"]=="1") print "selected"; ?>>Equipamentos</option>
                      <option value="2" <? if($res["linha_prod_com"]=="2") print "selected"; ?>>Merchandesing</option>
                      <option value="3" <? if($res["linha_prod_com"]=="3") print "selected"; ?>>Comunica&ccedil;&atilde;o Visual</option>
                  </select></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Ramo Atividade </td>
                  <td class="textobold"><select name="ramo" class="textobold" id="select3">
                    <option value="" selected="selected">Selecione</option>
                    <? $sql2=mysql_query("select * from ramo");
			while($res2=mysql_fetch_array($sql2)){
			 ?>
                    <option value="<?= $res2["id"]; ?>" <? if($res["ramo"]==$res2["id"]){ print "selected"; } ?>>
                    <?= $res2["nome"]; ?>
                    </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Grupo</td>
                  <td class="textobold"><select name="grupo" class="textobold" id="grupo">
                    <option value="" selected="selected">Selecione</option>
                    <? $sql2=mysql_query("select * from grupos");
			while($res2=mysql_fetch_array($sql2)){
			 ?>
                    <option value="<?= $res2["id"]; ?>" <? if($res["grupo"]==$res2["id"]){ print "selected"; } ?>>
                    <?= $res2["nome"]; ?>
                    </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr class="textobold">
                  <td>&nbsp;Porte</td>
                  <td><select name="porte" class="textobold" id="porte">
                      <option value="" selected="selected">Selecione</option>
                      <option value="1" <? if($res["porte"]=="1") print "selected"; ?>>Pequeno</option>
                      <option value="2" <? if($res["porte"]=="2") print "selected"; ?>>M&eacute;dio</option>
                      <option value="3" <? if($res["porte"]=="3") print "selected"; ?>>Grande</option>
                  </select></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Estado</td>
                  <td class="textobold"><span class="texto">
                    <select name="estado" id="estado" class="formulario">
                      <option value="">Selecione</option>
                      <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                      <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$res["estado"]){ print "selected"; } ?>>
                      <?= $res2["nome"]; ?>
                      </option>
                      <? } ?>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Cidade</td>
                  <td class="textobold"><input name="cidade" type="text" class="formulario" id="cidade" value="<? print $res["cidade"]; ?>" size="40"></td>
                </tr>
                <tr>
                  <td class="textobold">Clientes Marcados </td>
                  <td class="textobold"><input name="facao" type="checkbox" id="facao" value="S" <? if($res["acao"]=="S"){ print "checked"; } ?> onClick="if(this.checked==true){ form1.contato.disabled=false; form1.autonomia[0].disabled=false; form1.autonomia[1].disabled=false; }else{ form1.contato.disabled=true; form1.autonomia[0].disabled=true; form1.autonomia[1].disabled=true; } ">
Fazer A&ccedil;&atilde;o de Marketing</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">Linha:
                    <select name="contato" id="contato">
                        <option selected="">Selecione</option>
                        <option value="equipamentos" <? if($res["contato"]=="equipamentos"){ print "selected"; } ?>>Equipamentos</option>
                        <option value="pdv" <? if($res["contato"]=="pdv"){ print "selected"; } ?>>PDV+</option>
                        <option value="geral" <? if($res["contato"]=="geral"){ print "selected"; } ?>>Geral</option>
                      </select>
                    &nbsp;</td>
                </tr>
                <tr align="center">
                  <td class="textobold">&nbsp;</td>
                  <td align="left" class="textobold"><input name="autonomia" type="radio" value="d" <? if($res["autonomia"]=="d"){ print "checked"; } ?>>
Decisor
  <input name="autonomia" type="radio" value="i" <? if($res["autonomia"]=="i"){ print "checked"; } ?>>
Influenciador</td>
                </tr>
                <tr align="center"> 
                  <td colspan="2" class="textobold"><input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>">
                  <span class="texto">
                  <input name="id" type="hidden" id="id3" value="<? print $id; ?>">
                  </span></td>
                </tr>
              </table>
            </form></td>
        </tr>
		<? } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>