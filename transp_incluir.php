<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Transportadora";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM transportadora WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>

<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script src="ajax.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o nome Fantasia');
		cad.nome.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">transportadora</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <? if($acao=="entrar"){ ?>
  <tr>
    <td align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center"><a href="transp_incluir.php?acao=inc" class="textobold">Incluir uma Transpordora </a></div></td>
        </tr>
      </table>
        <table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr align="left" class="textoboldbranco">
            <td width="44">C&oacute;d</td>
            <td width="248" align="left">Nome</td>
            <td width="96">Regi&atilde;o Atuante </td>
            <td width="73" align="left">Tel</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?
			  $sql=mysql_query("SELECT * FROM transportadora ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
          <tr bgcolor="#FFFFFF">
            <td colspan="6" align="center" class="textobold">NENHUMA TRANSPORTADORA CADASTRADA </td>
          </tr>
          <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
          <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
            <td><? print $res["id"]; ?></td>
            <td><? print $res["nome"]; ?></td>
            <td><? print $res["reg_atuante"]; ?></td>
            <td><? print $res["telefone"]; ?></td>
            <td width="14" align="center"><a href="transp_incluir.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
            <td width="18" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta Unidade?','transp_incluir_sql.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
          </tr>
          <?
			  	}
			  }
			  ?>
      </table></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form action="transp_incluir_sql.php" method="post" name="form1" onSubmit="return verifica(form1);">
        <table width="400" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366">
            <td colspan="2" align="center" class="textoboldbranco">
              <? if($acao=="inc"){ print"Incluir Transportadora"; }else{ print"Alterar Transportadora";} ?>            </td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Cod. Interno</td>
            <td class="textobold"><input name="cod_transport" type="text" class="formularioselect" id="cod_transport" value="<? print $res["id"]; ?>" size="45" maxlength="50" readonly=""></td>
          </tr>
          <tr>
            <td width="107" align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Fantasia:</td>
            <td width="293" class="textobold"><input name="nome" type="text" class="formularioselect" value="<? print $res["nome"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Raz&atilde;o Social: </td>
            <td class="textobold"><input name="razao" type="text" class="formularioselect" id="nome3" value="<? print $res["razao"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;CNPJ:</td>
            <td class="textobold"><input name="cnpj" type="text" class="formularioselect" id="nome4" value="<? print $res["cnpj"]; ?>" size="45" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;IE:</td>
            <td class="textobold"><input name="ie" type="text" class="formularioselect" id="nome5" value="<? print $res["ie"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Endere&ccedil;o:</td>
            <td class="textobold"><input name="endereco" type="text" class="formularioselect" id="nome6" value="<? print $res["endereco"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Complemento</td>
            <td class="textobold"><input name="complemento" type="text" class="formularioselect" id="complemento" value="<? print $res["complemento"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;CEP:</td>
            <td class="textobold"><input name="cep" type="text" class="formularioselect" id="nome7" value="<? print $res["cep"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Bairro:</td>
            <td class="textobold"><input name="bairro" type="text" class="formularioselect" id="nome8" value="<? print $res["bairro"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;UF:</td>
            <td align="left" class="textobold"><span class="texto">
              <select name="uf" id="uf"  class="formulario">
                <option>Selecione</option>
                <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$res["uf"]){ print "selected"; } ?>>
                <?= $res2["nome"]; ?>
                </option>
                <? } ?>
              </select>
            </span></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Cidade:</td>
            <td align="left" class="textobold"><input name="cidade" type="text" class="formulario" id="cidade" value="<? print $cidade; ?>" size="50" maxlength="30">          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textoboldwhite">
              <p class="textobold">&nbsp;Telefone 1 :</p></td>
            <td align="left" class="textobold"><input name="telefone" type="text" class="formularioselect" id="nome11" value="<? print $res["telefone"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Telefone 2 :</td>
            <td align="left" class="textobold"><input name="tel2" type="text" class="formularioselect" id="tel2" value="<? print $res["tel2"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Fax 1 :</td>
            <td align="left" class="textobold"><input name="fax" type="text" class="formularioselect" id="fax" value="<? print $res["fax"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Fax 2 :</td>
            <td align="left" class="textobold"><input name="fax2" type="text" class="formularioselect" id="fax2" value="<? print $res["fax2"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Site:</td>
            <td align="left" class="textobold"><input name="site" type="text" class="formularioselect" id="site" value="<? print $res["site"]; ?>" size="45"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Contato 1 :</td>
            <td align="left" class="textobold"><input name="contato" type="text" class="formularioselect" id="nome12" value="<? print $res["contato"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Celular 1 : </td>
            <td align="left" class="textobold"><input name="celular" type="text" class="formularioselect" id="celular" value="<? print $res["celular"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;E-mail 1 : </td>
            <td align="left" class="textobold"><input name="email" type="text" class="formularioselect" id="email" value="<? print $res["email"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Contato 2 : </td>
            <td align="left" class="textobold"><input name="contato2" type="text" class="formularioselect" id="contato2" value="<? print $res["contato2"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Celular 2 : </td>
            <td align="left" class="textobold"><input name="celular2" type="text" class="formularioselect" id="celular2" value="<? print $res["celular2"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;E-mail 2 : </td>
            <td align="left" class="textobold"><input name="email2" type="text" class="formularioselect" id="email2" value="<? print $res["email2"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Coleta:</td>
            <td align="left" class="textobold"><input name="coleta" type="text" class="formularioselect" id="coleta" value="<? print $res["coleta"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">  &nbsp;End. entrega:</td>
            <td align="left" class="textobold"><input name="end_entrega" type="text" class="formularioselect" id="end_entrega" value="<? print $res["end_entrega"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Bairro entrega: </td>
            <td align="left" class="textobold"><input name="bairro_entrega" type="text" class="formularioselect" id="bairro_entrega" value="<? print $res["bairro_entrega"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Cidade entrega:</td>
            <td align="left" class="textobold"><input name="cid_entrega" type="text" class="formularioselect" id="cid_entrega" value="<? print $res["cid_entrega"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Estado entrega:</td>
            <td align="left" class="textobold"><span class="texto"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
              <select name="est_entrega" id="est_entrega" class="formulario">
               <option>Selecione</option>
               <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
               <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$res["est_entrega"]){ print "selected"; } ?>>
               <?= $res2["nome"]; ?>
               </option>
               <? } ?>
             </select>
            </font></span></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Regi&atilde;o atuante:</td>
            <td align="left" class="textobold"><input name="reg_atuante" type="text" class="formularioselect" id="reg_atuante" value="<? print $res["reg_atuante"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Estados atuantes: </td>
            <td align="left" class="textobold"><span class="texto"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
              <select name="est_atuante" id="select2" class="formulario">
                <option>Selecione</option>
                <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$res["est_atuante"]){ print "selected"; } ?>>
                <?= $res2["nome"]; ?>
                </option>
                <? } ?>
              </select>
            </font></span></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Tempo p/ coleta: </td>
            <td align="left" class="textobold"><input name="temp_col" type="text" class="formularioselect" id="temp_col" value="<? print $res["temp_col"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='transp_incluir.php'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="alt"){ print "alt"; }else{ print "inc"; } ?>">
            <input name="id" type="hidden" id="id3" value="<? print $id; ?>"></td>
          </tr>
        </table>
    </form></td>
	  <? if($acao=="alt"){ ?>

	  <? } ?>
    <? } ?>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>