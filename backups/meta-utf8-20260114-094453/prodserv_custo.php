<?
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT prodserv.nome,prodserv.apelido,prodserv.class,unidades.nome AS unidade FROM prodserv,unidades WHERE prodserv.id='$id' AND prodserv.unidade=unidades.id");
$res=mysql_fetch_array($sql);
$nome=$res["nome"];
$apelido=$res["apelido"];
$unidade=$res["unidade"];
$class=$res["class"];
$sql=mysql_query("SELECT * FROM prodserv_custo WHERE prodserv='$id'");
if(mysql_num_rows($sql)!=0){
	$res=mysql_fetch_array($sql);
	if($class=="I"){
		$res["ii"]=0;
		$res["di"]=0;
	}
}
//produto produzido / composto
$sql2=mysql_query("SELECT class FROM prodserv WHERE id='$id'");
if(mysql_num_rows($sql2)){
	$res2=mysql_fetch_array($sql2);
	if($res2["class"]=="C" or $res2["class"]=="P"){
		$sqlp=mysql_query("SELECT SUM(prodserv.cs*prodserv_item.qtd) AS sugestao FROM prodserv,prodserv_item WHERE prodserv_item.prodserv='$id' AND prodserv_item.item=prodserv.id");
		$resp=mysql_fetch_array($sqlp);
		$res["valor"]=$resp["sugestao"];
	}
}
//produto produzido / composto
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function ccusto(frm){
	valor=valor2real(frm.valor.value);
	qtd=valor2real(frm.qtd.value);
	icms=valor2real(frm.icms.value);
	ipi=valor2real(frm.ipi.value);
	frete=valor2real(frm.frete.value);
	seguro=valor2real(frm.seguro.value);
	ii=valor2real(frm.ii.value);
	di=valor2real(frm.di.value);
	if(qtd == 0){
		frm.qtd.value='1,00';
		qtd=1;
	}
	if(valor > 0){
		if(frm.fretev.checked){
			valor+=(frete*valor)/100;
		}else{
			valor+=frete;
		}
		if(frm.segurov.checked){
			valor+=(seguro*valor)/100;
		}else{
			valor+=seguro;
		}
		valor+=(ii*valor)/100;
		if(!frm.ipitv.checked){
			if(frm.ipiv.checked){
				valor+=(ipi*valor)/100;
			}else{
				valor+=ipi;
			}
		}
		if(!frm.icmstv.checked){
			if(frm.icmsv.checked){
				valor+=(icms*valor)/100;
			}else{
				valor+=icms;
			}
		}
		valor+=di;
		custo=valor/qtd;
	}else{
		custo=0;
	}
	frm.custo.value=real2valor(custo);
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Custo</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><form name="form1" method="post" action="prodserv_sql.php" onSubmit="return verifica(this);">
      <table width="500" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#003366">
          <td colspan="4" align="center" class="textoboldbranco">
            Custo de Aquisi&ccedil;&atilde;o </td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td width="52" class="textobold">&nbsp;Produto:</td>
          <td colspan="3" class="texto">&nbsp;<? print $nome; ?></td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td class="textobold">&nbsp;Apelido:</td>
          <td width="271" class="texto">&nbsp;<? print $apelido; ?></td>
          <td width="59" align="center" class="textobold">Unidade:</td>
          <td width="118" class="texto"><span class="texto">&nbsp;<? print $unidade; ?></span></td>
        </tr>
        <tr>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          <td align="center" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
        </tr>
        <tr>
          <td class="textobold">&nbsp;ICMS</td>
          <td colspan="3" class="textobold"><input name="icms" type="text" class="formulario" id="icms" value="<? print banco2valor($res["icms"]); ?>" size="15" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="ccusto(this.form);">
            &nbsp;
            <input name="icmsv" type="checkbox" id="icmsv" value="S" <? if($res["icmsv"]=="S") print "checked"; ?> onClick="ccusto(this.form);">
&nbsp;em % &nbsp;
<input name="icmstv" type="checkbox" id="icmstv" value="S" <? if($res["icmstv"]=="S") print "checked"; ?>  onClick="ccusto(this.form);"> 
Tributado na venda</td>
          </tr>
        <tr>
          <td class="textobold">&nbsp;IPI</td>
          <td colspan="3" class="textobold"><input name="ipi" type="text" class="formulario" id="ipi" value="<? print banco2valor($res["ipi"]); ?>" size="15" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="ccusto(this.form);">
&nbsp;
    <input name="ipiv" type="checkbox" id="ipiv" value="S" <? if($res["ipiv"]=="S") print "checked"; ?> onClick="ccusto(this.form);">
&nbsp;em % &nbsp;
    <input name="ipitv" type="checkbox" id="ipitv" value="S" <? if($res["ipitv"]=="S") print "checked"; ?> onClick="ccusto(this.form);">
    Tributado na venda</td>
        </tr>
        <tr>
          <td colspan="4" class="textobold"><table width="500" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="52" class="textobold">&nbsp;Frete</td>
              <td width="448" class="textobold"><input name="frete" type="text" class="formulario" id="frete" value="<? print banco2valor($res["frete"]); ?>" size="15" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="ccusto(this.form);">
&nbsp;
<input name="fretev" type="checkbox" id="fretev" value="S" <? if($res["fretev"]=="S") print "checked"; ?> onClick="ccusto(this.form);">
&nbsp;em %</td>
            </tr>
            <tr>
              <td class="textobold">&nbsp;Seguro</td>
              <td class="textobold"><input name="seguro" type="text" class="formulario" id="seguro" value="<? print banco2valor($res["seguro"]); ?>" size="15" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="ccusto(this.form);">
&nbsp;
<input name="segurov" type="checkbox" id="segurov" value="S" <? if($res["segurov"]=="S") print "checked"; ?> onClick="ccusto(this.form);">
&nbsp;em %</td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="4" class="textobold"><table width="500" border="0" cellspacing="1" cellpadding="0">
            <tr class="textobold">
              <td width="134" bgcolor="#003366" class="textoboldbranco">&nbsp;Imposto de Importa&ccedil;&atilde;o </td>
              <td width="97"><input name="ii" type="text" class="formulario" id="ii" value="<? print banco2valor($res["ii"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);">
                %</td>
              <td width="153" bgcolor="#003366" class="textoboldbranco">&nbsp;&nbsp;Despesas da Importa&ccedil;&atilde;o </td>
              <td width="116"><input name="di" type="text" class="formularioselect" id="di" value="<? print banco2valor($res["di"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);"></td>
            </tr>
            <tr class="textobold">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Valor da Compra </td>
              <td><input name="valor" type="text" class="formularioselect" id="valor" value="<? print banco2valor($res["valor"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="ccusto(this.form);"></td>
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;&nbsp;Quantidade</td>
              <td><input name="qtd" type="text" class="formularioselect" id="qtd" value="<? print banco2valor($res["qtd"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="ccusto(this.form);"></td>
            </tr>
            <tr class="textobold">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Valor Rateado </td>
              <td><input name="rateado" type="text" class="formularioselect" id="rateado" value="<? print banco2valor($res["rateado"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" readonly onBlur="ccusto(this.form);"></td>
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;&nbsp;Custo de aquisi&ccedil;&atilde;o </td>
              <td><input name="custo" type="text" class="formularioselect" id="custo" value="<? print banco2valor($res["custo"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" readonly onBlur="ccusto(this.form);"></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="4" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
        </tr>
        <tr align="center">
          <td colspan="4" class="textobold">
            <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='prodserv.php'">
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            <input name="acao" type="hidden" id="acao2" value="custo">
            <input name="id" type="hidden" id="id" value="<? print $id; ?>"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>