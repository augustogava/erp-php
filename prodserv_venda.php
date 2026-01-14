<?php
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT prodserv.nome,prodserv.apelido,prodserv.class,unidades.nome AS unidade FROM prodserv,unidades WHERE prodserv.id='$id' AND prodserv.unidade=unidades.id");
$res=mysql_fetch_array($sql);
$nome=$res["nome"];
$apelido=$res["apelido"];
$unidade=$res["unidade"];
$class=$res["class"];
$sql=mysql_query("SELECT * FROM prodserv_custo WHERE prodserv='$id'");
if(mysql_num_rows($sql)==0){
	$_SESSION["mensagem"]="Defina o custo de aquisição";
	header("Location:prodserv_custo.php?id=$id");
	exit;
}
$res=mysql_fetch_array($sql);
$custo=$res["custo"];
$valor2=0;
if($res["icmstv"]=="S"){
	if($res["icmsv"]=="S"){
		$valor2+=($custo*$res["icms"])/100;
	}else{
		$valor2+=$res["icms"];
	}
}
if($res["ipitv"]=="S"){
	if($res["ipiv"]=="S"){
		$valor2+=($custo*$res["ipi"])/100;
	}else{
		$valor2+=$res["ipi"];
	}
}
$valor2=banco2valor($valor2);
$sql=mysql_query("SELECT * FROM prodserv_venda WHERE prodserv='$id'");
if(mysql_num_rows($sql)!=0){
	$res=mysql_fetch_array($sql);
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
function cvenda(frm){
	imp=valor2real(frm.imp.value);
	comi=valor2real(frm.comi.value);
	marg=valor2real(frm.marg.value);
	custo=valor2real(frm.custo.value);
	valor2=valor2real(frm.valor2.value);
	if(custo > 0){
		custo+=valor2;
		if(comi > 0){
			custo+=(custo*comi)/100;
		}
		if(imp > 0){
			custo+=(custo*imp)/100;
		}
	frm.proposto.value=real2valor(custo);
	}
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Venda</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><form name="frmvenda" method="post" action="prodserv_sql.php" onSubmit="return verifica(this);">
      <table width="500" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#003366">
          <td colspan="4" align="center" class="textoboldbranco">
            Pre&ccedil;o de Venda </td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td width="52" class="textobold">&nbsp;Produto:</td>
          <td colspan="3" class="texto">&nbsp;<?php print $nome; ?></td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td class="textobold">&nbsp;Apelido:</td>
          <td width="271" class="texto">&nbsp;<?php print $apelido; ?></td>
          <td width="59" align="center" class="textobold">Unidade:</td>
          <td width="118" class="texto"><span class="texto">&nbsp;<?php print $unidade; ?></span></td>
        </tr>
        <tr>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          <td align="center" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
        </tr>
        <tr>
          <td colspan="4" class="textobold"><table width="500" border="0" cellspacing="1" cellpadding="0">
            <tr class="textobold">
              <td width="134" bgcolor="#003366" class="textoboldbranco">&nbsp;Custo de aquisi&ccedil;&atilde;o </td>
              <td width="97"><input name="custo" type="text" class="formularioselect" id="custo" value="<?php print banco2valor($custo); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="cvenda(this.form);" readonly>                </td>
              <td width="153" bgcolor="#003366" class="textoboldbranco">&nbsp;&nbsp;Impostos % </td>
              <td width="116"><input name="imp" type="text" class="formularioselect" id="imp" value="<?php print banco2valor($res["imp"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="cvenda(this.form);"></td>
            </tr>
            <tr class="textobold">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Comiss&atilde;o % </td>
              <td><input name="comi" type="text" class="formularioselect" id="comi" value="<?php print banco2valor($res["comi"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="cvenda(this.form);"></td>
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;&nbsp;Margem desejada </td>
              <td><input name="marg" type="text" class="formularioselect" id="marg" value="<?php print banco2valor($res["marg"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="cvenda(this.form);"></td>
            </tr>
            <tr class="textobold">
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;Pre&ccedil;o proposto </td>
              <td><input name="proposto" type="text" class="formularioselect" id="proposto" value="0,00" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="cvenda(this.form);" readonly></td>
              <td bgcolor="#003366" class="textoboldbranco">&nbsp;&nbsp;Pre&ccedil;o de venda </td>
              <td><input name="venda" type="text" class="formularioselect" id="venda" value="<?php print banco2valor($res["venda"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" onBlur="cvenda(this.form);"></td>
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
            <input name="acao" type="hidden" id="acao2" value="venda">
              <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
              <input name="pcusto" type="hidden" id="pcusto" value="<?php print banco2valor($custo); ?>">
            <input name="valor2" type="hidden" id="valor2" value="<?php print $valor2; ?>"></td>
        </tr>
      </table>
    </form></td><script>cvenda(frmvenda);</script>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>