<?
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT prodserv.ecat,prodserv.ecat2,prodserv.epri,prodserv.evisivel,prodserv.nome,prodserv.apelido,prodserv.class,unidades.nome AS unidade FROM prodserv,unidades WHERE prodserv.id='$id' AND prodserv.unidade=unidades.id");
$res=mysql_fetch_array($sql);
$nome=$res["nome"];
$apelido=$res["apelido"];
$unidade=$res["unidade"];
$class=$res["class"];
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
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
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">E-commerce</div></td>
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
            Configura&ccedil;&atilde;o do Produto no E-commerce </td>
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
          <td colspan="4" class="textobold"><table width="500" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="137" class="textobold">&nbsp;Vis&iacute;vel no ecommerce</td>
              <td width="363" class="textobold"><input name="evisivel" type="radio" value="1" <? if($res["evisivel"]) print "checked"; ?>>
                sim
                  <input name="evisivel" type="radio" value="0" <? if(!$res["evisivel"]) print "checked"; ?>>
                  n&atilde;o</td>
            </tr>
            <tr>
              <td valign="top" class="textobold">&nbsp;Categoria 1&ordm; </td>
			  
              <td><select name="ecat[]" size="5" class="formularioselect" id="ecat">
                <?
function no($idpai,$wcat){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY texto ASC");
	if(mysql_num_rows($sql)!=0){
		while($res=mysql_fetch_array($sql)){
			$sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
			$widpai=$res["id"];
			$esp=0;
			while($widpai!=0){
				$sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
				$res3=mysql_fetch_array($sql3);
				$widpai=$res3["idpai"];
				if($widpai!=0) $esp++;
			}
			if($res["id"]==$wcat){
				$selsel="selected";
			}else{
				$selsel="";
			}
			print "<option value=\"$res[id]\" $selsel>".str_repeat("&nbsp;", $esp*4)."$res[texto]</option>\n";
			if(mysql_fetch_array($sql2)){
				no($res["id"],$wcat);
			}
		}
	}
}
$w=$res["ecat"];
no(0,$w);
?>
              </select></td>
            </tr>
            <tr>
              <td valign="top" class="textobold">&nbsp;Categoria 2&ordm; </td>
              <td><select name="ecat2" size="5" class="formularioselect" id="ecat">
			  <?
                 $w=$res["ecat2"];
no(0,$w);
?>
                            </select></td>
            </tr>
            <tr>
              <td valign="top" class="textobold">Categoria Destaque </td>
              <td><select name="epri" size="5" class="formularioselect" id="epri">
                 <?
				 
$w=$res["epri"];
no(0,$w);
?>
                                                        </select></td>
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
            <input name="acao" type="hidden" id="acao2" value="ecom">
              <input name="id" type="hidden" id="id" value="<? print $id; ?>">
            </td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>