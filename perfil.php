<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$b1=Input::request("b1");
$b2=Input::request("b2");
$val=Input::request("val");
$nome=Input::request("nome");
$perfil=Input::request("perfil");
$id=Input::request("id");
$class=Input::request("class");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Perfil";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$b1=valor2banco($b1);
	$b2=valor2banco($b2);
	$val=valor2banco($val);
	$sql=mysql_query("INSERT INTO perfil (nome,perfil,b1,b2) VALUES ('$nome','$perfil','$b1','$b2')");
	if($sql){
		$_SESSION["mensagem"]="Perfil incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Perfil não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$b1=valor2banco($b1);
	$b2=valor2banco($b2);
	$val=valor2banco($val);
	$sql=mysql_query("UPDATE perfil SET nome='$nome',perfil='$perfil',b1='$b1',b2='$b2' WHERE id='$id'") or erp_db_fail();
	if($sql){
		$_SESSION["mensagem"]="Perfil alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Perfil não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM perfil WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Perfil excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Perfil não pôde ser excluído!";
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
<script src="mascaras.js"></script>
</head>

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Perfil</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <?php if($acao=="entrar"){ ?>
		<tr> 
          <td><table width="300" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="perfil.php?acao=inc" class="textobold">Incluir 
                    um perfil</a> </div></td>
              </tr>
            </table>
            <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="406">&nbsp;Perfil</td>
                <td width="20">&nbsp;</td>
                <td width="20">&nbsp;</td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM perfil ORDER BY id ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="3" align="center" class="textobold">NENHUM PERFIL 
                  CADASTRADO </td>
              </tr>
			  <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<?php print $res["nome"]; ?></td>
                <td width="20" align="center"><a href="perfil.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir este perfil?','perfil.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?php
			  	}
			  }
			  ?>
            </table>
            </td>
        </tr>
		<?php }elseif($acao=="inc" or $acao=="alt"){
				$sql=mysql_query("SELECT * FROM perfil WHERE id='$id'");
				$res=mysql_fetch_array($sql);
		 ?>
        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="300" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <?php if($acao=="inc"){ print"Incluir Perfil"; }else{ print"Alterar Perfil";} ?>                  </td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Nome</td>
                  <td class="textobold"><input name="nome" type="text" class="formularioselect" id="nome" value="<?php echo  $res["nome"]; ?>"></td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;PVC Inf
                    <input name="perfil" type="hidden" id="perfil" value="<?php echo  $res["perfil"]; ?>"></td>
                  <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[perfil]'"); $res2=mysql_fetch_array($sql2);
				?>
                        <td><input name="perfiln" type="text" class="formularioselect" id="perfiln" value="<?php print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                        <td width="20" align="center"><a href="#" onClick="return abre('perfil_prod.php','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                      </tr>
                  </table></td>
                </tr>
                
                <tr>
                  <td width="73" class="textobold">&nbsp;Banda1(CS)</td>
                  <td width="227" class="textobold"><input name="b1" type="text" class="formulario" id="b1" value="<?php print banco2valor($res["b1"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <?php if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);"></td>
                </tr>
                <tr>
                  <td class="textobold">&nbsp;Banda2(CI)</td>
                  <td class="textobold"><input name="b2" type="text" class="formulario" id="b2" value="<?php print banco2valor($res["b2"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" <?php if($class=="I") print "readonly"; ?> onBlur="ccusto(this.form);"></td>
                </tr>
                
                <tr align="center"> 
                  <td colspan="2" class="textobold">
                    <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='perfil.php?acao=entrar'">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao2" value="<?php if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>">
                  <input name="id" type="hidden" id="id" value="<?php echo  $id; ?>"></td>
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