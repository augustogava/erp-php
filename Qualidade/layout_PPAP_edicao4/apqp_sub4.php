<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	header("location:apqp_sub1.php");
	exit;
}
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="form1.acao.value='s4';form1.submit(); return false;";
		}else{
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='s4'; form1.submit(); return false; }else{ return false; } }else{ return false; }";
		}
$sqlc=mysql_query("SELECT clientes.tag FROM apqp_pc,clientes WHERE apqp_pc.cliente=clientes.id");
$resc=mysql_fetch_array($sqlc);
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_certf_submi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Certificado de Submiss&atilde;o'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Certificado de Submiss&atilde;o deve ser preenchido conforme o Manual do PPAP da AIAG - Terceira Edi&ccedil;&atilde;o. Utilize as abas da parte superior da tela para navegar entre os diversos t&oacute;picos do certificado de submiss&atilde;o.')"></a><span class="impTextoBold"></span></div></td>
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
        <a href="apqp_sub1.php">
		<td width="94" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">inf. da pe&ccedil;a </td>
		</a>		
		<a href="apqp_sub2.php">
		<td width="115" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">inf. da submiss&atilde;o </td>
		</a>
		<a href="apqp_sub3.php">
        <td width="127" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">n&iacute;vel de submiss&atilde;o </td>
		</a>
        <td width="117" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">aprova&ccedil;&atilde;o forn. </td>
		<a href="apqp_sub5.php">
		<td width="129" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">disposi&ccedil;&atilde;o do cliente </td>
		</a>        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_sub_sql.php">
          <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="3">
            <tr class="textobold">
			<?php if($resc["tag"]!="S"){?>
              <td colspan="4"><table width="571" border="0" cellpadding="3" cellspacing="1">
                <tr>
                  <td align="center" class="textoboldbranco">resultados da  submiss&atilde;o </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold"><table width="560" border="0" align="center" cellpadding="3" cellspacing="0">
                    <tr class="textobold">
                      <td>Os resultados de </td>
                      <td colspan="2"><input name="res1" type="checkbox" id="res1" value="1" <?php if($res["res1"]=="1") print "checked"; ?>>
  Medi&ccedil;&otilde;es Dimensionais </td>
                      <td width="218"><input name="res2" type="checkbox" id="res2" value="1" <?php if($res["res2"]=="1") print "checked"; ?>>
                        Ensaios de Materiais e Funcionais </td>
                      </tr>
                    <tr class="textobold">
                      <td width="112">&nbsp;</td>
                      <td colspan="2"><input name="res3" type="checkbox" id="res3" value="1" <?php if($res["res3"]=="1") print "checked"; ?>>
  Crit&eacute;rios de Apar&ecirc;ncia </td>
                      <td><input name="res4" type="checkbox" id="res4" value="1" <?php if($res["res4"]=="1") print "checked"; ?>>
Dados Estat&iacute;sticos </td>
                      </tr>
                    <tr class="textobold">
                      <td colspan="3">Atendem todos os requisitos de desenhos e especifica&ccedil;&otilde;es </td>
                      <td><input name="atende" type="radio" value="S" <?php if($res["atende"]=="S") print "checked"; ?>>
Sim
  <input name="atende" type="radio" value="N" <?php if($res["atende"]=="N") print "checked"; ?>>
N&atilde;o&nbsp;(explique abaixo) </td>
                      </tr>
                    <tr class="textobold">
                      <td colspan="2">Molde / Cavidade / Processo de Produ&ccedil;&atilde;o </td>
                      <td colspan="2"><input name="atende_pq" type="text" class="formularioselect" id="atende_pq" value="<?php print $res["atende_pq"]; ?>" maxlength="255"></td>
                      </tr>
                    <tr class="textobold">
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                      <td width="123"><img src="imagens/dot.gif" width="50" height="5"></td>
                      <td width="107"><img src="imagens/dot.gif" width="50" height="5"></td>
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
                <?php } ?></td>
              </tr>
            <tr>
              <td colspan="4"><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr class="textobold">
              <td colspan="4"><?php if($resc["tag"]=="S"){?><table width="571" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td align="center" class="textoboldbranco">declara&ccedil;&atilde;o</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold"><table width="550" border="0" align="center" cellpadding="3" cellspacing="0">
                    <tr>
                      <td class="textobold"><p> Eu afirmo que as amostras apresentadas nesse certificado s&atilde;o representa&ccedil;&otilde;es de   nossas pe&ccedil;as, feito sob a especifica&ccedil;&atilde;o aplic&aacute;vel dos desenhos do nosso cliente   e foram fabricadas a partir de mat&eacute;rias primas especificadas em uma produ&ccedil;&atilde;o com   ferramentais e opera&ccedil;&otilde;es n&atilde;o diferentes do processo&nbsp;regular de produ&ccedil;&atilde;o. Eu   certifico tamb&eacute;m que evid&ecirc;ncias documentadas de tal conformidade est&atilde;o    dispon&iacute;veis para revis&atilde;o.<br>
                          No caso de haver qualquer desvio desta declara&ccedil;&atilde;o, descreva abaixo.</p></td>
                    </tr>
                  </table></td>
                </tr>
              </table><?php } else { ?>
              <table width="571" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td align="center" class="textoboldbranco">declara&ccedil;&atilde;o</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold"><table width="550" border="0" align="center" cellpadding="3" cellspacing="0">
                      <tr>
                        <td class="textobold">Taxa de produ&ccedil;&atilde;o
                          <input name="taxa" type="text" class="formulario" id="taxa" value="<?php print $res["taxa"]; ?>" size="5" maxlength="10">
                          / 
                          <input name="horas" type="text" class="formulario" id="horas" value="<?php print $res["horas"]; ?>" size="5" maxlength="10"> 
                          horas </td>
                      </tr>
                      <tr>
                        <td class="textobold">Eu afirmo  que as amostras apresentadas nesse certificado s&atilde;o representa&ccedil;&otilde;es de nossas pe&ccedil;as, que foram fabricadas segundo os requisitos do Manual do Processo de Aprova&ccedil;&atilde;o de Pe&ccedil;as de Produ&ccedil;&atilde;o, 4&ordf; Edi&ccedil;&atilde;o. Eu   certifico tamb&eacute;m que evid&ecirc;ncias documentadas de tal conformidade est&atilde;o    dispon&iacute;veis para revis&atilde;o. <br>
                          No caso de haver qualquer desvio desta declara&ccedil;&atilde;o, descreva abaixo.</td>
                      </tr>
                  </table></td>
                </tr>
              </table>
              <?php } ?></td>
              </tr>
            <tr>
              <td colspan="4"><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr class="textobold">
              <td width="158">Explica&ccedil;&otilde;es / Coment&aacute;rios:</td>
              <td width="407" colspan="3"><input name="coments" type="text" class="formularioselect" id="atende_pq3" value="<?php print $res["coments"]; ?>" maxlength="255"></td>
              </tr>
            <tr>
              <td colspan="4"><?php if($resc["tag"]!="S"){?>                <img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr class="textobold">
              <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="70%" class="textobold">O ferramental do cliente est&aacute; devidamente etiquetado e numerado? </td>
                  <td width="30%"><label class="textobold">
                    <input name="ferram" type="radio" value="1"<?php if($res["ferram"]=="1") print "checked"; ?>>
                    Sim
                    <input name="ferram" type="radio" value="0"<?php if($res["ferram"]=="0") print "checked"; ?>>
                    Não</label></td>
                </tr>
              </table>
                <?php } ?></td>
              </tr>
            <tr>
              <td colspan="4"><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr>
              <td colspan="4"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="textobold">
                <tr>
                  <td width="28%">Aprovado por:</td>
                  <td width="52%"><input name="quem" type="text" class="formularioselect" id="quem2" value="<?php echo  $res["quem"]; ?>"></td>
				   <?php 
				  if(empty($res["quem"])){
				  	$javas="if(confirm('Deseja Aprovar Certificado de Submissão?')){return abre('apqp_sub_ass.php','busca','width=320,height=100,scrollbars=1');}else{ return false; }";
					$javalimp="window.alert('O Certificado de Submissão não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
				  $javas="window.alert('O Certificado de Submissão já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				  
				  $javalimp="if(confirm('Deseja remover a aprovação?')){ if(confirm('Caso remova a aprovação do Certificado de Submissão, serão removidas todas as aprovações de todos os relaltórios.')){ if(confirm('Tem certeza que deseja remover?')) { form1.acao.value='s4';form1.submit();} } } return false; ";
				  ?>
                  <td width="20%"><input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?php echo  $javas; ?>">
&nbsp;
<input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="<?php echo  $javalimp; ?>"></td>
                </tr>
              </table><?php if($aprov=="N") print "<script>bloke();</script>"; ?></td>
            </tr>
            <tr>
              <td colspan="4">
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
                </table>		               </td>
              </tr>
            <tr>
              <td colspan="4" align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('submissao','<?php echo $res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>">

&nbsp;&nbsp;
<?php
$apqp->agenda_p("Certificado de Submissão","apqp_sub4.php");
?>
                  <input name="acao" type="hidden" id="acao" value="1">
                  <input name="assinatura" type="hidden" id="assinatura">
                  <input name="ir" type="hidden" id="ir">
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