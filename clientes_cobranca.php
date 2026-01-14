<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Clientes Cobranca";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="alterar"){
	$sql=mysql_query("UPDATE cliente_cobranca SET endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado' WHERE cliente='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro alterado!";
		header("Location:clientes.php?bcod=$bcod&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro não pôde ser alterado!";
		$comissao=banco2valor($comissao);				
		$acao="alt";
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$id'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
	}else{
		$sql=mysql_query("INSERT INTO cliente_cobranca (cliente) VALUES('$id')");
		$sql=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$id'");
		$res=mysql_fetch_array($sql);
	}
	$endereco=$res["endereco"];
	$bairro=$res["bairro"];
	$cep=$res["cep"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script src="ajax.js"></script>
<script>
function verifica(cad){
	if(cad.endereco.value==''){
		alert('Preencha o Endereço');
		cad.endereco.focus();
		return false;
	}
	if(cad.bairro.value==''){
		alert('Preencha o Bairro');
		cad.bairro.focus();
		return false;
	}
	if(cad.cep.value==''){
		alert('Preencha o CEP');
		cad.cep.focus();
		return false;
	}
	if(cad.cidade.value==''){
		alert('Preencha a Cidade');
		cad.cidade.focus();
		return false;
	}
	return true;
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="form1" method="post" action="">
  <table width="363" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center"><table width="328" border="0" align="left" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome&lt;br&gt;Nascimento: xx/xx/xxxx&lt;br&gt;RG: xx.xxx.xxx-x&lt;br&gt;Cart. Profissional: xxxxx&lt;br&gt;Admiss&atilde;o: xx/xx/xxxx&lt;br&gt;Cargo: Escolha um item na lista')" /><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="257" align="right"><div align="left"><span class="titulos">Cadastro 
              de Clientes - Cobran&ccedil;a</span></div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr class="textobold">
      <td width="91">&nbsp;Endere&ccedil;o:</td>
      <td width="272"><input name="endereco" type="text" class="formulario" id="endereco" value="<?php print $endereco; ?>" size="50" maxlength="100" /></td>
    </tr>
    <tr class="textobold">
      <td>&nbsp;Bairro:</td>
      <td><input name="bairro" type="text" class="formulario" id="bairro" value="<?php print $bairro; ?>" size="50" maxlength="30" /></td>
    </tr>
    <tr class="textobold">
      <td>&nbsp;CEP: </td>
      <td><input name="cep" type="text" class="formulario" id="cep" value="<?php print $cep; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
    </tr>
    <tr class="textobold">
      <td>&nbsp;Estado:</td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"><span class="texto">
        <select name="estado" id="estado" class="formulario">
          <option>Selecione</option>
          <?php
	$sql2=mysql_query("SELECT * FROM estado") or erp_db_fail();
	while($res2=mysql_fetch_array($sql2)){
	?>
          <option value="<?php echo  $res2["id"]; ?>" <?php if($res2["id"]==$estado){ print "selected"; } ?>>
          <?php echo  $res2["nome"]; ?>
          </option>
          <?php } ?>
        </select>
      </span>
        <input name="id" type="hidden" id="id" value="<?php print $id; ?>" />
        <input name="acao" type="hidden" id="acao" value="<?php if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>" />
      </font></td>
    </tr>
    <tr class="textobold">
      <td>&nbsp;Cidade:</td>
      <td><input name="cidade" type="text" class="formulario" id="cidade" value="<?php print $cidade; ?>" size="50" maxlength="30" /></td>
    </tr>
    <tr class="textobold">
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr class="textobold">
      <td colspan="2" align="center"><?php if($acao=="alt"){ ?>
          <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='clientes.php<?php if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>';" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <?php } ?>
        <input name="Submit" type="submit" class="microtxt" value="Continuar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
