<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="crono";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='crono'");
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

if($acao=="gera"){
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' AND ativ='Viabilidade'");
	if(!mysql_num_rows($sql)){
		$sql=mysql_query("UPDATE apqp_pc SET crono_ger='N' WHERE id='$pc'");
	}
	$acao="entrar";
}
$sql=mysql_query("SELECT crono_ger FROM apqp_pc WHERE id='$pc'");
if(mysql_num_rows($sql)==0){
	header("Location:apqp_pc.php");
	exit;
}else{
	$res=mysql_fetch_array($sql);
	$cronoger=$res["crono_ger"];
	if($cronoger=="N"){
		//geracronos
		$apps=Array("Desenho (Se aplicável)",
		"FMEA de Projeto (Se aplicável)",
		"Protótipo (Se aplicável)",
		"Viabilidade",
		"Diagrama de Fluxo",
		"FMEA de Processo",
		"Plano de Controle",
		"Análise Critica",
		"Ferramental/Instalações",
		"Instruções do Operador",
		"Verificação / validação",
		"Lote Piloto",
		"Estudos de R&R",
		"Estudos de Capabilidade",
		"Ensaio Dimensional",
		"Ensaio Material",
		"Ensaio Desempenho",
		"Interina",
		"Relatório de Aprovação de Aparência (Se aplicável)",
		"Certificado de Submissão",
		"Sumario de Aprovação do APQP (Validação final)");
		for($i=0;$i<count($apps);$i++){
			$app=$apps[$i];
			$sql=mysql_query("INSERT INTO apqp_cron (peca,ativ,cod,pos) VALUES ('$pc','$app','$i','$i')");
		}
		//geracronos
		$sql=mysql_query("UPDATE apqp_pc SET crono_ger='S' WHERE id='$pc'");
	}
}

$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");

if($acao=="entrar"){
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
	while($res=mysql_fetch_array($sql)){

		  $hj=date("Y-m-d");
		  $val=(strtotime($res["prazo"]) - strtotime($res["ini"])) / (60 * 60 * 24);
		  if(($res["fim"])=="0000-00-00"){

				if(!($res["prazo"]=="0000-00-00")){
					$p=round(strtotime($hj) - strtotime($res["prazo"])) / (60 * 60 * 24);
					if($p>="0"){
						$atrazo=$p;
					}
				}
	
		  } else{
			  $val2=(strtotime($res["fim"]) - strtotime($res["ini"])) / (60 * 60 * 24);
			  $val3=$val2-$val;
			  $atrazo=$val3; 
		  }
		mysql_query("UPDATE apqp_cron SET atra='$atrazo' WHERE id='$res[id]'");		
	}
}

if(mysql_num_rows($sql)==0){
	$alt=false;
}else{
	$alt=true;
}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sql=mysql_query("SELECT * FROM apqp_pc WHERE crono_apro='S' AND id='$pc'");
		if(!mysql_num_rows($sql)){
			$btnsalva="";
			$btnsalva2="window.location='apqp_crono.php?acao=inc';";
		}else{
			$sqlfmea=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
			if(mysql_num_rows($sqlfmea)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){  } ";
				$btnsalva2="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ window.location='apqp_crono.php?acao=inc'; } return false;";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ }else{ return false; }";
				$btnsalva2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ window.location='apqp_crono.php?acao=inc'; } return false;";
			}
		}
		$sqlfmea=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
		if(!mysql_num_rows($sqlfmea)){
			$javalimp="if(confirm('Deseja remover a aprovação?')){  } else{ return false; }";
		 } else {
			$javalimp="if(confirm('Deseja remover a aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')){  }else{ return false; } } else { return false; }";
		}
	}else{
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){  }else{ return false; } }else{ return false; }";
			$btnsalva2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ window.location='apqp_crono.php?acao=inc'; }else{ return false; } }else{ return false; }";
			$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){  }else{ return false; } }else{ return false; }";

	}

