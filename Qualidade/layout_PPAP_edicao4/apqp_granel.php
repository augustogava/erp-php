<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="granel";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='granel'");
if(mysql_num_rows($sqlm)){
	$resm=mysql_fetch_array($sqlm);
	if($resm["funcionario"]=="S" or empty($resm["funcionario"])){
		$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}else{
		$sql2=mysql_query("SELECT * FROM clientes WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}
	$_SESSION["mensagem"]="O usuario $res2[nome] está alterando este módulo!";
	header("Location:apqp_menu.php");
	exit;
}
// - - -FIM- - - 
$sql=mysql_query("SELECT * FROM apqp_granel WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO apqp_granel (peca) VALUES ('$pc')");
	$sql=mysql_query("SELECT * FROM apqp_granel WHERE peca='$pc'");
}
$res=mysql_fetch_array($sql);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function bloke(){
	document.all.form1.ap1.disabled=true;	
	document.all.form1.ap2.disabled=true;	
	document.all.form1.ap3.disabled=true;	
	document.all.form1.lap1.disabled=true;	
	document.all.form1.lap2.disabled=true;	
	document.all.form1.lap3.disabled=true;	
}
function vailogo(type){
	form1.acao.value=type;
	form1.submit();
	return true
}
function vailogo1(type,peca){
	window.open('apqp_imp_email.php?acao='+type+'&local='+form1.local.value+'&email='+form1.email.value+'&pc='+peca,'busca','width=430,height=140,scrollbars=1');
}
function abrir(url,id){
	window.location='pdf/'+url+'.php?id='+id+'';
	return true;
}
function salvar(url,id){
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?=$pc?> + '');
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
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_checklist_material.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Checklist Material a Granel '; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Os campos serão preenchidos automaticamente com o nome de quem está acessando o CYBERMananger juntamente com a respectiva data.<br>Nota: Para remover uma aprovação o usuário deve clicar no botão Limpar<br>Enviar por e-mail - clique no primeiro ícone e selecione o destinatário o e-mail é preenchido automaticamente e depois clique no ícone enviar, se quiser imprimir clique no ícone imprimir ao lado.')"></a></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Checklist Material a Granel &nbsp;<? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr> <a href="apqp_granelt.php">
        <td width="132" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">lista de verif.</td>
        </a>
          <td width="134" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco"><span class="textoboldbranco">aprova&ccedil;&atilde;o</span></td>
          <td width="320">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_granel_sql.php"><td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="84" align="center" class="textobold">Aprovado por: </td>
                  <td width="210"><input name="tap1" type="text" class="formularioselect" id="tap1" value="<?= $res["ap1"]; ?>"></td>
                  <td width="51" align="center" class="textobold">Data:</td>
                  <td width="66"><input name="dap1" type="text" class="formularioselect" id="dap1" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["dap1"]); ?>" size="7" maxlength="10" readonly=""></td>
				   <? 
				  if(empty($res["ap1"])){
				  	$javas="if(confirm('Deseja Aprovar esse Checklist?')){ form1.acao.value='g2';form1.submit();}else{ return false; } ";
				  }else{
				  $javas="window.alert('Clique em Limpar primeiro');return false;";
				  }
				  ?>
                  <td width="131" align="center">
                        <input name="ap1" type="submit" class="microtxt" id="ap1" value="aprovar" onClick="<?= $javas; ?>">
                      &nbsp;
					      <input name="lap1" type="submit" class="microtxt" id="lap1" value="limpar" onClick="if(confirm('Deseja Aprovar esse Checklist?')){form1.acao.value='g2';form1.submit();}else{ return false; }"></td>
                </tr>
                <tr>
                  <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                </tr>
                <tr>
                  <td align="center" class="textobold">Aprovado por: </td>
                  <td><input name="tap12" type="text" class="formularioselect" id="tap12" value="<?= $res["ap2"]; ?>"></td>
                  <td align="center" class="textobold">Data:</td>
                  <td><input name="dap2" type="text" class="formularioselect" id="dap2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["dap2"]); ?>" size="7" maxlength="10" readonly=""></td>
				  <? 
				  if(empty($res["ap2"])){
				  	$javas="if(confirm('Deseja Aprovar esse Checklist?')){ form1.acao.value='g2';form1.submit();}else{ return false; } ";
				  }else{
				  $javas="window.alert('Clique em Limpar primeiro');return false;";
				  }
				  ?>
                  <td align="center"><div align="center">
                        <input name="ap2" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?= $javas; ?>">
                      &nbsp;
					    <input name="lap2" type="submit" class="microtxt" id="lap2" value="limpar" onClick="if(confirm('Deseja Aprovar esse Checklist?')){form1.acao.value='g2';form1.submit();}else{ return false; }">
                  </div></td>
                </tr>
                <tr>
                  <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                </tr>
                <tr>
                  <td align="center" class="textobold">Aprovado por: </td>
                  <td><input name="tap13" type="text" class="formularioselect" id="tap13" value="<?= $res["ap3"]; ?>"></td>
                  <td align="center" class="textobold">Data:</td>
                  <td><input name="dap3" type="text" class="formularioselect" id="dap3" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["dap3"]); ?>" size="7" maxlength="10" readonly=""></td>
				 <? 
				  if(empty($res["ap3"])){
				  	$javas="if(confirm('Deseja Aprovar esse Checklist?')){ form1.acao.value='g2';form1.submit();}else{ return false; } ";
				  }else{
				  $javas="window.alert('Clique em Limpar primeiro');return false;";
				  }
				  ?>
                  <td align="center"><div align="center">
                        <input name="ap3" type="submit" class="microtxt" id="ap3" value="aprovar" onClick="<?= $javas; ?>">
                      &nbsp;
					    <input name="lap3" type="submit" class="microtxt" id="lap3" value="limpar" onClick="if(confirm('Deseja Aprovar esse Checklist?')){form1.acao.value='g2';form1.submit();}else{ return false; }">
                  </div></td>
                </tr>
                <input name="acao2" type="hidden" id="acao2" value="v4">
              </table><? if($aprov=="N") print "<script>bloke();</script>"; ?></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;</td>
            </tr>
            <tr class="textobold">
              <td><img src="imagens/dot.gif" width="20" height="8">
         
                <table width="601" border="0" align="center" cellpadding="3" cellspacing="0" class="texto">
                  <tr>
				  <? if($_SESSION["e_mail"]=="S"){ ?>
                    <td width="16%" align="left" class="textobold">&nbsp;Enviar e-mail: </td>
                    <td width="56%"><input name="email" type="text" class="formularioselect" id="email3" value="Digite o e-mail aqui"></td> 
					<? if(in_array("U",$emailt)){ ?>
                    <td width="3%"><div align="center"><a href="#" onClick="return abre('busca_email2.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" alt="Buscar Email de Funcionários" width="14" height="14" border="0"></a></div></td>
					<? } if(in_array("G",$emailt)){ ?>
                    <td width="8%"><div align="center"><a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');"><input name="grupo" type="hidden" id="grupo">
                <input name="grupo_nome" type="hidden" id="grupo_nome"><img src="imagens/icon14_grupo.gif" alt="Buscar Grupo de Emails" width="26" height="13" border="0"></a></div></td>
				 <? } if(in_array("C",$emailt)){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Emails de Clientes" width="18" height="18" border="0"></a></div></td>
				<? } ?>
                    <td width="9%"><div align="center"><? if($_SESSION["login_funcionario"]=="S"){ ?><a href="#" onClick="vailogo1('email','<?= $pc; ?>');"><img src="imagens/icon14_mail.gif" alt="Enviar Email" width="16" height="10" border="0"></a><? } ?></div></td>
					<? } if($_SESSION["i_mp"]=="S"){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="vailogo('imp');"><img src="imagens/icon14_imp.gif" alt="Imprimir" width="15" height="15" border="0"></a></div></td>
					<? } ?>
                  </tr>
                  <tr>
                    <td colspan="7" align="left" class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
                    </tr>
                </table>
			</td>
            </tr>
            <tr>
              <td align="center"><img src="imagens/spacer.gif" width="46" height="10"></td>
            </tr>
            <tr>
              <td align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_granelt.php';">&nbsp;
				<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('granel','<?=$res["id"];?>')">&nbsp;
                <input name="acao" type="hidden" id="acao" value="1">                <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
                <input name="local" type="hidden" id="local" value="granel">
                </a></td>
              </tr>
          </table>
        </td></form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>