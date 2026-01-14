<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Portas";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if(!empty($ps)){
	$_SESSION["ps2"]=$ps;
}else{
	$ps=$_SESSION["ps2"];
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM portasp WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<html>
<head>
<title>
<MMString:LoadString id="insertbar/formsHidden" />
</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>

<!-- Copyright 2000,2001,2002 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Portas</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<? if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="cpvc.php?acao=inc" class="textobold">Incluir 
              uma Porta </a></div></td>
        </tr>
      </table>
      <table width="450" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="408"> &nbsp; Nome </td>
          <td width="18" align="center">&nbsp;</td>
          <td width="20" align="center">&nbsp;</td>
        </tr>
        <?
			  $sql=mysql_query("SELECT * FROM portasp ORDER By nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="center" class="textobold">NENHUMA PORTA</td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td width="408">&nbsp;<? print $res["nome"]; ?></td>
          <td width="18" align="center"><a href="cpvc.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta Porta?','cpvc_sql.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?
			  	}
			  }
			  ?>
      </table>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="imagens/dot.gif" width="50" height="8"></td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold">
            <input name="Submit222" type="button" class="microtxt" value="voltar" onClick="window.location='prodserv.php'">
          </span></div></td>
        </tr>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="cpvc_sql.php">
        <table width="350" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir Porta"; }else{ print"Alterar Porta";} ?>            </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Nome</td>
            <td class="textobold"><input name="nome" type="text" class="formularioselect" id="nome" value="<? print $res["nome"]; ?>" size="10" onBlur="ccusto(this.form);"></td>
          </tr>
          <tr>
            <td width="71" class="textobold">&nbsp;Perfil            </td>
            <td width="279" class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
				<?
				$sql2=mysql_query("SELECT * FROM perfil WHERE id='$res[perfil]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="perfiln" type="text" class="formularioselect" id="perfiln" value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cpvc_per.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="middle" class="textobold">&nbsp;PVC Inf



              <input name="inferior" type="hidden" id="inferior" value="<?= $res["pvc_inferior"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[pvc_inferior]'"); $res2=mysql_fetch_array($sql2);
				?>
                <td><input name="inferiorn" type="text" class="formularioselect" value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                <td width="20" align="center"><a href="#" onClick="return abre('cpvc_pvc_inf.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="middle" class="textobold">&nbsp;PVC Sup
              <input name="superior" type="hidden" id="superior" value="<?= $res["pvc_superior"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[pvc_superior]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="superiorn" type="text" class="formularioselect"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cpvc_pvc_sup.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="middle" class="textobold">&nbsp;PVC Cristal
              <input name="cristal" type="hidden" id="cristal" value="<?= $res["pvc_cristal"]; ?>"></td>
            <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[pvc_cristal]'"); $res2=mysql_fetch_array($sql2);
				?>
                  <td><input name="cristaln" type="text" class="formularioselect"  value="<? print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                  <td width="20" align="center"><a href="#" onClick="return abre('cpvc_pvc_cri.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td class="textobold"> &nbsp;CS Banda1 </td>
            <td class="textobold"><input name="b1" type="text" class="formulario" id="b1" value="<? print banco2valor($res["b1"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);"> 
              &nbsp;PVC Cinza Superior  </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;CI Banda2 </td>
            <td class="textobold"><input name="b2" type="text" class="formulario" id="b2" value="<? print banco2valor($res["b2"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);">
            &nbsp;PVC Cinza Inferior </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;CR Banda </td>
            <td class="textobold"><input name="b3" type="text" class="formulario" id="b3" value="<? print banco2valor($res["b3"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);">
&nbsp;            PVC Cristal </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Corte 1 </td>
            <td class="textobold"><input name="co1" type="text" class="formulario" id="co1" value="<? print banco2valor($res["co1"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);">
            &nbsp;PVC Cinza Superior </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Corte 2</td>
            <td class="textobold"><input name="co2" type="text" class="formulario" id="co2" value="<? print banco2valor($res["co2"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <? if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);">
            &nbsp;PVC Cinza Inferior </td>
          </tr>
          <tr>
            <td colspan="2" class="microtxt">*CS=Cinza Superior, CI=Cinza Inferior, CR=Cristal </td>
          </tr>
          
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit2222" type="button" class="microtxt" value="voltar" onClick="window.location='cpvc.php'">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"> 
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>">
            <input name="perfil" type="hidden" id="perfil" value="<?= $res["perfil"] ?>"></td>
          </tr>
        </table>
      </form>    </td>
	<? } ?>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>