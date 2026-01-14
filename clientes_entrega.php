<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Clientes Financeiro";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cliente_entrega  WHERE cliente='$id'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
	}else{
		$sql=mysql_query("INSERT INTO cliente_entrega  (cliente) VALUES('$id')");
		$sql=mysql_query("SELECT * FROM cliente_entrega  WHERE cliente='$id'");
		$res=mysql_fetch_array($sql);
	}
	$endereco=$res["endereco"];
	$bairro=$res["bairro"];
	$cep=$res["cep"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$cnpj=$res["cnpj"];
	$ie=$res["ie"];
	$transp=$res["transp"];
	$endereco_ins=$res["endereco_ins"];
	$bairro_ins=$res["bairro_ins"];
	$cep_ins=$res["cep_ins"];
	$cidade_ins=$res["cidade_ins"];
	$estado_ins=$res["estado_ins"];
	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE cliente_entrega SET endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado',cnpj='$cnpj',ie='$ie',transp='$transp',endereco_ins='$endereco_ins',bairro_ins='$bairro_ins',cep_ins='$cep_ins',cidade_ins='$cidade_ins',estado_ins='$estado_ins' WHERE cliente='$id'");

	if($sql){
		$_SESSION["mensagem"]="Cadastro alterado!";
		header("Location:clientes.php?bcod=$bcod&bnome=$bnome");
		exit;				
	}else{
		$_SESSION["mensagem"]="O cadastro não pôde ser alterado!";		
		$acao="alt";
	}	
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
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
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="460" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="447" height="17" colspan="2" align="center"><table width="443" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
              <tr>
                <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="372" align="right"><div align="left"><span class="textobold style1 style1 style1">Cadastro 
                  de Clientes - Entrega</span></div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco" type="text" class="formulario" id="endereco" value="<?php print $endereco; ?>" size="50" maxlength="100"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro" type="text" class="formulario" id="bairro" value="<?php print $bairro; ?>" size="50" maxlength="30"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep" type="text" class="formulario" id="cep" value="<?php print $cep; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado" id="estado"  class="formulario">
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
            </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td><input name="cidade" type="text" class="formulario" id="cidade" value="<?php print $cidade; ?>" size="50" maxlength="30"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CPF/CNPJ:</td>
            <td><input name="cnpj" type="text" class="formulario" id="cnpj" value="<?php print $cnpj; ?>" size="20" maxlength="15"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Estadual:</td>
            <td><input name="ie" type="text" class="formulario" id="ie" value="<?php print $ie; ?>" size="20" maxlength="30"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Transportadora:</td>
            <td><input name="transp" type="text" class="formulario" id="transp" value="<?php print $transp; ?>" size="20" maxlength="30"></td>
          </tr>
          <tr class="textobold">
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Instala&ccedil;&atilde;o</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco_ins" type="text" class="formulario" id="endereco_ins" value="<?php print $endereco_ins; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro_ins" type="text" class="formulario" id="bairro_ins" value="<?php print $bairro_ins; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep_ins" type="text" class="formulario" id="cep_ins" value="<?php print $cep_ins; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado_ins" id="estado_ins" class="formulario">
                <option>Selecione</option>
                <?php
	$sql2=mysql_query("SELECT * FROM estado") or erp_db_fail();
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?php echo  $res2["id"]; ?>" <?php if($res2["id"]==$estado_ins){ print "selected"; } ?>>
                <?php echo  $res2["nome"]; ?>
                </option>
                <?php } ?>
              </select>
            </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td><input name="cidade_ins" type="text" class="formulario" id="cidade_ins" value="<?php print $cidade_ins; ?>" size="50" maxlength="30"></td>
          </tr>
          
          <tr class="textobold">
            <td colspan="2" align="center"><?php if($acao=="alt"){ ?>
                <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='clientes.php<?php if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>'">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php } ?>
                <input name="Submit" type="submit" class="microtxt" value="Continuar">
                <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
                <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
                <input name="acao" type="hidden" id="acao" value="<?php if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
                </font></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
&nbsp; 
</body>
</html>
<?php include("mensagem.php"); ?>