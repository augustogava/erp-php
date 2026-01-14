<?
include("conecta.php");
include("seguranca.php");
if($_GET["muda"]){
	$_SESSION["wop"]=$_GET["wop"];
}else{
	$wop=$_SESSION["wop"];
}

$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Preencha o cabeçalho";
	print "<script>window.location='apqp_fmeaprojc.php';</script>";
	exit;
}else{
	$res=mysql_fetch_array($sql);
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)'");
		if(mysql_num_rows($sqlb)){
			$sqlfmea=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
			if(mysql_num_rows($sqlfmea)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ lista.verifica(); } return false;";
				$btnsalva2="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ lista.frmcar.maisum.value=1; lista.frmcar.submit(); } return false;";
				$btnsalva3="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } } return false;";
				$btnsalva4="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ return abre('apqp_fmeaprojt_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes'); } return false;";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ lista.verifica(); }else{ return false; }";
				$btnsalva2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ lista.frmcar.maisum.value=1; lista.frmcar.submit(); }else{ return false; }";
				$btnsalva3="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } }else{ return false; }";
				$btnsalva4="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ return abre('apqp_fmeaprojt_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes'); }else{ return false; }";

			}
		}else{
			$btnsalva="lista.verifica();";
			$btnsalva2=" lista.frmcar.maisum.value=1; lista.frmcar.submit(); ";
			$btnsalva3=" if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); }";
			$btnsalva4="return abre('apqp_fmeaprojt_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes');";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ lista.verifica(); }else{ return false; } }else{ return false; }";
		$btnsalva2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ lista.frmcar.maisum.value=1; lista.frmcar.submit(); }else{ return false; } }else{ return false; }";
		$btnsalva3="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } }else{ return false; } }else{ return false; }";
		$btnsalva4="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ return abre('apqp_fmeaprojt_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes'); }else{ return false; } }else{ return false; }";
	}
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

function fnlinha(){
	inclui=true;
	for(i=0; i<lista.jacar.length; i++){
		if(lista.jacar[i]==wcar[wcar.selectedIndex].value){
			inclui=false;
			break;
		}
	}
	if(inclui){
		lista.frmcar.maisum.value=1;
		lista.frmcar.wcar.value=wcar[wcar.selectedIndex].value;
		lista.frmcar.submit();
	}else{
		alert('Esta característica já foi selecionada');
	}
}
function mselop(){
	if(wop[wop.selectedIndex].value==0){
		alert('Selecione uma operação');
		wop.focus();
	}else{
		window.location='apqp_fmeaprojt.php?muda=S&wop='+wop[wop.selectedIndex].value;
	}
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_fmea_projeto.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='FMEA de Projeto'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Modo de falha potencial - </strong>Definido como a maneira pela qual um componente, subsistema ou sistema potencialmente falharia.<br><strong>Efeitos Potenciais da Falha - </strong>Definidos como os efeitos do modo de falha na função, como percebido pelo cliente.<br><strong>Severidade (FMEA DE PROJETO) - </strong>Severidade é uma avaliação da gravidade do efeito do modo de falha potencial e é medida em uma escala de 1 a 10 de pontuação. <br><strong>C (Classificação) - </strong>Classifica qualquer característica de um componente, subsistema ou sistema que podem requerer controles adicionais do processo.<br><strong>Causa/Mecanismo Potencial de Falha - </strong>É definida como uma indicação de uma deficiência do projeto.<br><strong>Ocor (Ocorrência FMEA de Projeto) - </strong>É a probabilidade de um mecanismo/causa específico (listado na linha anterior) vir a ocorrer. <br><strong>Prevenção - </strong>Medidas preventivas para os itens críticos.<br><strong>Detecção (FMEA DE Projeto) - </strong>É uma avaliação da eficácia dos controles atuais do projeto propostos.<br><strong>Ações recomendadas - </strong>Medidas preventivas para os itens críticos.<br><strong>Ações tomadas - </strong>Descrição da mesma e a data de sua efetivação.<br><strong>Responsável/prazo - </strong>Responsável pela ação recomendada com o respectivo prazo para execução')"></a><span class="impTextoBold">&nbsp;</span></div></td>
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
        <a href="apqp_fmeaprojc.php">
        <td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">cabe&ccedil;alho</td>
        </a>
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">tabela</td>		
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="581" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="61" class="textobold">Opera&ccedil;&atilde;o</td>
                  <td width="520"><select name="wop" class="formularioselect" onChange="mselop();">
                      <option value="0">Selecione uma opera&ccedil;&atilde;o</option>
                      <?
$ops=mysql_query("SELECT * FROM apqp_op WHERE peca='$pc' ORDER BY numero ASC");
if(mysql_num_rows($ops)){
	while($rops=mysql_fetch_array($ops)){
?>
                      <option value="<?= $rops["id"]; ?>" <? if($rops["id"]==$wop) print "selected"; ?>>
                      <?= htmlspecialchars($rops["numero"], ENT_QUOTES); ?>
            -
            <?= htmlspecialchars($rops["descricao"], ENT_QUOTES); ?>
                      </option>
                      <?
	}
}
?>
                  </select></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="textobold"><img src="imagens/dot.gif" width="50" height="8"></span></td>
          </tr>
          <tr>
            <td><IFRAME name="lista" id="lista" src="apqp_fmeaprojt2.php" width="100%" height="350" frameborder="0" scrolling="yes"></IFRAME></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><br>
<form name="form1" method="post" action="apqp_fmeaproj_sql.php">
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999" bgcolor="#999999">
  <tr>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">
	
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
	 
        <table width="100%"  border="0" cellspacing="0" cellpadding="6">
          <tr>
            <td><div align="center">
              <input name="button1" type="button" class="microtxt" value="Importar" onClick="<?= $btnsalva4; ?>">
              &nbsp;&nbsp;
              <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('projeto','<?=$res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>">
&nbsp;
<input name="button12222222" type="button" class="microtxt" value="Adicionar Linha" onClick="<?= $btnsalva2; ?>">
&nbsp;
<input name="button1222222" type="button" class="microtxt" value="Excluir" onClick="<?= $btnsalva3; ?>">
&nbsp; 
                <a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"><span class="textobold">
                <input name="acao" type="hidden" value="1">
                </span></a></div></td>
          </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>