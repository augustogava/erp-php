<?
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT *,cr_itens.valor AS valor FROM cr_itens,cr WHERE cr_itens.conta=cr.id AND cr_itens.id='$id'");
$res=mysql_fetch_array($sql);
if($res["cliente_tipo"]=="C"){
	$sqln=mysql_query("SELECT nome FROM clientes WHERE id='$res[cliente]'");
}else{
	$sqln=mysql_query("SELECT nome FROM fornecedores WHERE id='$res[cliente]'");
}
$res2=mysql_fetch_array($sqln);
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
function verifica(cad){
	if(!verifica_data(cad.pagto.value)){
		alert('Data de recebimento inválida');
		cad.pagto.focus();
		return false;
	}
	if(cad.documento.value==''){
		alert('Informe o documento');
		cad.documento.focus();
		return false;
	}
	return true;
}
windowWidth=305;
windowHeight=190;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<form name="form1" method="post" action="cr_sql.php" onSubmit="return verifica(this)">
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr align="center" bgcolor="#003366"> 
      <td colspan="2" valign="top" class="textoboldbranco"><? print $res2["nome"]; ?></td>
    </tr>
    <tr> 
      <td width="83" align="left" valign="top" class="textobold">Valor:</td>
      <td width="267" align="left" valign="top" class="texto"><? print banco2valor($res["valor"]); ?></td>
    </tr>
    <tr> 
      <td align="left" valign="top" class="textobold">Vencimento:</td>
      <td align="left" valign="top" class="texto"><? print banco2data($res["vencimento"]); ?></td>
    </tr>
    <tr> 
      <td align="left" valign="top" class="textobold">Recebimento:</td>
      <td align="left" valign="top"><input name="pagto" type="text" class="formulario" id="pagto" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
    </tr>
    <tr> 
      <td align="left" valign="top" class="textobold">Documento:</td>
      <td align="left" valign="top"><input name="documento" type="text" class="formulario" id="documento" size="10" maxlength="30"></td>
    </tr>
    <tr> 
      <td align="left" valign="top" class="textobold">Opera&ccedil;&atilde;o:</td>
      <td align="left" valign="top"><select name="operacao" class="formularioselect" id="operacao">
          <?
				$sqlo=mysql_query("SELECT * FROM operacoes ORDER BY nome ASC");
				while($reso=mysql_fetch_array($sqlo)){
				?>
          <option value="<? print $reso["id"]; ?>"><? print $reso["nome"]; ?></option>
          <?
				}
				?>
        </select></td>
    </tr>
    <tr> 
      <td align="left" valign="top" class="textobold">Filial:</td>
      <td align="left" valign="top"><select name="banco" class="formularioselect" id="banco">
          <?
				$sqlo=mysql_query("SELECT * FROM bancos ORDER BY apelido ASC");
				while($reso=mysql_fetch_array($sqlo)){
				?>
          <option value="<? print $reso["id"]; ?>" <? if($res["banco"]==$reso["id"]) print "selected"; ?>><? print $reso["apelido"]; ?></option>
          <?
				}
				?>
        </select></td>
    </tr>
    <tr> 
      <td align="left" valign="top" class="textobold">Diferen&ccedil;a:</td>
      <td align="left" valign="top"><input name="diferenca" type="text" class="formulario" id="diferenca" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="10"> 
        <input name="id" type="hidden" id="id" value="<? print $id; ?>"> <input name="acao" type="hidden" id="acao" value="bxitem"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="top"><img src="imagens/dot.gif" width="50" height="8"></td>
    </tr>
    <tr> 
      <td colspan="2" align="center" valign="top">
        <input name="Submit22" type="button" class="microtxt" value="Cancelar" onClick="window.close();">
      <img src="imagens/dot.gif" width="20" height="5"><span class="textobold">
        <input name="Submit2" type="submit" class="microtxt" value="Continuar">
      </span></td>
    </tr>
  </table>
</form>
</body>
</html>
<? include("mensagem.php"); ?>