<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cortina";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO cortinas_not (nome,tubo,perfil1,perfil2) VALUES ('$nome','$tubo','$perfil1','$perfil2')");
	if($sql){
		$_SESSION["mensagem"]="Cortina incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Cortina não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE cortinas_not SET nome='$nome',tubo='$tubo',perfil1='$perfil1',perfil2='$perfil2' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cortina alterada com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Cortina não pôde ser alterada!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM cortinas_not WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Cortina excluída com sucesso!";
		}else{
			$_SESSION["mensagem"]="A Cortina não pôde ser excluída!";
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
                <td><div align="center"><a href="cortina.php?acao=inc" class="textobold">Incluir 
                    uma Cortina</a> </div></td>
              </tr>
            </table>
            <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="406">&nbsp;Cortina</td>
                <td width="20">&nbsp;</td>
                <td width="20">&nbsp;</td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM cortinas_not ORDER BY id ASC") or erp_db_fail();
			  
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="3" align="center" class="textobold">NENHUMA CORTINA 
                  CADASTRADO </td>
              </tr>
			  <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<?php print $res["nome"]; ?></td>
                <td width="20" align="center"><a href="cortina.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta Cortina?','cortina.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?php
			  	}
			  }
			  ?>
            </table>
            </td>
        </tr>
		<?php }elseif($acao=="inc" or $acao=="alt"){
				$sql=mysql_query("SELECT * FROM cortinas_not WHERE id='$id'");
				$res=mysql_fetch_array($sql);
		 ?>
        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <?php if($acao=="inc"){ print"Incluir Cortina"; }else{ print"Alterar Cortina";} ?>                  </td>
                </tr>
                <tr>
                  <td width="73" valign="middle" class="textobold">&nbsp;Nome</td>
                  <td width="227" class="textobold"><input name="nome" type="text" class="formularioselect" id="nome" value="<?php echo  $res["nome"]; ?>"></td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Tubo Alum&iacute;nio 7/8
<input name="tubo" type="hidden" id="tubo" value="<?php echo  $res["tubo"]; ?>"></td>
                  <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[tubo]'"); $res2=mysql_fetch_array($sql2);
				?>
                        <td><input name="perfiln" type="text" class="formularioselect" id="perfiln" value="<?php print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                        <td width="20" align="center"><a href="#" onClick="return abre('cortina_prod.php?cp1=tubo&cp2=perfiln','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Perfil Puxador
                    <input name="perfil1" type="hidden" id="perfil1" value="<?php echo  $res["perfil1"]; ?>"></td>
                  <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[perfil1]'"); $res2=mysql_fetch_array($sql2);
				?>
                        <td><input name="perfiln2" type="text" class="formularioselect" id="perfiln2" value="<?php print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                        <td width="20" align="center"><a href="#" onClick="return abre('cortina_prod.php?cp1=perfil1&cp2=perfiln2','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a><a href="#" onClick="return abre('perfil_prod.php','busca','width=420,height=300,scrollbars=1');"></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Perfil Caixa 
                    <input name="perfil2" type="hidden" id="perfil2" value="<?php echo  $res["perfil2"]; ?>"></td>
                  <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php
				$sql2=mysql_query("SELECT * FROM prodserv WHERE id='$res[perfil2]'"); $res2=mysql_fetch_array($sql2);
				?>
                        <td><input name="perfiln3" type="text" class="formularioselect" id="perfiln3" value="<?php print $res2["nome"]; ?>" size="7" maxlength="50" readonly></td>
                        <td width="20" align="center"><a href="#" onClick="return abre('cortina_prod.php?cp1=perfil2&cp2=perfiln3','busca','width=420,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a><a href="#" onClick="return abre('perfil_prod.php','busca','width=420,height=300,scrollbars=1');"></a></td>
                      </tr>
                  </table></td>
                </tr>
                

                <tr align="center"> 
                  <td colspan="2" class="textobold">
                    <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='cortina.php?acao=entrar'">
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