<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Natureza";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO natureza (nome,codigo) VALUES ('$nome','$codigo')");
	if($sql){
		$_SESSION["mensagem"]="Natureza incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A natureza não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE natureza SET nome='$nome',codigo='$codigo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Natureza alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A natureza não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM natureza WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Natureza excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="A Natureza não pôde ser excluído!";
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Cargo');
		cad.nome.focus();
		return false;
	}
	return true;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Natureza</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
        <? if($acao=="entrar"){ ?>
		<tr> 
          <td><table width="300" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="natureza.php?acao=inc" class="textobold">Incluir 
                    uma Natureza</a> </div></td>
              </tr>
            </table>
            <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="406">&nbsp;Cargo</td>
                <td width="20">&nbsp;</td>
                <td width="20">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM natureza ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="3" align="center" class="textobold">NENHUMA NATUREZA 
                  CADASTRADO </td>
              </tr>
			  <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<? print $res["nome"]; ?></td>
                <td width="20" align="center"><a href="natureza.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta natureza?','natureza.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?
			  	}
			  }
			  ?>
            </table>
          </td>
        </tr>
		<? }elseif($acao=="inc" or $acao=="alt"){ ?>
        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="300" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <? if($acao=="inc"){ print"Incluir Natureza"; }else{ print"Alterar Natureza";} ?>
                  </td>
                </tr>
                <? 
				$sql=mysql_query("SELECT * FROM natureza WHERE id='$id'");
				$res=mysql_fetch_array($sql);
				?>
                <tr> 
                  <td width="39" class="textobold">&nbsp;C&oacute;digo</td>
                  <td width="258" class="texto"><input name="codigo" type="text" class="formulario" id="codigo" value="<? print $res["codigo"]; ?>" size="3"></td>
                </tr>
                
                <tr> 
                  <td class="textobold">&nbsp;Nome</td>
                  <td class="textobold"> <input name="nome" type="text" class="formulario" id="nome" value="<? print $res["nome"]; ?>" size="45" maxlength="50">
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="2" class="textobold">
                    <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='cargos.php'">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao2" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"></td>
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