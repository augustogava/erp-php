<?php
include("conecta.php");
include("seguranca.php");
$acao = Input::request('acao', '');
$id = Input::request('id', '');
$nome = Input::request('nome', '');
$acao = verifi($permi, $acao);
if(!empty($acao)){
	$loc="Grupos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO grupos (nome) VALUES ('$nome')");
	if($sql){
		$_SESSION["mensagem"]="Incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="Não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE grupos SET nome='$nome' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="Não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM grupos WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="Não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
<!--

function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe o Nome');
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

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Grupos</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
        <?php if($acao=="entrar"){ ?>
		<tr> 
          <td><table width="300" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="grupos.php?acao=inc" class="textobold">Incluir</a> </div></td>
              </tr>
            </table>
            <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="406">&nbsp;Tipos</td>
                <td width="20">&nbsp;</td>
                <td width="20">&nbsp;</td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM grupos ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="3" align="center" class="textobold">NENHUM TIPO 
                  CADASTRADO </td>
              </tr>
			  <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<?php print $res["nome"]; ?></td>
                <td width="20" align="center"><a href="grupos.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir?','grupos.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?php
			  	}
			  }
			  ?>
            </table>
          </td>
        </tr>
		<?php }elseif($acao=="inc" or $acao=="alt"){ ?>
        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="300" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <?php if($acao=="inc"){ print"Incluir Grupo"; }else{ print"Alterar Grupo";} ?>                  </td>
                </tr>
                <?php if($acao=="alt"){
				$sql=mysql_query("SELECT * FROM grupos WHERE id='$id'");
				$res=mysql_fetch_array($sql);
				?>
                
                <?php } ?>
                <tr> 
                  <td width="39" class="textobold">&nbsp;Nome</td>
                  <td width="258" class="textobold"> <input name="nome" type="text" class="formulario" id="nome" value="<?php print $res["nome"]; ?>" size="45" maxlength="50">                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="2" class="textobold"><input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao2" value="<?php if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>"></td>
                </tr>
              </table>
            </form></td>
        </tr>
		<?php } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>