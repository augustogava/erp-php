<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(empty($acao)){ $acao="entrar"; }
if(!empty($acao)){
	$loc="Fornecedores Site";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="exc"){
	$sql=mysql_query("DELETE FROM proposta_itens WHERE id='$id'");
}else if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM proposta_itens WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}else if($acao=="alterar"){
	$altura=valor2banco($altura);
	$largura=valor2banco($largura);
	$profundidade=valor2banco($profundidade);
	$peso_l=valor2banco($peso_l);
	$peso_b=valor2banco($peso_b);
	$frete=valor2banco($frete);
	$icms=valor2banco($icms);
	$ipi=valor2banco($ipi);
	$pf=valor2banco($pf);
	//Imagem
	if(!empty($foto)){
		$nm=$_FILES["foto"]["name"];
		$destino="foto/".$nm;
		$copiar=copy($foto,$destino);
		$query=",imagem='$nm'";
	}
	//
	$sql=mysql_query("UPDATE proposta_itens SET nome='$nome',codigo='$codigo',unidade='$unidade',embalagem='$embalagem',altura='$altura',largura='$largura',profundidade='$profundidade',peso_l='$peso_l',peso_b='$peso_b',prazo='$prazo',frete='$frete',icms='$icms',ipi='$ipi',qtd_minimo='$qtd_minimo',pf='$pf',garantia='$garantia',descricao='$descricao',espec='$espec',contato='$contato',tel='$tel',email='$email'$query WHERE id='$id'");
	if($sql){
		header("Location:fornecedores_site_list.php?p=$p");
	}else{
		print "<script>window.alert('Não pôde ser Alterado, entre em contato com Administrador do site!');window.location='proposta_itens.php?p=$p&acao=entrar';</script>";
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
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
            <tr>
              <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
              <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Fornecedores / Produtos </div></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        
		
		<? if($acao=="entrar"){ ?>
        <tr>
          <td><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr class="textoboldbranco">
              <td width="84" align="center">C&oacute;d</td>
              <td width="460">&nbsp;Nome</td>
              <td width="22">&nbsp;</td>
              <td width="23">&nbsp;</td>
            </tr>
            <?
			  $sql=mysql_query("SELECT * FROM proposta_itens WHERE proposta='$p' ORDER BY id DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
            <tr class="texto">
              <td colspan="4" align="center" bgcolor="#FFFFFF" class="textobold">NENHUM PRODUTO ENCONTRADO </td>
            </tr>
            <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
            <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
              <td align="center" ><? print $res["id"]; ?></td>
              <td >&nbsp;<? print $res["nome"]; ?></td>
              <td align="center" ><a href="fornecedores_site_list.php?acao=alt&id=<?= $res["id"]; ?>&p=<?= $p; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
              <td align="center" ><a href="#" onClick="pergunta('Deseja excluir fornecedor?','fornecedores_site_list.php?id=<?= $res[id]; ?>&acao=exc');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
            </tr>
            <?
			  	}
			  }
			  ?>
          </table></td>
        </tr>
		<? }else if($acao=="alt"){ ?>
		<tr>
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)" enctype="multipart/form-data">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="textopreto">
		  <? if(!empty($res["imagem"])){ ?>
            <tr>
              <td colspan="2" align="center"><img src="foto/<?= $res["imagem"]; ?>" width="120"></td>
            </tr>
			<? } ?>
            <tr>
              <td width="28%" class="textobold"><span class="style5">Nome Produto </span> </td>
              <td width="72%"><input name="nome" type="text" class="formulario" id="nome" value="<? print $res["nome"]; ?>" size="40"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">C&oacute;digo Produto </span></td>
              <td><input name="codigo" type="text" class="formulario" id="codigo" value="<? print $res["codigo"]; ?>" size="40"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Unidade</span></td>
              <td>
                <select name="unidade" class="formularioselect" id="select5">
                  <?
$sqlr=mysql_query("SELECT * FROM unidades ORDER BY apelido ASC");
while($resr=mysql_fetch_array($sqlr)){
?>
                  <option value="<? print $resr["id"]; ?>"<? if($res["unidade"]==$resr["id"]) print "selected"; ?>><? print($resr["apelido"]); ?></option>
                  <? } ?>
                </select>
             </td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Embalagem</span></td>
              <td><input name="embalagem" type="text" class="formulario" id="embalagem" value="<? print $res["embalagem"]; ?>" size="40"></td>
            </tr>
            <tr>
              <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="preto style8 style11">
                  <tr>
                    <td width="35%"><span class="textobold">Altura</span> 
                    <input name="altura" type="text" class="formulario" id="altura" value="<? print banco2valor($res["altura"]); ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" size="10"></td>
                    <td width="31%"><span class="textobold">Largura</span> 
                    <input name="largura" type="text" class="formulario" id="largura" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["largura"]); ?>" size="10"></td>
                    <td width="34%"><span class="textobold">Profundidade</span> 
                    <input name="profundidade" type="text" class="formulario" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" id="profundidade" value="<? print banco2valor($res["profundidade"]); ?>" size="10"></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Peso L&iacute;quido </span></td>
              <td><input name="peso_l" type="text" class="formulario" id="peso_l" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["peso_l"]); ?>" size="10"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Peso Bruto </span></td>
              <td><input name="peso_b" type="text" class="formulario" id="peso_b" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["peso_b"]); ?>" size="10"></td>
            </tr>
            <tr>
              <td class="textobold"><STRONG>Disponibilidade</STRONG></td>
              <td><span class="textobold">
                <select name="prazo" id="prazo">
                  <option value="1" <? if($res["prazo"]=="1") print "selected"; ?>>1</option>
                  <option value="2" <? if($res["prazo"]=="2") print "selected"; ?>>2</option>
                  <option value="3" <? if($res["prazo"]=="3") print "selected"; ?>>3</option>
                  <option value="4" <? if($res["prazo"]=="4") print "selected"; ?>>4</option>
                  <option value="5" <? if($res["prazo"]=="5") print "selected"; ?>>5</option>
                  <option value="6" <? if($res["prazo"]=="6") print "selected"; ?>>6</option>
                  <option value="7" <? if($res["prazo"]=="7") print "selected"; ?>>7</option>
                  <option value="8" <? if($res["prazo"]=="8") print "selected"; ?> >8</option>
                  <option value="9" <? if($res["prazo"]=="9") print "selected"; ?>>9</option>
                  <option value="10" <? if($res["prazo"]=="10") print "selected"; ?>>10</option>
                  <option value="11" <? if($res["prazo"]=="11") print "selected"; ?>>11</option>
                  <option value="12" <? if($res["prazo"]=="12") print "selected"; ?>>12</option>
                </select>
              Dias</span></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Frete</span></td>
              <td><input name="frete" type="text" class="formulario" id="frete" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["frete"]); ?>" size="10"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Al&iacute;quota ICMS </span></td>
              <td><input name="icms" type="text" class="formulario" id="icms" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["icms"]); ?>" size="10"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Al&iacute;quota IPI</span></td>
              <td><input name="ipi" type="text" class="formulario" id="ipi" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["ipi"]); ?>" size="10"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Qtd M&iacute;nima Pedido </span></td>
              <td><input name="qtd_minimo" type="text" class="formulario" id="qtd_minimo" value="<? print $res["qtd_minimo"]; ?>" size="10"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Pre&ccedil;o Final </span></td>
              <td><input name="pf" type="text" class="formulario" id="pf" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($res["pf"]); ?>" size="10"></td>
            </tr>
            <tr>
              <td height="13" class="textobold"><span class="style5">Garantia</span></td>
              <td><input name="garantia" type="text" class="formulario" id="garantia" value="<? print $res["garantia"]; ?>" size="10"></td>
            </tr>
            <tr>
              <td valign="top" class="textobold"><span class="style5">Descri&ccedil;&atilde;o Curta </span></td>
              <td><textarea name="descricao" cols="40" rows="5" class="preto" id="descricao"><? print $res["descricao"]; ?></textarea></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Especifica&ccedil;&otilde;es T&eacute;c. </span></td>
              <td><textarea name="espec" cols="40" rows="2" class="preto" id="espec"><? print $res["espec"]; ?></textarea></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Imagem</span></td>
              <td><input name="foto" type="file" class="css2" id="foto" size="30" value="<? print $res["imagem"]; ?>"></td>
            </tr>
            

            <tr>
              <td class="textobold"><span class="style5">Contato do Produto </span></td>
              <td><input name="contato" type="text" class="formulario" id="contato" value="<? print $res["contato"]; ?>" size="30"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Telefone do Contato </span></td>
              <td><input name="tel" type="text" class="formulario" id="tel" value="<? print $res["tel"]; ?>" size="15"></td>
            </tr>
            <tr>
              <td class="textobold"><span class="style5">Email do Contato </span></td>
              <td><input name="email" type="text" class="formulario" id="email" value="<? print $res["email"]; ?>" size="30"></td>
            </tr>
            <tr>
              <td colspan="2" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center"><input name="p" type="hidden" id="p" value="<? print $p ?>" />
              <input name="id" type="hidden" id="id" value="<? print $id; ?>" />
                <input name="acao" type="hidden" id="acao" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>" />
                <input name="Submit2" type="submit" class="preto" value="Enviar"></td>
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