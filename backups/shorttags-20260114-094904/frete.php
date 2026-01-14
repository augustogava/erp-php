<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM frete WHERE id='$id'");
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
<!--

function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Material');
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
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Frete</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<? if($acao=="entrar"){ ?>
  <tr> 
    <td align="left" valign="top"><table width="600" border="0" cellspacing="0" cellpadding="0">
      
        <tr> 
          <td><div align="center"><a href="frete.php?acao=inc" class="textobold">Incluir 
              Frete </a> </div></td>
        </tr>
      </table>
<? 
$sel=mysql_query("SELECT DISTINCT (regiao) FROM `frete");
$linhas=mysql_num_rows($sel);
?>
      <table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="88" rowspan="2" align="center">&nbsp;Peso(kg)</td>
          <td align="center" colspan="<?= $linhas; ?>">Capital - Capital</td>
        </tr>
        <tr class="textoboldbranco"> 
          
<? 
$sel=mysql_query("SELECT DISTINCT (regiao) FROM `frete");
while($selr=mysql_fetch_array($sel)){
?>
<td align="center" class="textoboldbranco"><? print $selr["regiao"]; $sql1=mysql_query("SELECT * FROM frete WHERE regiao='$selr[regiao]'"); $res1=mysql_fetch_array($sql1); ?><a href="frete.php?acao=alt&id=<? print $res1["id"]; ?>"><br>
  <img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a> <a href="#" onClick="return pergunta('Deseja excluir este Frete?','frete_sql.php?acao=exc&id=<? print $res1["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
<? } ?>
        </tr>
        <?
			  $sql=mysql_query("SELECT * FROM frete ORDER BY id ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="center" class="textobold">NENHUM FRETE ENCONTRADO 
          </td>
        </tr>
        <?
			  }else{
			  	$res=mysql_fetch_array($sql)
			  ?>
<? for($i=1; $i<=31; $i++){ ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="right"><? eval("print \$res[peso_ini$i];"); ?> a <? eval("print \$res[peso_fin$i];"); ?>
          &nbsp;</td>

          <? 
$sel=mysql_query("SELECT DISTINCT (regiao) FROM `frete");
while($selr=mysql_fetch_array($sel)){
?>
          <td align="right"><? $sql1=mysql_query("SELECT * FROM frete WHERE regiao='$selr[regiao]'"); $res1=mysql_fetch_array($sql1); eval("print banco2valor(\$res1[peso_preco$i]);"); ?>
          &nbsp;</td> 
<? } ?>
        </tr>
<? } } ?>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="frete_sql.php" onSubmit="return verifica(this);">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco"> 
              <? if($acao=="inc"){ print"Incluir"; }else{ print"Alterar";} ?> Frete
            </td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Regi&atilde;o</td>
            <td class="textobold"><input name="regiao" type="text" class="formularioselect" id="nome2" value="<? print $res["regiao"]; ?>" size="40" maxlength="25"></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;CEP Ini. </td>
            <td class="textobold"><input name="cep_inicial" type="text" class="formulario" id="nome2" value="<? print $res["cep_inicial"]; ?>"  size="6" maxlength="6"></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;CEP Final. </td>
            <td class="textobold"><input name="cep_final" type="text" class="formulario" id="nome2" value="<? print $res["cep_final"]; ?>" size="6" maxlength="6"></td>
          </tr>

<? for($i=1; $i<=31; $i++){ ?>
          <tr>
            <td class="textobold">&nbsp;Peso ini. <?= $i; ?></td>
            <td class="textobold"><input name="peso_ini<?= $i; ?>" type="text" class="formulario" id="peso_ini<?= $i; ?>"  value="<? print $res["peso_ini$i"]; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Peso Fin. <?= $i; ?></td>
            <td class="textobold"><input name="peso_fin<?= $i; ?>" type="text" class="formulario" id="peso_fin<?= $i; ?>"  value="<? print $res["peso_fin$i"]; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr> 
            <td width="97" class="textobold">&nbsp;Peso Preco. <?= $i; ?></td>
            <td width="203" class="textobold"><input name="peso_preco<?= $i; ?>" type="text" class="formulario" id="peso_preco<?= $i; ?>" value="<? print banco2valor($res["peso_preco$i"]); ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" size="10" maxlength="10"></td>
          </tr>
<tr align="center">
            <td colspan="2" class="textobold"><img src="../layout/layout_menu/spacer.gif" width="1" height="5"></td>
          </tr>
<? } ?>   
          <tr align="center"> 
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='material.php'">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"> 
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>"></td>
          </tr>
        </table>	
      </form>
      
    </td>
	<? } ?>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>