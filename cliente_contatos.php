<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cliente Contato";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO cliente_contato (cliente,nome,email,fone1,fone2,fax,ramal1,ramal2,ramal3,cargo,celular,autonomia,atuacao) VALUES ('$cli','$nome','$email','$fone1','$fone2','$fax','$ramal1','$ramal2','$ramal3','$cargo','$celular','$autonomia','$atuacao')");
	if($sql){
		$_SESSION["mensagem"]="Contato incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O contato não pôde ser incluído!";
		$acao="inc";
	}
	if($pag=="pro"){
		header("Location:vendas_cliorc2.php?cli=$cli&acao=esco");
	}	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE cliente_contato SET nome='$nome',email='$email',fone1='$fone1',fone2='$fone2',fax='$fax',ramal1='$ramal1',ramal2='$ramal2',ramal3='$ramal3',cargo='$cargo',celular='$celular',autonomia='$autonomia',atuacao='$atuacao' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Contato alterado com sucesso!";
		if($pag=="pro"){
			header("Location:vendas_cliorc2.php?cli=$cli&acao=esco");
		}	
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O contato não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM cliente_contato WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Contato excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O contato não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
<!--

function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Contato');
		cad.nome.focus();
		return false;
	}
	if(!verifica_email(cad.email.value)){
		alert('Email Inválido');
		cad.email.focus();
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

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="500" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td align="left" valign="top"><table width="500" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Contato</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
        <? if($acao=="entrar"){ ?>
        <tr> 
          <td><table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><div align="center"><a href="cliente_contatos.php?acao=inc&cli=<? print $cli; ?>" class="textobold">Incluir 
                    um Contato</a> </div></td>
              </tr>
            </table>
            <table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="81">&nbsp;Nome</td>
                <td width="96">Telefone</td>
                <td width="114">Cargo</td>
                <td width="15">&nbsp;</td>
                <td width="19">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM cliente_contato WHERE cliente='$cli' ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="5" align="center" class="textobold">NENHUM CONTATO 
                  CADASTRADO </td>
              </tr>
              <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<? print $res["nome"]; ?></td>
                <td><? print $res["fone1"]; ?></td>
                <td><? print $res["cargo"]; ?></td>
                <td width="15" align="center"><a href="cliente_contatos.php?acao=alt&id=<? print $res["id"]; ?>&cli=<? print $cli; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="19" align="center"><a href="#" onClick="return pergunta('Deseja excluir este contato?','cliente_contatos.php?acao=exc&id=<? print $res["id"]; ?>&cli=<? print $cli; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?
			  	}
			  }
			  ?>
            </table></td>
        </tr>
		<tr>
          <td><table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><div align="center"></div></td>
              </tr>
            </table></td>
        </tr>
        <? }elseif($acao=="inc" or $acao=="alt"){ ?>

        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="348" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="4" align="center" class="textoboldbranco"> 
                    <? if($acao=="inc"){ print"Incluir Contato"; }else{ print"Alterar Contato";} ?>                  </td>
                </tr>
                <? if($acao=="alt"){
				$sql=mysql_query("SELECT * FROM cliente_contato WHERE id='$id'");
				$res=mysql_fetch_array($sql);
				} ?>
                <tr> 
                  <td width="62" class="textobold">&nbsp;Nome</td>
                  <td width="164" class="textobold"><input name="nome" type="text" class="formularioselect" id="nome" value="<? print $res["nome"]; ?>" size="30" maxlength="50"></td>
                  <td width="52" class="textobold">&nbsp;</td>
                  <td width="70" class="textobold">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Cargo</td>
                  <td class="textobold"><input name="cargo" type="text" class="formularioselect" id="cargo" value="<? print $res["cargo"]; ?>" size="30" maxlength="50"></td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Telefone 1</td>
                  <td class="textobold"><input name="fone1" type="text" class="formularioselect" id="fone1" value="<? print $res["fone1"]; ?>" size="30" maxlength="50"></td>
                  <td class="textobold">&nbsp;Ramal</td>
                  <td class="textobold"><input name="ramal1" type="text" class="formularioselect" id="ramal1" value="<? print $res["ramal1"]; ?>" size="10" maxlength="50"></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Telefone 2</td>
                  <td class="textobold"><input name="fone2" type="text" class="formularioselect" id="fone2" value="<? print $res["fone2"]; ?>" size="30" maxlength="50"></td>
                  <td class="textobold">&nbsp;Ramal</td>
                  <td class="textobold"><input name="ramal2" type="text" class="formularioselect" id="ramal2" value="<? print $res["ramal2"]; ?>" size="10" maxlength="50"></td>
                </tr>
                <tr>
                  <td class="textobold"> &nbsp;Fax</td>
                  <td class="textobold"><input name="fax" type="text" class="formularioselect" id="fax" value="<? print $res["fax"]; ?>" size="30" maxlength="50"></td>
                  <td class="textobold">&nbsp;Ramal</td>
                  <td class="textobold"><input name="ramal3" type="text" class="formularioselect" id="ramal3" value="<? print $res["ramal3"]; ?>" size="10" maxlength="50"></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Celular</td>
                  <td class="textobold"><input name="celular" type="text" class="formularioselect" id="celular" value="<? print $res["celular"]; ?>" size="30" maxlength="50"></td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Email</td>
                  <td class="textobold"><input name="email" type="text" class="formularioselect" id="email" value="<? print $res["email"]; ?>" size="30" maxlength="50"></td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Autonomia </td>
                  <td class="textobold"><select name="autonomia" id="linha">
                      <option selected="">Selecione</option>
                      <option value="decisor" <? if($res["autonomia"]=="decisor"){ print "selected"; } ?>>Decisor</option>
                      <option value="influenciador" <? if($res["autonomia"]=="influenciador"){ print "selected"; } ?>>Influenciador</option>
                    </select>                  </td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Atua&ccedil;&atilde;o </td>
                  <td class="textobold"><select name="atuacao" id="linha">
                      <option selected="selected">Selecione</option>
                      <option value="equipamentos" <? if($res["atuacao"]=="equipamentos"){ print "selected"; } ?>>Equipamentos</option>
                      <option value="pdv" <? if($res["atuacao"]=="pdv"){ print "selected"; } ?>>PDV+</option>
					  <option value="geral" <? if($res["atuacao"]=="geral"){ print "selected"; } ?>>Geral</option>
                    </select>                  </td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
                
                <tr align="center"> 
                  <td colspan="4" class="textobold">
                    <input name="Submit222" type="button" class="microtxt" value="voltar" onClick="window.location='cliente_contatos.php?cli=<? print $cli; ?>'">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao2" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"> 
                    <input name="id" type="hidden" id="id3" value="<? print $id; ?>">
                  <input name="cli" type="hidden" id="cli" value="<? print $cli; ?>">
                  <input name="pag" type="hidden" id="cli2" value="<? print $pag; ?>"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>