$sql_f1=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='1'");
$res_f1=mysql_fetch_array($sql_f1);
$sql_f2=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='2'");
$res_f2=mysql_fetch_array($sql_f2);
$sql_f3=mysql_query("SELECT quem FROM apqp_plano WHERE peca='$pc' AND fase='3'");
$res_f3=mysql_fetch_array($sql_f3);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function bloke(){
	document.all.form1.ap.disabled=true;	
	document.all.form1.lap.disabled=true;	
}
function valida(type){
	form1.acao.value=type;
	form1.submit();
	return true
}
function valida1(type,peca){
		window.open('apqp_imp_email.php?acao='+type+'&local='+form1.local.value+'&email='+form1.email.value+'&pc='+peca,'busca','width=430,height=140,scrollbars=1');
}
function vailogo(type){
	form1.acao.value=type;
	form1.submit();
	return true
}
function vailogo1(type,peca){
	window.open('apqp_imp_email.php?acao='+type+'&local='+form1.local.value+'&email='+form1.email.value+'&pc='+peca,'busca','width=430,height=140,scrollbars=1');
}
<? if($acao=="inc"){ ?>
function verificainc(cad){
	if(cad.ativ.value==''){
		alert('Informe a atividade');
		cad.ativ.focus();
		return false;
	}
	return true;
}
<?
}elseif($acao=="alt"){
if($alt){
?>
function verificalt(cad){
<?
	while($res=mysql_fetch_array($sql)){
		$wid=$res["id"];
?>
	if(cad.ativ<? print $wid; ?>.value==''){
		alert('Informe a atividade');
		cad.ativ<? print $wid; ?>.focus();
		return false;
	}
<? 
	} 
?>

	for(i=1;i<cad.acum.value;i++){
			if(document.all['responsavel'+i].value!=''){
			if(document.all['ini'+i].value==''){
				alert('Preencha a data início.');
				//cad.document.all['ini'+i].focus();
				return false;
			}
			if(document.all['prazo'+i].value==''){
				alert('Preencha a data prazo.');
				//cad.document.all['prazo'+i].focus();
				return false;
			}		
		}
	}
	return true;
}
<? 
}
} 
?>
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
@import url("style.css");
.style1 {font-size: 14px}
.style3 {font-size: 10px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_cronograma.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='CRONOGRAMA'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nesta modulo você se programará quanto ao desenvolvimento do APQP e delegará responsáveis por cada atividade definindo data de inicio.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1">APQP - Cronograma <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="711"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="701"><table width="701" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <? if($acao=="entrar"){ ?>
	  
      <tr>
        <td width="697" align="left" valign="top"><table width="824" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
            <tr bgcolor="#004993" class="textoboldbranco">
              <td>&nbsp;Atividade</td>
              <td width="121">&nbsp;Respons&aacute;vel</td>
              <td align="center">In&iacute;cio</td>
              <td align="center">Prazo</td>
              <td align="center">Fim</td>
              <td align="center">Dias/Atra</td>
              <td align="center"><div align="center">Aprovadores</div></td>
              <td align="center">%</td>
              <td align="center">Obs</td>
              <td align="center">&nbsp;</td>
            </tr>
            <?
$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
if(mysql_num_rows($sql)==0){
?>
            <tr align="center" bgcolor="#FFFFFF" class="texto">
              <td colspan="10" class="textobold"><span class="textopretobold">NENHUMA ATIVIDADE ENCONTRADA</span></td>
            </tr>
            <?
}else{
	while($res=mysql_fetch_array($sql)){
		$hj=date("Y-m-d"); 
		$val= round(strtotime($res["prazo"]) - strtotime($hj)) / (60 * 60 * 24); 
?>	
	<tr class="textopreto" onMouseover="changeto('#CCCCCC')" <? if(($val>="3")||($res["prazo"]=="0000-00-00")){ ?> bgcolor="#99FF66" onMouseout="changeback('#99FF66')" <? } else if(($val>="0")&&($val<="2")){ ?> bgcolor="#FFFF66" onMouseout="changeback('#FFFF66')" <? } else if($val<"0") { ?> bgcolor="#FF3300" onMouseout="changeback('#FF3300')" <? } else{ ?>  bgcolor="#FFFFFF" onMouseout="changeback('#FFFFFF')" <? } ?>><td width="160"><? print $res["ativ"]; if(($res["ativ"]=="Plano de Controle")&&(!empty($res_f1["quem"]))){?>&nbsp;&nbsp;&nbsp;&nbsp;<img src="imagens/icon_f1.gif" alt="Protótipo Aprovado" width="10" height="10" border="0"><? } if(($res["ativ"]=="Plano de Controle")&&(!empty($res_f2["quem"]))){?>&nbsp;&nbsp;&nbsp;<img src="imagens/icon_f2.gif" alt="Pré-Lançamento Aprovado" width="10" height="10" border="0"><? } if(($res["ativ"]=="Plano de Controle")&&(!empty($res_f3["quem"]))){?>&nbsp;&nbsp;&nbsp;<img src="imagens/icon_f3.gif" alt="Produção Aprovada" width="10" height="10" border="0"><? } ?></td>
                <td><? print $res["responsavel"]; ?></td>
                <td width="64" align="center"><? if($res["ini"]=="0000-00-00"){ print "&nbsp;"; }else{ print banco2data($res["ini"]); } ?></td>
              <td width="64" align="center"><? if($res["prazo"]=="0000-00-00"){ print "&nbsp;"; }else{ print banco2data($res["prazo"]); } ?></td>
              <td width="64" align="center"><? if($res["fim"]=="0000-00-00"){ print "&nbsp;"; }else{ print banco2data($res["fim"]); } ?></td>
              <td width="64" align="center"><? 
			  $hj=date("Y-m-d");
			   if($res["fim"]=="0000-00-00"){
					if($res["prazo"]=="0000-00-00"){
						print " ";
					}
					else{
						$p=round(strtotime($hj) - strtotime($res["prazo"])) / (60 * 60 * 24);
						if($p>="0"){
							print round($p);
						}
					}
			  } else{
				  $val1=(strtotime($res["prazo"]) - strtotime($res["ini"])) / (60 * 60 * 24);
				  $val2= (strtotime($res["fim"]) - strtotime($res["ini"])) / (60 * 60 * 24);
				  $atrazo=$val2-$val1; 
				  if($atrazo<"0"){ $atrazo="0"; } 
				  if($atrazo>="0"){ print round($atrazo); } 
			  }
			  ?></td>
              <td width="121" align="left"><? print $res["resp"]; ?></td>
              <td width="37" align="center"><? print $res["perc"]; ?></td>
              <td width="30" align="center"><a href="#"  onClick="return abre('apqp_cronobs.php?id=<? print $res["id"]; ?>','obs','width=320,height=200,scrollbars=1');"><img src="imagens/icon14_visualizar.gif" alt="Observa&ccedil;&otilde;es" width="14" height="14" border="0"></a></td>
              <td width="28" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta atividade?','apqp_crono_sql.php?acao=exc&id=<? print $res["id"]; ?>');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
            </tr>
            <?
	}
}
?>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">
		
		<form name="form1" method="post" action="apqp_crono_sql.php" onSubmit="return verifica(this)">
          <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr class="texto">
              <? if($_SESSION["e_mail"]=="S"){ ?>
              <td align="left" class="textobold">&nbsp;Enviar e-mail: 
                <input name="local" type="hidden" id="local" value="crono">
                <input name="acao" type="hidden" id="acao" value="1"></td>
              <td><input name="email" type="text" class="formularioselect" id="email3" value="Digite o e-mail aqui"></td>
              <? if(in_array("U",$emailt)){ ?>
              <td><div align="center"><a href="#" onClick="return abre('busca_email2.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" alt="Buscar Email de Funcion&aacute;rios" width="14" height="14" border="0"></a></div></td>
              <? } if(in_array("G",$emailt)){ ?>
              <td><div align="center"><a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');">
                <input name="grupo" type="hidden" id="grupo">
                  <input name="grupo_nome" type="hidden" id="grupo_nome">
                <img src="imagens/icon14_grupo.gif" alt="Buscar Grupo de Emails" width="26" height="13" border="0"></a></div></td>
              <? } if(in_array("C",$emailt)){ ?>
              <td><div align="center"><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Emails de Clientes" width="18" height="18" border="0"></a></div></td>
              <? } ?>
              <td><div align="center"><a href="#" onClick="vailogo1('email','<?= $pc; ?>');">
                <? if($_SESSION["login_funcionario"]=="S"){ ?>
                <img src="imagens/icon14_mail.gif" alt="Enviar Email" width="16" height="10" border="0"></a>
                  <? } ?>
              </div></td>
              <? } if($_SESSION["i_mp"]=="S"){ ?>
              <td><div align="center"><a href="#" onClick="vailogo('imp');"><img src="imagens/icon14_imp.gif" alt="Imprimir" width="15" height="15" border="0"></a></div></td>
              <? } ?>
            </tr>
          </table>
		  
          </form>
		
		
			<table width="100%" border="0" cellspacing="6" cellpadding="0">
              <tr>
                <td width="2%" bgcolor="99FF66" class="textobold">&nbsp;</td>
                <td width="20%" class="textobold style3" >O estudo est&aacute; dentro do prazo.</td>
                <td width="2%" bgcolor="FFFF66" class="textobold">&nbsp;</td>
                <td width="41%" class="textobold style3">Faltam 2 dias ou menos para vencer o prazo do t&eacute;rmino do estudo.</td>
                <td width="2%" bgcolor="FF3300" class="textobold">&nbsp;</td>
                <td width="21%" class="textobold style3">    O estudo est&aacute; com o prazo vencido.</td>
              </tr>
            </table>
			<p><input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
			  &nbsp;
			  <input name="acao3" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('crono','<?=$res["id"];?>')">
			  <? if($alt){ ?>
			  &nbsp;
			  <input name="button122" type="button" class="microtxt" value="Alterar" onClick="window.location='apqp_crono.php?acao=alt';">
			  <? } ?>
			  &nbsp;
			  <input name="button1222" type="button" class="microtxt" value="Incluir Atividade" onClick="<?= $btnsalva2; ?>">
			  &nbsp;
			  <?
			  $sqlcron=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
			$resc=mysql_fetch_array($sqlcron);
			  ?>
			  <input name="button12222" type="button" class="microtxt" value="Gerar Cronograma" onClick="window.location='apqp_crono.php?acao=gera';" <? if(!empty($resc["crono_quem"]) or $res["crono_ger"]=="S" ){ ?> disabled <? } ?>>
		  <img src="imagens/dot.gif" width="20" height="5"> &nbsp; </p></td>
      </tr>
      <? }elseif($acao=="alt"){ ?>
      <tr>
        <td align="left" valign="top"><form name="form1" id="form1" method="post" action="apqp_crono_sql.php" onSubmit="return verificalt(this);">
            <table width="826" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
              <tr bgcolor="#004993" class="textoboldbranco">
                <td width="158">&nbsp;Atividade</td>
                <td width="121">&nbsp;Respons&aacute;vel</td>
                <td width="64" align="center">In&iacute;cio</td>
                <td width="65" align="center">Prazo</td>
                <td width="64" align="center">Fim</td>
                <td width="121" align="center"><div align="left">Aprovadores</div></td>
                <td width="35" align="center">%</td>
                <td width="141" align="center">Obs</td>
              </tr>
              <?
$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
if(mysql_num_rows($sql)==0){
?>
              <tr align="center" bgcolor="#FFFFFF" class="texto">
                <td colspan="8" class="textobold"><span class="textopretobold">NENHUMA ATIVIDADE ENCONTRADA</span></td>
              </tr>
              <?
}else{
$i=0;
	while($res=mysql_fetch_array($sql)){
		$i++;
		$ativ=$res["ativ"];
?>
              <tr bgcolor="#FFFFFF" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td width="158"><input name="ativ[<? print $res["id"]; ?>]" type="text" class="formularioselectsemborda" id="ativ<? print $res["id"]; ?>" value="<? print $res["ativ"]; ?>" size="1" readonly></td>
                <td class="texto"><span class="textobold">
                  <select name="responsavel[<? print $res["id"]; ?>]" class="formulario" id="responsavel<? print $i; ?>">
                    <option value="">Selecione</option>
                    <?
$sqlr=mysql_query("SELECT * FROM funcionarios ORDER BY nome ASC");
while($resr=mysql_fetch_array($sqlr)){
	$nomer=$resr["nome"];
?>
                    <option value="<? print $nomer; ?>"<? if($res["responsavel"]==$nomer) print "selected"; ?>><? print($nomer); ?></option>
                    <? } ?>
                  </select>
                </span></td>
                <td width="64" class="texto">
				  <div align="center">
				    <input name="ini[<? print $res["id"]; ?>]" type="text" class="formularioselectsemborda" id="ini<? print $i; ?>" value="<? if($res["ini"]=="0000-00-00"){ print ""; }else{ print banco2data($res["ini"]); } ?>" size="1" maxlength="10" onKeyUp="mdata(this)" onKeyPress="return validanum(this, event)">
			      </div></td>
                <td width="65" class="texto"><div align="center">
                  <input name="prazo[<? print $res["id"]; ?>]" type="text" class="formularioselectsemborda" id="prazo<? print $i; ?>" value="<? if($res["prazo"]=="0000-00-00"){ print ""; }else{ print banco2data($res["prazo"]); } ?>" size="1" maxlength="10" onKeyUp="mdata(this)" onKeyPress="return validanum(this, event)">
                </div></td>
                <td width="64" class="texto"><div align="center">
                  <input name="fim[<? print $res["id"]; ?>]" type="text" class="formularioselectsemborda" id="fim<? print $res["id"]; ?>" value="<? if($res["fim"]=="0000-00-00"){ print ""; }else{ print banco2data($res["fim"]); } ?>" size="1" maxlength="10" onKeyUp="mdata(this)" onKeyPress="return validanum(this, event)" <? if($ativ!="Análise Critica" and $ativ!="Ferramental/Instalações" and $ativ!="Instruções do Operador" and $ativ!="Verificação / validação" and $ativ!="Lote Piloto"){ print "readonly"; } ?>>
                </div></td>
                <td width="121" align="center" class="texto"><span class="textobold">
                  <input name="resp[<? print $res["id"]; ?>]" class="formularioselectsemborda" id="resp" value="<? print $res["resp"] ?>" <? if($ativ!='Análise Critica' and $ativ!='Verificação / validação'){ print "readonly"; } ?>>
                </span></td>
                <td width="35" class="texto"><div align="center">
                  <input name="perc[<? print $res["id"]; ?>]" type="text" class="formularioselectsemborda" id="perc<? print $res["id"]; ?>" value="<? print $res["perc"]; ?>" size="1" maxlength="3" <? if($ativ!='Análise Critica' and $ativ!='Verificação / validação'){ print "readonly"; } ?>>
                </div></td>
                <td align="center" class="texto"><input name="obs[<? print $res["id"]; ?>]" type="text" class="formularioselectsemborda" id="obs<? print $res["id"]; ?>" value="<? print $res["obs"]; ?>" size="1" maxlength="255"></td>
              </tr>
              <?
	}
}
?>
            </table>
            <table width="826" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><img src="imagens/dot.gif" width="200" height="10"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="826" border="0" cellspacing="0" cellpadding="0">
                    <?
$sqlcron=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
$resc=mysql_fetch_array($sqlcron);
?>
                    <tr class="textobold">
                      
                      <td width="96" align="right">Aprovado por:&nbsp; </td>
                      <td width="268"><input name="quem" type="text" class="formularioselect" id="quem" value="<?= $resc["crono_quem"]; ?>" readonly></td>
                      <td width="32" align="center">data:</td>
                      <td width="69"><input name="dtquem" type="text" class="formularioselect" id="dtquem3" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($resc["crono_dtquem"]); ?>" size="7" maxlength="10" readonly=""></td>
					  
					  <?
					  if(empty($resc["crono_quem"])){
							$javas="if(confirm('Documento já foi salvo?  Caso contrário os dados serão perdidos!')){ 
										if(confirm('Deseja Aprovar o Cronograma?')){ 
										}else{ 
											return false; 
										} 
									}else{
									 return false; 
									 }";
					  }else{
							$javas="window.alert('Clique em Limpar primeiro'); return false;";
					  }
					  ?>
                    <td width="129"><div align="center">
                            <p>
                              <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?= $javas; ?>">
                              &nbsp;
							  <input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="<? print $javalimp; ?>">
                            </p>
                            </div></td></tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><img src="imagens/dot.gif" width="200" height="10"></td>
              </tr>
              <tr>
                <td align="center"><input name="acao" type="hidden" id="acao" value="alt">
                    <input name="voltar" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_crono.php';">
                    &nbsp;
				  <input name="continuar" type="submit" class="microtxt" value="Continuar" onClick="<?= $btnsalva; ?>">
				  <input name="acum" type="hidden" id="acum" value="<? print $i;?>"></td>
              </tr>
            </table>
         <? if($aprov=="N") print "<script>bloke();</script>"; ?> </form></td>
      </tr>
      <? }elseif($acao=="inc"){ ?>
      <tr>
        <td align="left" valign="top"><form name="form2" method="post" action="apqp_crono_sql.php" onSubmit="return verificainc(this);">
            <table width="825" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
              <tr class="textoboldbranco">
                <td width="160">&nbsp;Atividade</td>
                <td width="121">&nbsp;Respons&aacute;vel</td>
                <td width="65" align="center">In&iacute;cio</td>
                <td width="64" align="center">Prazo</td>
                <td width="64" align="center">Fim</td>
                <td width="37" align="center">%</td>
                <td width="264" align="center">Obs</td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td width="160"><input name="ativ" type="text" class="formularioselectsemborda" id="ativ[<? print $res["id"]; ?>]3" size="1"></td>
                <td width="121" class="texto"><select name="responsavel" class="formulario" id="responsavel">
<option value="">Selecione</option>
                    <?
$sqlr=mysql_query("SELECT * FROM funcionarios ORDER BY nome ASC");
while($resr=mysql_fetch_array($sqlr)){
	$nomer=$resr["nome"];
?>
                    <option value="<? print $nomer; ?>"<? if($res["responsavel"]==$nomer) print "selected"; ?>><? print($nomer); ?></option>
                    <? } ?>
                </select></td>
                <td width="65" align="center" class="texto"><input name="ini" type="text" class="formularioselectsemborda" id="ini[<? print $res["id"]; ?>]3" size="1" maxlength="10" onKeyUp="mdata(this)" onKeyPress="return validanum(this, event)"></td>
                <td width="64" align="center" class="texto"><input name="prazo" type="text" class="formularioselectsemborda" id="prazo[<? print $res["id"]; ?>]3" size="1" maxlength="10" onKeyUp="mdata(this)" onKeyPress="return validanum(this, event)"></td>
                <td width="64" align="center" class="texto"><input name="fim" type="text" class="formularioselectsemborda" id="fim[<? print $res["id"]; ?>]3" size="1" maxlength="10" onKeyUp="mdata(this)" onKeyPress="return validanum(this, event)"></td>
                <td width="37" align="center" class="texto"><input name="perc" type="text" class="formularioselectsemborda" id="perc[<? print $res["id"]; ?>]3" value="0" size="1" maxlength="3" onKeyPress="return validanum(this, event)"></td>
                <td align="center" class="texto"><input name="obs" type="text" class="formularioselectsemborda" id="obs[<? print $res["id"]; ?>]3" size="1" maxlength="255"></td>
              </tr>
            </table>
            <table width="826" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="826"><img src="imagens/dot.gif" width="200" height="8"></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
                    <tr bgcolor="#003366">
                      <td colspan="2" align="center" class="textoboldbranco">Posicionamento</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="77" align="center" class="textobold">Incluir</td>
                      <td width="323"><select name="pos" class="formularioselect" id="pos">
                          <option value="0">no in&iacute;cio do cronograma</option>
                          <?
$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
if(mysql_num_rows($sql)!=0){
	while($res=mysql_fetch_array($sql)){
?>
                          <option value="<? print $res["pos"]; ?>">depois de <? print $res["ativ"]; ?></option>
                          <?
		
	}
}
?>
                          <option value="fim" selected>no final do cronograma</option>
                      </select></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="826" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="826" align="center"><input name="acao" type="hidden" id="acao" value="inc">
                    <input name="button1233" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_crono.php';">
                    &nbsp;
				  <input name="button12322" type="submit" class="microtxt" value="Continuar" onClick="<?= $btnsalva; ?>">                </td>
              </tr>
            </table>
        </form></td>
      </tr>
	
      <? } ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>