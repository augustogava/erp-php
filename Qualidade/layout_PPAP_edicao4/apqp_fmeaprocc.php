<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$local=Input::request("local");
$email=Input::request("email");
$ap=Input::request("ap");
$lap=Input::request("lap");
$id=Input::request("id");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="fproc";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='fproc'");
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
$sql=mysql_query("SELECT * FROM apqp_fmeaproc WHERE peca='$pc'");
$sqlap=mysql_query("SELECT fmea1.* FROM apqp_fmeaproc AS fmea, apqp_fmeaproci AS fmea1 WHERE fmea.peca='$pc' AND fmea.id=fmea1.fmea AND ((fmea1.sev>7 OR fmea1.npr>100) AND (fmea1.at='' OR fmea1.sev2='0' OR fmea1.ocor2='0' OR fmea1.det2='0' OR fmea1.npr2='0'))");
$apok=mysql_num_rows($sqlap);
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	if($res["sit"]=="N"){
		if(!$apok){
			$apro="return confirm('Deseja aprovar esta FMEA?');";
		}else{
			$apro="alert('As ações tomadas devem ser informadas antes da aprovação\\nClique na aba TABELA e informe todos os campos necessários'); return false;";
		}
		$btnsalva="true";
	}else{
		$apro="alert('Esta FMEA já está aprovada'); return false;";
		$btnsalva="confirm('Esta FMEA já está aprovada\\nDeseja alterá-la?')";
	}
}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
			if(mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ form1.acao.value='altc'; form1.submit();  } return false;";
				$javalimp="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='altc'; form1.submit(); return false; } return false;";
				$javalimp="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; } } return false;";
			}
		}else{
			$btnsalva="form1.acao.value='altc'; form1.submit(); return false;";
			$javalimp="if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; }";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc'; form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";

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
function abrir(url,id,ac){
	window.location='pdf/'+url+'.php?id='+id+'&ac='+ac+'';
	return true;
}
function salvar(url,id){
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?php echo $pc?> + '');
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
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_fmea_process.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='FMEA de Processo'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Data de inicio - </strong>Data prevista para inicio<br><strong>Data de Revisão - </strong>Data que foi feita à revisão<br><strong>Data chave - </strong>Data prevista para o termino<br><strong>N° do FMEA - </strong>Identificação do FMEA<br><strong>Resp.Projeto - </strong>Responsável pelo projeto<br><strong>Equipe - </strong>Nome da equipe ou dos integrantes da equipe<br><strong>Obs - </strong>Algum item que deve ser ressaltado<br><strong>Preparado por - </strong>Quem preparou o projeto')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - FMEA de Processo&nbsp;<?php print $npc; ?></div></td>
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
		<a href="#" onClick="if(confirm('O Documento já foi salvo? Se sim clique em OK, caso contrário em Cancelar')){ window.location.href ='apqp_fmeaproct.php'; } return false;">
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">tabela</td>
		</a>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_fmeaproc_sql.php" onSubmit="return verifica(this)"><td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td width="15%" class="textobold">Data de In&iacute;cio</td>
              <td width="19%"><input name="ini" type="text" class="formulario" id="ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["ini"]); ?>" size="10" maxlength="10">                <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_fmeaprocc_1&var_field=ini','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="17%" class="textobold">&nbsp;Data de Revis&atilde;o </td>
              <td width="19%"><input name="rev" type="text" class="formulario" id="rev" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["rev"]); ?>" size="10" maxlength="10">                <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_fmeaprocc_2&var_field=rev','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="12%" class="textobold">&nbsp;Data Chave </td>
              <td width="18%"><input name="chv" type="text" class="formulario" id="chv" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["chv"]); ?>" size="10" maxlength="10">
              <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_fmeaprocc_3&var_field=chv','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
            </tr>
            <tr>
              <td class="textobold">N&ordm; da FMEA</td>
              <td><input name="numero" type="text" class="formularioselect" id="ini4" value="<?php echo  $res["numero"]; ?>" size="7" maxlength="10"></td>
              <td class="textobold">&nbsp;Resp. Processo</td>
              <td colspan="3"><input name="resp" type="text" class="formularioselect" id="resp" value="<?php echo  $res["resp"]; ?>" size="7" maxlength="50"></td>
              </tr>
            <tr>
              <td class="textobold">Equipe</td>
              <td colspan="5"><input name="equipe" type="text" class="formularioselect" id="equipe" value="<?php echo  $res["equipe"]; ?>" size="7" maxlength="100"></td>
            </tr>
            <tr>
              <td class="textobold">Obs</td>
              <td colspan="5"><input name="obs" type="text" class="formularioselect" id="obs" value="<?php echo  $res["obs"]; ?>" size="7" maxlength="100"></td>
            </tr>
            <tr>
              <td class="textobold">Preparado por </td>
              <td colspan="5"><input name="prep" type="text" class="formularioselect" id="prep" value="<?php echo  $res["prep"]; ?>" size="7" maxlength="50"></td>
            </tr>
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
                <tr>
                  <td width="388" align="center" class="textoboldbranco">Op&ccedil;&otilde;es</td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td class="textobold"><input name="op" type="radio" value="1" <?php if(empty($res["op"]) or $res["op"]=="1") print "checked"; ?>>
      Controles Preventivos e Detectivos em duas Colunas (FMEA 3&ordf; Edi&ccedil;&atilde;o) </td>
                </tr>
                
              </table></td>
            </tr>
            <tr>
              <td colspan="6" align="center"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="16%" align="right" class="textobold"><div align="left">&nbsp;Aprovado por:&nbsp; </div></td>
                  <td width="61%" class="textobold"><?php  $sel=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' AND ativ='FMEA de Processo'"); $sele=mysql_fetch_array($sel); ?>
                      <input name="quem1" type="text" class="formularioselect" id="quem2" value="<?php echo  $sele["resp"]; ?>"></td>
                  <td width="23%" align="center">
				  <?php 
				  if(empty($sele["resp"])){
				  	$javas="if(confirm('Deseja Aprovar FMEA de Processo?')){form1.acao.value='altc';form1.submit();}else{ return false; }";
					$javalimp="window.alert('O FMEA de Processo não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
				  	$javas="window.alert('O FMEA de Processo já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				  ?>
				  <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?php echo  $javas; ?>">
&nbsp;
      <input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="<?php echo  $javalimp;?>"></td>
                </tr>
              </table>
			  <?php if($aprov=="N") print "<script>bloke();</script>"; ?>
              
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
                </table>
			</td>
            </tr>
            <tr>
              <td colspan="6" align="center"><input name="button1" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
              	&nbsp;
				<input name="acao3" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('processo','<?php echo $res["id"];?>')">
				&nbsp;
				<input name="Submit3" type="button" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>">
				&nbsp;&nbsp;
<?php
$apqp->agenda_p("FMEA de Processo","apqp_fmeaprocc.php");
?>
				 <input name="acao" type="hidden" id="acao" value="1">
				 <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
				 <input name="local" type="hidden" id="local" value="processo">
				 </a></td>
              </tr>
          </table>
        </td></form>
      </tr>
    </table></td>
  </tr>
</table>
<img src="imagens/dot.gif" width="25" height="8">
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>