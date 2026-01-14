<?php
include("conecta.php");
include("seguranca.php");
if($acao=="inc"){
	$data=date("Y-m-d");
	$hora=hora();
	$sql=mysql_query("INSERT INTO followup (cliente,data,hora,titulo,descricao,tipo,contato,vendedor) VALUES ('$cliente','$data','$hora','$titulo','$descricao','$tipo','$contato','$vendedor')");
	if($titulo=="followup"){
		mysql_query("UPDATE clientes SET ult_cont=NOW() WHERE id='$cliente'");
	}
	if($sql){
		$_SESSION["mensagem"]="As informações foram incluídas com sucesso";
		print "<script>opener.location='crm_infg.php?cli=$cliente';window.close();</script>";
	}else{
		$_SESSION["mensagem"]="As informações não puderam ser incluídas";
	}
}else if($acao=="alt"){
	$sql=mysql_query("UPDATE followup SET titulo='$titulo',descricao='$descricao',tipo='$tipo',contato='$contato',vendedor='$vendedor' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="As informações foram salvas com sucesso";
		print "<script>opener.location='crm_infg1.php?cli=$cliente';</script>";
	}else{
		$_SESSION["mensagem"]="As informações não puderam ser incluídas";
	}
}else if($acao=="vis"){
	$acao="alt";
	$sql=mysql_query("SELECT * FROM followup WHERE id='$idf'");
	$res=mysql_fetch_array($sql);
	$cli=$res["cliente"];
}
if(empty($acao)) $acao="inc";
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.titulo.value==''){
		alert('Informe o título');
		cad.titulo.focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Informe a descrição');
		cad.descricao.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0"></div></td>
    <td width="563" align="right"><div align="left"><span class="chamadas"><span class="titulos">Follow Up </span></span></div></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top">              
      <form action="" method="post" name="form1" id="form1" onSubmit="return verifica(this)">
        <table width="594" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="302" class="texto"><span class="textobold">T&iacute;tulo</span> (m&aacute;ximo 30 caracteres)
            <input name="cliente" type="hidden" id="cliente" value="<?php echo  $cli; ?>">
            <input name="acao" type="hidden" id="acao" value="<?php print $acao; ?>">
            <input name="id" type="hidden" id="id" value="<?php print $idf; ?>"></td>
          </tr>
          <tr>
            <td>
              <select name="titulo" class="formularioselect" id="select2">
                <option value="">Selecione</option>
				<option value="followup" <?php if($res["titulo"]=="followup"){ print "selected"; } ?>>Follow-up</option>
				<option value="atualizacao" <?php if($res["titulo"]=="atualizacao"){ print "selected"; } ?>>Atualização</option>
				<option value="reclamacao" <?php if($res["titulo"]=="reclamacao"){ print "selected"; } ?>>Reclamação</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="textobold">Tipo</td>
          </tr>
          <tr>
            <td class="textobold"><select name="tipo" class="formularioselect" id="tipo">
              <option>Selecione</option>
			  <?php 
			  $sql2=mysql_query("SELECT * FROM followup_tipo ORDER By nome ASC");
			  while($res2=mysql_fetch_array($sql2)){
			   ?>
			   <option value="<?php print $res2["id"]; ?>" <?php if($res["tipo"]==$res2["id"]){ print "selected"; } ?>><?php print $res2["nome"]; ?></option>
			   <?php } ?>
            </select>            </td>
          </tr>
          <tr>
            <td class="textobold">Vendedor</td>
          </tr>
          <tr>
            <td class="textobold"><select name="vendedor" class="formularioselect" id="select">
              <option value="0" selected>Selecione</option>
              <?php
$sqlv=mysql_query("SELECT c.fantasia,c.id FROM clientes AS c, cliente_login AS cl, niveis AS n WHERE cl.nivel=n.id AND n.vendedor=1 AND cl.cliente=c.id ORDER BY c.fantasia ASC");
if(mysql_num_rows($sqlv)){
	while($resv=mysql_fetch_array($sqlv)){
?>
              <option value="<?php echo  $resv["id"]; ?>" <?php if($resv["id"]==$res["vendedor"]) print "selected"; ?>>
              <?php echo  $resv["fantasia"]; ?>
              </option>
              <?php
	}
}
?>
            </select></td>
          </tr>
          <tr>
            <td class="textobold">Contato</td>
          </tr>
          <tr>
            <td class="textobold"><select name="contato" class="formularioselect" id="select3">
              <option>Selecione</option>
              <?php 
			  $sql2=mysql_query("SELECT * FROM cliente_contato WHERE cliente='$cli' ORDER By nome ASC");
			  while($res2=mysql_fetch_array($sql2)){
			   ?>
              <option value="<?php print $res2["id"]; ?>" <?php if($res["contato"]==$res2["id"]){ print "selected"; } ?>><?php print $res2["nome"]; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td class="textobold">Descri&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td><textarea name="descricao" rows="6" wrap="VIRTUAL" class="formularioselect" id="textarea"  onFocus="enterativa=0;" onBlur="enterativa=1;"><?php print $res["descricao"]; ?></textarea></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><span class="textobold">
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            </span></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>