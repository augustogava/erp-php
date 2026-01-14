<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$user=$_SESSION["login_funcionario"];
//Verificação
$_SESSION["modulo"]="planoc";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='planoc'");
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
//Verificar c esta aprovado
$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Para iniciar o Plano de Controle é necessário que FMEA de Processo esteja aprovado";
	header("Location:apqp_menu.php");
	exit;
}
//Verificar c esta aprovado
if(empty($fase)) $fase=2;
$sql=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' AND fase='$fase'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	if($res["sit"]=="N"){
		$apro="return confirm('Deseja aprovar este Plano de Controle?');";
		$btnsalva="form1.acao.value='altc';form1.submit();";
	}else{
		$apro="alert('Este Plano de Controle já está aprovado'); return false;";
		$btnsalva="if(confirm('Este Plano de Controle já está aprovado\\nDeseja alterá-lo?')){form1.acao.value='altc';form1.submit();}";
	}
}
$sql_pc=mysql_query("SELECT status FROM apqp_pc WHERE numero='$npc'");
$res_pc=mysql_fetch_array($sql_pc);

	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
			if(!mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='altc'; form1.submit(); return false; } return false;";
				$javalimp3="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; } } return false;";
				$javalimp4="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; } } return false;";
				$javalimp="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; } } return false;";
			}else{
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ form1.acao.value='altc'; form1.submit();  } return false;";
				$javalimp3="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
				$javalimp4="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
				$javalimp="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
			}
		}else{
				$btnsalva="form1.acao.value='altc'; form1.submit(); return false;";
				$javalimp3="if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; }";
				$javalimp4="if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; }";
				$javalimp="if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='altc';form1.submit(); }else{ return false; }";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc'; form1.submit(); return false; }else{ return false; } }else{ return false; }";
		$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp3="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp4="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc';form1.submit(); }else{ return false; } }else{ return false; }";
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
	if(cad.numero.value==''){
		alert('Informe a N. do Plano');
		cad.numero.focus();
		return false;
	}
	if(cad.contato.value==''){
		alert('Informe o Contato/Fone');
		cad.contato.focus();
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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_plano_controle.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Controle aba Cabe&ccedil;alho'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Prot&oacute;tipo -  </strong>Produto em fase de projeto<br><strong>Pr&eacute;-lan&ccedil;amentos - </strong>Produto ainda n&atilde;o liberado pela engenharia do produto para produ&ccedil;&atilde;o<br><strong>Produ&ccedil;&atilde;o - </strong>Produto liberado pela engenharia do produto para produ&ccedil;&atilde;o. <br><strong>Data de inicio - </strong>Inicio do Plano de Controle original foi liberado.<br><strong>Data de revis&atilde;o - </strong>Data da revis&atilde;o do Plano de Controle.<br><strong>N&deg; do Plano - </strong>Numero de identifica&ccedil;&atilde;o<br><strong>Contato fone - </strong>Contato ou telefone<br><strong>Equipe - </strong>Nome ou departamento dos participantes. <br><strong>Aprova&ccedil;&atilde;o da Eng. Cliente - </strong>Aprova&ccedil;&atilde;o da engenharia do Cliente<br><strong>Aprova&ccedil;&atilde;o da Qual. Cliente - </strong>Aprova&ccedil;&atilde;o da qualidade do cliente<br><strong>Outra aprova&ccedil;&atilde;o - </strong>Descrever outras aprova&ccedil;&otilde;es<br><strong>Aprova&ccedil;&atilde;o Interna - </strong>Aprova&ccedil;&atilde;o da Qualidade Interna.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Plano de Controle &nbsp;<?php print $npc; ?></div></td>
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
		<a href="apqp_planot.php?fase=<?php echo  $fase; ?>">
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">tabela</td>
		</a>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_plano_sql.php" onSubmit="return verifica(this)"><td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="99" class="textobold">Fase:</td>
              <td colspan="5" class="textobold"><input name="fase" type="radio" onClick="window.location='apqp_planoc.php?fase=1';" value="1" <?php if($fase==1) print "checked"; ?>>
                Prot&oacute;tipo
                <input name="fase" type="radio" value="2" onClick="window.location='apqp_planoc.php?fase=2';" <?php if($fase==2) print "checked"; ?>>
                Pr&eacute;-lan&ccedil;amento
                <input name="fase" type="radio" value="3" onClick="window.location='apqp_planoc.php?fase=3';" <?php if($fase==3) print "checked"; ?>>
                Produ&ccedil;&atilde;o</td>
              </tr>
            <tr>
              <td class="textobold">Data de In&iacute;cio:</td>
              <td width="169" ><input name="ini" type="text" class="formulario" id="ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["ini"]); ?>" size="22" maxlength="10">
                &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_planoc_1&var_field=ini','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="112"  class="textobold">&nbsp;Data de Revis&atilde;o:</td>
              <td width="167" colspan="3"><input name="rev" type="text" class="formulario" id="rev" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["rev"]); ?>" size="22" maxlength="10">
                &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_planoc_2&var_field=rev','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
            </tr>
            <tr>
              <td class="textobold">N&ordm; do Plano:</td>
              <td><input name="numero" type="text" class="formularioselect" id="ini4" value="<?php echo  $res["numero"]; ?>" size="7" maxlength="10"></td>
              <td class="textobold">&nbsp;Contato / Fone:</td>
              <td colspan="3"><input name="contato" type="text" class="formularioselect" id="contato" value="<?php echo  $res["contato"]; ?>" size="7" maxlength="50"></td>
              </tr>
            <tr>
              <td class="textobold">Equipe:</td>
              <td colspan="5"><input name="equipe" type="text" class="formularioselect" id="equipe" value="<?php echo  $res["equipe"]; ?>" size="7" maxlength="100"></td>
            </tr>
            <tr>
              <td class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
              <td colspan="5"><span class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></span></td>
            </tr>
            <tr>
              <td colspan="6" align="center"></td>
            </tr>
            <tr>
              <td colspan="6" align="center">		</td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr bgcolor="#003366" class="textoboldbranco">
              <td colspan="2" class="textobold">&nbsp;</td>
              <td width="34%" class="rodape">Nome</td>
              <td width="12%">Data</td>
              <td width="24%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="textobold">Aprova&ccedil;&atilde;o da Eng. do Cliente:</td>
              <td class="textobold">
   				<input name="apro1" type="text" class="formularioselect" id="apro1" value="<?php if($fase==1){ print $res["apro1"]; } if($fase==2){ print $res["apro1"]; } if($fase==3){ print $res["apro1"]; }?>" size="7" maxlength="50" readonly=""></td>
              <td><input name="apro1_data" type="text" class="formularioselect" id="apro1_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php if($fase==1) { print banco2data($res["apro1_data"]); } if($fase==2) { print banco2data($res["apro1_data"]); } if($fase==3) { print banco2data($res["apro1_data"]); }?>" size="7" maxlength="10" readonly=""></td>
              <td>&nbsp;
                <?php if(empty($res["apro2"])){
				 	  $java1="if (confirm('Deseja Aprovar Plano de Controle? Caso aprovar n&atilde;o ser&aacute; poss&iacute;vel remover a aprova&ccedil;&atilde;o.')){ form1.acao.value='altc';form1.submit(); } return false;";
				  }else{
			  		  $java1="window.alert('N&atilde;o &eacute; poss&iacute;vel aprovar novamente.');return false;";
			  	  }
			?>
                <input name="ap1" type="submit" class="microtxt" id="ap1" value="aprovar" onClick="<?php echo  $java1; ?>" <?php if( ($user!="N")||(empty($res["quem"])) ){?> disabled <?php } ?>>                &nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="textobold">Aprova&ccedil;&atilde;o da Quali. do Cliente:</td>
              <td class="textobold"><input name="apro2" type="text" class="formularioselect" id="apro2" value="<?php if($fase==1){ print $res["apro2"]; } if($fase==2){ print $res["apro2"]; } if($fase==3){ print $res["apro2"]; }?>" size="7" maxlength="50" readonly=""></td>
              <td><input name="apro2_data" type="text" class="formularioselect" id="apro2_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php if($fase==1) { print banco2data($res["apro2_data"]); } if($fase==2) { print banco2data($res["apro2_data"]); } if($fase==3) { print banco2data($res["apro2_data"]); } ?>" size="7" maxlength="10" readonly=""></td>
              <td>&nbsp;
                <?php if(empty($res["apro2"])){
				 	  $java2="if(confirm('Deseja Aprovar Plano de Controle? Caso aprovar n&atilde;o ser&aacute; poss&iacute;vel remover a aprova&ccedil;&atilde;o.')){ form1.acao.value='altc';form1.submit(); } return false;";
				  }else{
			  		  $java2="window.alert('N&atilde;o &eacute; poss&iacute;vel aprovar novamente.');return false;";
			  	  }
			?>
                <input name="ap2" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?php echo  $java2; ?>" <?php if( ($user!="N")||(empty($res["quem"])) ){?> disabled <?php } ?>>
  &nbsp;</td></tr>
            <tr>
              <td colspan="2" class="textobold">Outra Aprova&ccedil;&atilde;o:</td>
              <td class="textobold"><input name="apro3" type="text" class="formularioselect" id="apro3" value="<?php if($fase==1){ print $res["apro3"]; } if($fase==3){ print $res["apro3"]; } if($fase==3){ print $res["apro3"]; } ?>" size="7" maxlength="50" readonly=""></td>
              <td><input name="apro3_data" type="text" class="formularioselect" id="apro3_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php if($fase==1) { print banco2data($res["apro3_data"]); } if($fase==2) { print banco2data($res["apro3_data"]); } if($fase==3) { print banco2data($res["apro3_data"]); } ?>" size="7" maxlength="10" readonly=""></td>
              <td>&nbsp;
                <?php if(empty($res["apro3"])){
				$java3="if(confirm('Deseja Aprovar Plano de Controle?')){form1.acao.value='altc';form1.submit();}else{ return false; }";
				$javalimp3="window.alert('O Plano de Controle não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";

			  }else{
			  	$java3="window.alert('Clique em Limpar primeiro');return false;";
			  }
			?>
                <input name="ap3" type="submit" class="microtxt" id="ap3" value="aprovar" onClick="<?php echo  $java3; ?>" <?php if( (empty($res["quem"])) || $user=="N" || $res_pc["status"]=="2" ){?> disabled <?php } ?>>
&nbsp;
<input name="lap3" type="submit" class="microtxt" id="lap3" value="limpar" onClick="<?php echo  $javalimp3;?>" <?php if( (empty($res["quem"])) || $user=="N" || $res_pc["status"]=="2" ){?> disabled <?php } ?>></td>
            </tr>
            <tr>
              <td colspan="2" class="textobold">Outra Aprova&ccedil;&atilde;o:</td>
              <td class="textobold"><input name="apro4" type="text" class="formularioselect" id="apro4" value="<?php  if($fase==1){ print $res["apro4"]; } if($fase==3){ print $res["apro4"]; } if($fase==2){ print $res["apro4"]; } ?>" size="7" maxlength="50" readonly=""></td>
              <td><input name="apro4_data" type="text" class="formularioselect" id="apro4_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php if($fase==1) { print banco2data($res["apro4_data"]); } if($fase==2) { print banco2data($res["apro4_data"]); } if($fase==3) { print banco2data($res["apro4_data"]); } ?>" size="7" maxlength="10" readonly=""></td>
              <td>&nbsp;
                <?php if(empty($res["apro4"])){
				 $java4="if(confirm('Deseja Aprovar Plano de Controle?')){form1.acao.value='altc';form1.submit();}else{ return false; }";
 				 $javalimp4="window.alert('O Plano de Controle não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";

			  }else{
			  	$java4="window.alert('Clique em Limpar primeiro');return false;";
			  }
			?>
                <input name="ap4" type="submit" class="microtxt" id="ap4" value="aprovar" onClick="<?php echo  $java4; ?>" <?php if( (empty($res["quem"])) || $user=="N" || $res_pc["status"]=="2" ){?> disabled <?php } ?>>
&nbsp;
<input name="lap4" type="submit" class="microtxt" id="lap4" value="limpar" onClick="<?php echo  $javalimp4;?>" <?php if( (empty($res["quem"])) || $user=="N" || $res_pc["status"]=="2" ){?> disabled <?php } ?>></td>
            </tr>
            <tr>
              <td colspan="2" class="textobold">Aprova&ccedil;&atilde;o Interna:</td>
              <td class="textobold"><?php  $sel=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' AND ativ='Plano de Controle'"); $sele=mysql_fetch_array($sel); ?>

                <input name="quem1" type="text" class="formularioselect" id="quem1" value="<?php if($fase==1){ print $res["quem"]; } if($fase==2){ print $res["quem"]; } if($fase==3){ print $res["quem"]; } ?>" size="7" maxlength="50" readonly=""> </td> 				
			
              <td><input name="dtquem" type="text" class="formularioselect" id="dtquem" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php if($fase==1) { print banco2data($res["dtquem"]); } if($fase==2) { print banco2data($res["dtquem"]); } if($fase==3) { print banco2data($res["dtquem"]); }?>" size="7" maxlength="10" readonly=""></td>
              <td>&nbsp;
			  <?php if(empty($res["quem"])){ 
				 $javas="if(confirm('Deseja Aprovar Plano de Controle?')){form1.acao.value='altc';form1.submit();}else{ return false; }";
				 $javalimp="window.alert('O Plano de Controle não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				 }else{
				 $javas="window.alert('O Plano de Controle já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
			   }
				?>
                <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?php echo  $javas; ?>" <?php if( $user=="N"||(!empty($res["apro1"]))||(!empty($res["apro2"]))||$res_pc["status"]=="2" ){ ?>disabled<?php } ?>>
&nbsp;
<input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="<?php echo  $javalimp;?>" <?php if( $user=="N"||(!empty($res["apro1"]))||(!empty($res["apro2"]))||$res_pc["status"]=="2" ){ ?>disabled<?php } ?>></td>
            </tr>
          </table>
          <table width="100%"  border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td align="left" class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
              <td class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
              <td align="center"><span class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></span></td>
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
				
          <p align="center">
            <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('controle','<?php echo $res["id"];?>')">
&nbsp;
<input name="button122222" type="submit" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>">
&nbsp;&nbsp;
<?php
$apqp->agenda_p("Plano de Controle","apqp_planoc.php");
?>
<input name="acao" type="hidden" id="acao" value="1">
<input name="local" type="hidden" id="local" value="controle">
<input name="fase" type="hidden" id="fase" value="<?php echo  $fase; ?>">
          </p></td></form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>