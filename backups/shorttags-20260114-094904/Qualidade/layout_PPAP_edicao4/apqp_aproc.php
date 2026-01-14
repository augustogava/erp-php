<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="apare";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='apare'");
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
$sql=mysql_query("SELECT * FROM apqp_apro WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO apqp_apro (peca) VALUES ('$pc')");
	$sql=mysql_query("SELECT * FROM apqp_apro WHERE peca='$pc'");
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
	document.all.form1.ap.disabled=true;	
	document.all.form1.lap.disabled=true;	
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_aprova_apa.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Aprovação de Aparência'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Relatório de Aprovação de Aparência deve ser preenchido conforme o Manual do PPAP da AIAG - Segunda Edição, Fevereiro 95 Segunda Impressão Julho 95.<br>Preenchimentos dos Campos:<br><strong>Local da Fabricação - </strong>Localidade onde a peça está sendo desenvolvida, fabricada ou montada.<br><strong>Data - </strong>Data da aprovação<br><strong>Razão para a submissão - </strong>Marcar o(s) quadro(s) que indicam as razões para submissão<br><strong>Avaliação ded Aparência - </strong>Informações da aparência da peça o estado físico da peça.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1">APQP - Aprova&ccedil;&atilde;o de Apar&ecirc;ncia&nbsp;<? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">cabe&ccedil;alho</td>
		<a href="apqp_aprot.php">
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">avalia&ccedil;&atilde;o de cor </td>
		</a>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_apro_sql.php"><td bgcolor="#FFFFFF">
          <table width="571" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="78" class="textobold">Local de Fab.:</td>
              <td width="338"><input name="localfab" type="text" class="formularioselect" id="localfab" value="<?= $res["local"]; ?>" size="1" maxlength="255"></td>
              <td width="45" align="right" class="textobold"><div align="center">Data:</div></td>
              <td width="100"><input name="data" type="text" class="formulario" id="data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["data"]); ?>" size="10" maxlength="10">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_aproc&var_field=data','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              </tr>
            <tr>
              <td class="textobold">Comprador:</td>
              <td colspan="3"><input name="comprador" type="text" class="formularioselect" id="comprador" value="<?= $res["comprador"]; ?>" size="7" maxlength="50"></td>
              </tr>
            <tr>
              <td colspan="4"><img src="imagens/dot.gif" width="20" height="5"></td>
            </tr>
            <tr>
              <td colspan="4"><table width="571" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td align="center" class="textoboldbranco">raz&atilde;o para submiss&atilde;o</td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td class="textobold"><table width="571" border="0" cellspacing="0" cellpadding="3">
                    <tr class="textobold">
                      <td width="50%"><input name="razao1" type="radio" value="1" <? if(empty($res["razao1"]) or $res["razao1"]=="1") print "checked"; ?>>
      Certificado de submiss&atilde;o da pe&ccedil;a</td>
                      <td width="50%"><input name="razao1" type="radio" value="2" <? if($res["razao1"]=="2") print "checked"; ?>>
      Amostra especial </td>
                    </tr>
                  </table>
                  <table width="571" border="0" cellspacing="0" cellpadding="3">
                    <tr class="textobold">
                      <td width="50%"><input name="razao2" type="radio" value="1" <? if(empty($res["razao2"]) or $res["razao2"]=="1") print "checked"; ?>>
Embarque da primeira produ&ccedil;&atilde;o</td>
                      <td width="50%"><input name="razao2" type="radio" value="2" <? if($res["razao2"]=="2") print "checked"; ?>>
Altera&ccedil;&atilde;o de engenharia </td>
                    </tr>
                    <tr class="textobold">
                      <td width="50%"><input name="razao2" type="radio" value="3" <? if($res["razao2"]=="3") print "checked"; ?>>
                        Re-submiss&atilde;o</td>
                      <td width="50%"><input name="razao2" type="radio" value="4" <? if($res["razao2"]=="4") print "checked"; ?>>
                        Pr&eacute;-textura</td>
                    </tr>
                  </table>                    </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="4"><img src="imagens/dot.gif" width="20" height="5"></td>
              </tr>
            <tr class="textobold">
              <td colspan="4"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                  <td colspan="2" align="center" class="textoboldbranco">avalia&ccedil;&atilde;o de apar&ecirc;ncia </td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="155" class="textobold">&nbsp;Info. sobre sub-fornecedor &nbsp;e textura: </td>
                  <td width="413" class="textobold"><textarea name="aval" rows="3" wrap="VIRTUAL" class="formularioselect" id="aval" onFocus="enterativa=0;" onBlur="enterativa=1;"><?= $res["aval"]; ?></textarea></td>
                </tr>
              </table></td>
              </tr>
            <tr class="textobold">
              <td colspan="4"><img src="imagens/dot.gif" width="20" height="5"></td>
              </tr>
            <tr class="textobold">
              <td>Coment&aacute;rios:</td>
              <td colspan="3"><input name="coments" type="text" class="formularioselect" id="coments" value="<?= $res["coments"]; ?>" size="1" maxlength="255"></td>
              </tr>
            <tr class="textobold">
              <td colspan="4"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="16%" class="textobold">Aprovado por:</td>
                  <td width="37%"><input name="quem" type="text" class="formularioselect" id="quem" value="<?= $res["quem"]; ?>" readonly=""></td>
                  <td width="8%" align="right" class="textobold"><div align="right">Data:</div></td>
                  <td width="19%"><input name="dtquem" type="text" class="formularioselect" id="dtquem" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["dtquem"]); ?>" size="7" maxlength="10" readonly=""></td>
				   <? 
				  if(empty($res["quem"])){
				  	$javas="if(confirm('Deseja Aprovar Apar&ecirc;ncia?')){form1.acao.value='altc';form1.submit();}else{ return false; }";
				  }else{
				  $javas="window.alert('Clique em Limpar primeiro');return false;";
				  }
				  ?>
                  <td width="20%"><input name="ap" type="submit" class="microtxt" id="ap3" value="aprovar" onClick="<?= $javas; ?>">
&nbsp;
<input name="lap" type="submit" class="microtxt" id="lap3" value="limpar" onClick="if(confirm('Deseja excluir aprova&ccedil;&atilde;o?')){form1.acao.value='altc';form1.submit();}else{ return false; }"></td>
                </tr>
              </table><? if($aprov=="N") print "<script>bloke();</script>"; ?></td>
            </tr>
            <tr class="textobold">
              <td colspan="4"><img src="imagens/dot.gif" width="20" height="5"></td>
            </tr>
            <tr>
              <td colspan="4" align="center">
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
				
              <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
			&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('aparencia','<?=$res["id"];?>')">
			&nbsp;
			  <input name="button12222" type="submit" class="microtxt" value="Salvar" onClick="vailogo('altc')">
			&nbsp;&nbsp;
<?
$apqp->agenda_p("Relatório de Aprovação de Aparência (Se aplicável)","apqp_aproc.php");
?>
			  <input name="acao" type="hidden" id="acao" value="1">
			  <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
			  <input name="local" type="hidden" id="local" value="aparencia">
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
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>