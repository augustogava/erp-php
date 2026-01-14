<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="desenho";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='desenho'");
if(mysql_num_rows($sqlm)){
	$resm=mysql_fetch_array($sqlm);
	if($resm["funcionario"]=="S" or empty($resm["funcionario"])){
		$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}else{
		$sql2=mysql_query("SELECT * FROM clientes WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}
	$_SESSION["mensagem"]="O usuario $res2[nome] está alterando esta peça!";
	header("Location:apqp_menu.php");
	exit;
}

// - - -FIM- - - 
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM apqp_des WHERE id='$id'");
	$res=mysql_fetch_array($sql);
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.descr.value==''){
		alert('Informe a descrição');
		cad.descr.focus();
		return false;
	}
	if(cad.acao.value=='inc' && cad.arquivo.value==''){
		alert('Selecione o desenho');
		cad.arquivo.focus();
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
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
       <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_desenho.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Desenho'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('No CYBERMananger é possível cadastrar desenhos relacionados ao APQP da peça ou processo. Para cadastrar um incluir desenho, esta pagina exibe os desenhos já cadastrados.<br><strong>Cadastro de desenho </strong><br>Quando um desenho é cadastrado, no  CYBERMananger faz uma cópia do arquivo para o servidor. Não há um vínculo direto com o arquivo original após o registro. Assim, se o arquivo original for modificado, esta alteração não será refletida no documento registrado no CYBERManager. Para que a nova versão do desenho esteja disponível, é necessário recadastrá-lo.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
       <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - Desenhos <?php print $npc; ?></div></td>
     </tr>
     <tr>
       <td align="center">&nbsp;</td>
       <td align="right">&nbsp;</td>
     </tr>
</table>
<table width="602"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="608"><table width="594" border="0" cellpadding="0" cellspacing="0">
      <?php if($acao=="entrar"){ ?>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><a href="apqp_des.php?acao=inc" class="textobold">Incluir Desenho </a> </td>
            </tr>
          </table>
            <table width="594" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
              <tr class="textoboldbranco">
                <td width="273">&nbsp;Descri&ccedil;&atilde;o</td>
                <td width="232">&nbsp;Desenho</td>
                <td width="22" align="center">Obs</td>
                <td width="19" align="center">&nbsp;</td>
                <td width="19" align="center">&nbsp;</td>
                <td width="22" align="center">&nbsp;</td>
              </tr>
              <?php
$sql=mysql_query("SELECT * FROM apqp_des WHERE peca='$pc' ORDER BY descr ASC");
if(mysql_num_rows($sql)==0){
?>
              <tr align="center" bgcolor="#FFFFFF" class="texto">
                <td colspan="6" align="center" class="textopretobold">NENHUM DOCUMENTO ENCONTRADO </td>
              </tr>
              <?php
}else{
	while($res=mysql_fetch_array($sql)){
		
?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td width="273">&nbsp;<?php print $res["descr"]; ?> </td>
                <td width="232">&nbsp;<?php print $res["original"]; ?></td>
                <td width="22" align="center"><a href="#"  onClick="return abre('apqp_desobs.php?id=<?php print $res["id"]; ?>','obs','width=320,height=200,scrollbars=1');"><img src="imagens/icon14_visualizar.gif" alt="Observa&ccedil;&otilde;es" width="14" height="14" border="0"></a></td>
                <td width="19" align="center"><a href="apqp_desdown.php?id=<?php print $res["id"]; ?>"><img src="imagens/icon_14_down.gif" alt="Download" width="14" height="14" border="0"></a></td>
                <td width="19" align="center"><a href="apqp_des.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="22" align="center"><a href="#" onClick="return pergunta('Deseja excluir este desenho?','apqp_des_sql.php?acao=exc&id=<?php print $res["id"]; ?>');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
	}
}
?>
          </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><img src="imagens/dot.gif" width="200" height="10"></td>
      </tr>
      <tr>
        <td align="center" valign="top"><input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
            <img src="imagens/dot.gif" width="20" height="5"></td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td align="left" valign="top"><form action="apqp_des_sql.php" method="post" enctype="multipart/form-data" name="frmdes" onSubmit="return verifica(this)">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco"><?php if($acao=="alt"){ print "Alterar"; }else{ print "Incluir"; } ?>
&nbsp;Desenho</td>
              </tr>
              <tr>
                <td width="60" class="textobold">Descri&ccedil;&atilde;o:</td>
                <td width="519"><input name="descr" type="text" class="formularioselect" id="descr" value="<?php print $res["descr"]; ?>" maxlength="50"></td>
              </tr>
              <?php if($acao=="alt"){ ?>
              <tr>
                <td class="textobold">Nome:</td>
                <td class="texto">&nbsp;<?php print $res["original"]; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td class="textobold">Desenho:</td>
                <td><input name="arquivo" type="file" class="formularioselect" id="arquivo"></td>
              </tr>
              <tr>
                <td class="textobold">Obs:</td>
                <td><input name="obs" type="text" class="formularioselect" id="local4" value="<?php print $res["obs"]; ?>" maxlength="255"></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="textobold"><input name="id" type="hidden" id="id" value="<?php print $id; ?>">
                    <input name="acao" type="hidden" id="acao" value="<?php print $acao; ?>">
                    <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_des.php';">
                    &nbsp;
					<input name="button1222" type="submit" class="microtxt" value="Continuar">
&nbsp;&nbsp; <?php
$apqp->agenda_p("Desenho (Se aplicável)","apqp_des.php");
?></td>
              </tr>
            </table>
        </form></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>