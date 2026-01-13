<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="fprojeto";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='fprojeto'");
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
$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
$sqlap=mysql_query("SELECT fmea1.* FROM apqp_fmeaproj AS fmea, apqp_fmeaproji AS fmea1 WHERE fmea.peca='$pc' AND fmea.id=fmea1.fmea AND ((fmea1.sev>7 OR fmea1.npr>100) AND (fmea1.at='' OR fmea1.sev2='0' OR fmea1.ocor2='0' OR fmea1.det2='0' OR fmea1.npr2='0'))");
$apok=mysql_num_rows($sqlap);
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	if($res["sit"]=="N"){
		if(!$apok){
			$apro="if(confirm('Deseja aprovar esta FMEA?')){form1.acao.value='altc';form1.submit()};";
		}else{
			$apro="alert('As ações tomadas devem ser informadas antes da aprovação\\nClique na aba TABELA e informe todos os campos necessários'); return false;";
		}
	}else{
		$apro="alert('Esta FMEA já está aprovada'); return false;";
	}
}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
	
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)'");
		if(mysql_num_rows($sqlb)){
			
			$sqlfmea=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
			if(mysql_num_rows($sqlfmea)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ form1.acao.value='altc';return verifica(form1) } return false;";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='altc';return verifica(form1) }else{ return false; }";
			}
		}else{
			$btnsalva="form1.acao.value='altc';return verifica(form1)";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ lista.verifica(); }else{ return false; } }else{ return false; }";
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
function verifica(cad){
	if(cad.ini.value==''){
		alert('Informe a Data de início');
		cad.ini.focus();
		return false;
	}
	if(cad.rev.value==''){
		alert('Informe a Data de Revisão');
		cad.rev.focus();
		return false;
	}
	if(cad.chv.value==''){
		alert('Informe a Data Chave');
		cad.chv.focus();
		return false;
	}
	if(cad.resp.value==''){
		alert('Informe o Responsável');
		cad.resp.focus();
		return false;
	}
	if(cad.numero.value==''){
		alert('Informe o N. da Fmea');
		cad.numero.focus();
		return false;
	}
	if(cad.equipe.value==''){
		alert('Informe a Equipe');
		cad.equipe.focus();
		return false;
	}
	form1.submit()
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
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_fmea_projeto.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='FMEA de projeto'; this.T_DELAY=10; this.T_WIDTH=300;  return escape('<strong>Data de inicio - </strong>data prevista para inicio<br><strong>Data de Revisão - </strong>data que foi feita à revisão<br><strong>Data chave - </strong>data prevista para o termino<br><strong>N° do FMEA - </strong>identificação do FMEA<br><strong>Resp.Projeto - </strong>responsável pelo projeto<br><strong>Equipe - </strong>nome da equipe ou dos integrantes da equipe<br><strong>Obs - </strong>algum item que deve ser ressaltado<br><strong>Preparado por - </strong>quem preparou o projeto')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - FMEA de Projeto <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">cabe&ccedil;alho</td>
		<a href="#" onClick="if(confirm('O Documento já foi salvo? Se sim clique em OK, caso contrário em Cancelar')){ window.location.href ='apqp_fmeaprojt.php'; } return false;">
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">tabela</td></a>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_fmeaproj_sql.php" onSubmit="return verifica(this)"><td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td width="15%" class="textobold">Data de In&iacute;cio:</td>
              <td width="18%" ><input name="ini" type="text" class="formulario" id="ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["ini"]); ?>" size="10" maxlength="10">                &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_fmeaprojc_1&var_field=ini','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="19%" class="textobold">&nbsp;Data de Revis&atilde;o:</td>
              <td width="18%"><input name="rev" type="text" class="formulario" id="rev" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["rev"]); ?>" size="10" maxlength="10">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_fmeaprojc_2&var_field=rev','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="13%"  class="textobold">&nbsp;Data Chave:</td>
              <td width="17%" ><input name="chv" type="text" class="formulario" id="chv" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["chv"]); ?>" size="10" maxlength="10">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_fmeaprojc_3&var_field=chv','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
            </tr>
            <tr>
              <td class="textobold">N&ordm; da FMEA:</td>
              <td><input name="numero" type="text" class="formularioselect" id="ini4" value="<?= $res["numero"]; ?>" size="7" maxlength="10"></td>
              <td class="textobold">&nbsp;Resp. Projeto:</td>
              <td colspan="3"><input name="resp" type="text" class="formularioselect" id="resp" value="<?= $res["resp"]; ?>" size="7" maxlength="50"></td>
              </tr>
            <tr>
              <td class="textobold">Equipe:</td>
              <td colspan="5"><input name="equipe" type="text" class="formularioselect" id="equipe" value="<?= $res["equipe"]; ?>" size="7" maxlength="100"></td>
            </tr>
            <tr>
              <td class="textobold">Obs:</td>
              <td colspan="5"><input name="obs" type="text" class="formularioselect" id="obs" value="<?= $res["obs"]; ?>" size="7" maxlength="100"></td>
            </tr>
            <tr>
              <td class="textobold">Preparado por:</td>
              <td colspan="5"><input name="prep" type="text" class="formularioselect" id="prep" value="<?= $res["prep"]; ?>" size="7" maxlength="50"></td>
            </tr>
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
                <tr>
                  <td width="388" align="center" class="textoboldbranco"><div align="center">Op&ccedil;&otilde;es</div></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td class="textobold"><input name="op" type="radio" value="1" <? if(empty($res["op"]) or $res["op"]=="1") print "checked"; ?>>
      Controles Preventivos e Detectivos em duas Colunas (FMEA 3&ordf; Edi&ccedil;&atilde;o) </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="6" align="center"><table width="100%"  border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="16%" align="left" class="textobold">Aprovado por:&nbsp; </td>
                  <td width="64%" class="textobold"><?  $sel=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)'"); $sele=mysql_fetch_array($sel); ?>
                      <input name="quem1" type="text" class="formularioselect" id="quem1" value="<?= $sele["resp"]; ?>"></td>
                  <td width="20%" align="center"><p>
				   <? 
				  if(empty($sele["resp"])){
					$javas="if(confirm('Deseja Aprovar FMEA de projeto?')){form1.acao.value='altc';form1.submit();}else{ return false; }";
				  }else{
					$javas="window.alert('O FMEA de Projeto já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				  ?>
  <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?= $javas; ?>">
&nbsp;
      <input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="if(confirm('Deseja Desaprovar FMEA de projeto?')){form1.acao.value='altc';form1.submit();}else{ return false; }">
      </p>                    </td>
                </tr>
              </table> <? if($aprov=="N") print "<script>bloke();</script>"; ?>
			  <a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');">
			  <input name="grupo" type="hidden" id="grupo">
			  <input name="grupo_nome" type="hidden" id="grupo_nome">
			  </a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"><span class="textobold">
			  <input name="acao" type="hidden" value="1">
              <input name="local" type="hidden" id="local" value="projeto">
			  </span></a></td>
            </tr>
            <tr>
              <td colspan="6" align="center">
			  
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
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('projeto','<?=$res["id"];?>')">
&nbsp;
<input name="button122222" type="submit" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>">
&nbsp;&nbsp;
<?
$apqp->agenda_p("FMEA de Projeto (Se aplicável)","apqp_fmeaprojc.php");
?></td>
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