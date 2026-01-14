<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="submi";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='submi'");
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
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO apqp_sub (peca) VALUES ('$pc')");
}
$sql=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
$res=mysql_fetch_array($sql);
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="form1.acao.value='s1'; form1.submit(); return false;";
		}else{
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='s1'; form1.submit(); }else{ return false; } }else{ return false; }";
		}
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
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?php echo $pc?> + '');
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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_certf_submi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Certificado de Submissão'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Certificado de Submissão deve ser preenchido conforme o Manual do PPAP da AIAG - Terceira Edição. Utilize as abas da parte superior da tela para navegar entre os diversos tópicos do certificado de submissão.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Certificado de submiss&atilde;o <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top" class="textobold"><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td width="94" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">inf. da pe&ccedil;a </td>
		<a href="apqp_sub2.php">
		<td width="115" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">inf. da submiss&atilde;o </td>
		</a>
		<a href="apqp_sub3.php">
        <td width="127" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">n&iacute;vel de submiss&atilde;o </td>
		</a>
		<a href="apqp_sub4.php">
        <td width="117" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">aprova&ccedil;&atilde;o forn. </td>
		</a>
		<a href="apqp_sub5.php">
		<td width="129" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">disposi&ccedil;&atilde;o do cliente </td>
		</a>        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_sub_sql.php">
          <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="587" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="156" class="textobold">N&uacute;mero Interno:</td>
                  <td width="212" class="textobold"><input name="numero" type="text" class="formularioselect" id="numero" value="<?php print $res["numero"]; ?>" maxlength="40" readonly=""></td>
                  <td width="57" class="textobold"><div align="right">Rev.:</div></td>
                  <td width="158">
                    
                        <div align="right">
                          <input name="rev" type="text" class="formulario" id="rev" value="<?php print $res["rev"]; ?>" size="20" maxlength="20" readonly="">
                        </div></td>
                </tr>
                <tr>
                  <td class="textobold">Nome da Pe&ccedil;a:</td>
                  <td colspan="3"><input name="nome" type="text" class="formularioselect" id="nome" value="<?php print $res["nome"]; ?>" maxlength="150"></td>
                </tr>
                <tr>
                  <td class="textobold">Desenho Int.:</td>
                  <td><input name="desenhoi" type="text" class="formularioselect" id="desenhoi" value="<?php print $res["desenhoi"]; ?>" maxlength="30"></td>
                  <td>                      <div align="left"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">N&ordm; Pe&ccedil;a Cli.:</td>
                  <td><input name="pecacli" type="text" class="formularioselect" id="pecacli" value="<?php print $res["pecacli"]; ?>" maxlength="30"></td>
                  <td><div align="left"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">Desenho Cli.:</td>
                  <td class="textobold"><input name="desenhoc" type="text" class="formularioselect" id="desenhoc" value="<?php print $res["desenhoc"]; ?>" maxlength="30"></td>
                  <td class="textobold"><div align="right">Peso:</div></td>
                  <td>
                    <div align="right">
                      <input name="peso" type="text" class="formulario" id="peso2" size="20" onKeyDown="formataMoeda4(this,retornaKeyCode(event))" onKeyUp="formataMoeda4(this,retornaKeyCode(event))" value="<?php echo  banco2valor4($res["peso"]); ?>">
                      </div></td>
                </tr>
                <tr>
                  <td class="textobold">Aplica&ccedil;&atilde;o:</td>
                  <td><input name="aplicacao" type="text" class="formularioselect" id="aplicacao" value="<?php print $res["aplicacao"]; ?>" maxlength="50"></td>
                  <td><div align="left"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">N&iacute;vel de altera&ccedil;&atilde;o Eng.:</td>
                  <td class="textobold"><input name="niveleng" type="text" class="formularioselect" id="niveleng" value="<?php print $res["niveleng"]; ?>" maxlength="20"></td>
                  <td class="textobold">
                    <div align="right">Data:</div></td>
                  <td>
                    <div align="right">
                      <input name="dteng" type="text" class="formulario" id="dteng" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["dteng"]); ?>" size="15" maxlength="10" data>
                      &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_sub1_1','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></div></td>
                </tr>
                <tr>
                  <td class="textobold">Altera&ccedil;&otilde;es adicionais Eng.:</td>
                  <td class="textobold"><input name="alteng" type="text" class="formularioselect" id="alteng" value="<?php print $res["alteng"]; ?>" maxlength="20"></td>
                  <td class="textobold"><div align="right">Data:</div></td>
                  <td>
                    <div align="right">
                      <input name="dtalteng" type="text" class="formulario" id="dtalteng2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["dtalteng"]); ?>" size="15" maxlength="10" data>
                      &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_sub1_2','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a>                       </div></td>
                </tr>
                <tr>
                  <td class="textobold">N&ordm; do pedido de compra:</td>
                  <td><input name="ncompra" type="text" class="formularioselect" id="ncompra" value="<?php print $res["ncompra"]; ?>" maxlength="20"></td>
                  <td><div align="left"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">N&ordm; PPAP:</td>
                  <td><input name="nppap" type="text" class="formularioselect" id="nppap" value="<?php print $res["nppap"]; ?>" maxlength="20"></td>
                  <td><div align="left"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4" class="textobold"><img src="imagens/dot.gif" width="50" height="5">
                    <table width="300" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#003366">
                      <tr>
                        <td align="center" class="textoboldbranco">item de seguran&ccedil;a / regulament. governamental </td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="textobold"><input name="isrg" type="radio" value="S" <?php if($res["isrg"]=="S") print "checked"; ?>>
      Sim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="isrg" type="radio" value="N" <?php if($res["isrg"]=="N") print "checked"; ?>>
      N&atilde;o</td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td colspan="4" class="textobold"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
                    <tr>
                      <td colspan="6" align="center" class="textoboldbranco">aux&iacute;lio de medi&ccedil;&atilde;o </td>
                      </tr>
                    <tr class="textobold">
                      <td width="22" bgcolor="#FFFFFF" class="textobold">&nbsp;N&ordm;:</td>
                      <td width="70" bgcolor="#FFFFFF" class="textobold"><input name="aux_num" type="text" class="formularioselectsemborda" id="aux_num" value="<?php print $res["aux_num"]; ?>" size="1" maxlength="20"></td>
                      <td width="148" bgcolor="#FFFFFF" class="textobold">&nbsp;n&iacute;vel da altera&ccedil;&atilde;o de eng.:</td>
                      <td width="91" bgcolor="#FFFFFF" class="textobold"><input name="aux_nivel" type="text" class="formularioselectsemborda" id="aux_nivel" value="<?php print $res["aux_nivel"]; ?>" size="1" maxlength="20"></td>
                      <td width="26" align="center" bgcolor="#FFFFFF" class="textobold">data:</td>
                      <td width="75" bgcolor="#FFFFFF" class="textobold"><input name="aux_data" type="text" class="formularioselectsemborda2222" id="aux_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print banco2data($res["aux_data"]); ?>" size="6" maxlength="10" data>
                        <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_sub1_3','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="4" class="textobold">
                <table width="601" border="0" align="center" cellpadding="3" cellspacing="0" class="texto">
                  <tr>
				  <?php if($_SESSION["e_mail"]=="S"){ ?>
                    <td width="16%" align="left" class="textobold">&nbsp;Enviar e-mail: </td>
                    <td width="56%"><input name="email" type="text" class="formularioselect" id="email3" value="Digite o e-mail aqui"></td> 
					<?php if(in_array("U",$emailt)){ ?>
                    <td width="3%"><div align="center"><a href="#" onClick="return abre('busca_email2.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" alt="Buscar Email de Funcionários" width="14" height="14" border="0"></a></div></td>
					<?php } if(in_array("G",$emailt)){ ?>
                    <td width="8%"><div align="center"><a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');"><input name="grupo" type="hidden" id="grupo">
                <input name="grupo_nome" type="hidden" id="grupo_nome"><img src="imagens/icon14_grupo.gif" alt="Buscar Grupo de Emails" width="26" height="13" border="0"></a></div></td>
				 <?php } if(in_array("C",$emailt)){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Emails de Clientes" width="18" height="18" border="0"></a></div></td>
				<?php } ?>
                    <td width="9%"><div align="center"><?php if($_SESSION["login_funcionario"]=="S"){ ?><a href="#" onClick="vailogo1('email','<?php echo  $pc; ?>');"><img src="imagens/icon14_mail.gif" alt="Enviar Email" width="16" height="10" border="0"></a><?php } ?></div></td>
					<?php } if($_SESSION["i_mp"]=="S"){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="vailogo('imp');"><img src="imagens/icon14_imp.gif" alt="Imprimir" width="15" height="15" border="0"></a></div></td>
					<?php } ?>
                  </tr>
                  <tr>
                    <td colspan="7" align="left" class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
                    </tr>
                </table>			</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr>
              <td align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php'">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('submissao','<?php echo $res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar"  onClick="<?php echo  $btnsalva; ?>">
&nbsp;
<input name="acao" type="hidden" id="acao" value="1">
<a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
<input name="local" type="hidden" id="local" value="submissao">
</a></td>
            </tr>
          </table></td>
        </form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>