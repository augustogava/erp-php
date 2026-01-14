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

$sql=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc' and fase='$fase'");
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Preencha o cabeçalho";
	print "<script>window.location='apqp_planoc.php?fase=$fase';</script>";
	exit;
}else{
	$res=mysql_fetch_array($sql);
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
			if(!mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ lista.frmcar.submit(); return false; } return false;";
				$btnsalva2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ fnlinha(); return false; } return false;";
				$btnsalva3="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } return false; } return false;";
				$btnsalva4="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ return abre('apqp_plano_pop.php?pc=$pc&fase=$fase','selimagem','width=625,height=130,scrollbars=yes'); } return false;";
			}else{
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ lista.frmcar.submit(); return false;  } return false;";
				$btnsalva2="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ fnlinha(); return false;  } return false;";
				$btnsalva3="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } return false;  } return false;";
				$btnsalva4="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ return abre('apqp_plano_pop.php?pc=$pc&fase=$fase','selimagem','width=625,height=130,scrollbars=yes');  } return false;";	}
		}else{
			$btnsalva="lista.frmcar.submit(); return false;";
			$btnsalva2="fnlinha(); return false;";
			$btnsalva3="if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } return false;";		$btnsalva4="return abre('apqp_plano_pop.php?pc=$pc&fase=$fase','selimagem','width=625,height=130,scrollbars=yes');";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altc'; form1.submit(); return false; }else{ return false; } }else{ return false; }";
		$btnsalva2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ fnlinha(); return false; }else{ return false; } }else{ return false; }";
		$btnsalva3="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ if(confirm('Deseja excluir as linhas?')) { lista.frmcar.delsel.value=1; lista.frmcar.submit(); } return false; }else{ return false; } }else{ return false; }";
		$btnsalva4="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ return abre('apqp_plano_pop.php?pc=$pc&fase=$fase','selimagem','width=625,height=130,scrollbars=yes'); }else{ return false; } }else{ return false; }";
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
		window.location='apqp_planot.php?muda=S&wop='+wop[wop.selectedIndex].value+'&fase='+lista.frmcar.fase.value;
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
    <td align="left" valign="top" class="chamadas"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_plano_controle.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Plano de Controle'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Característica do produto - </strong>características ou propriedades de uma peça<br><strong>Característica do Processo - </strong>variáveis do processo que tem uma relação de causa-efeito com a característica do produto. <br><strong>S - </strong>Símbolo<br><strong>Especificação do produto/processo - </strong>Recomendações obtidas dos documentos de engenharia.<br><strong>Técnicas de Avaliação de Medição - </strong>Sistema de medição utilizado. <br><strong>Tamanho da Amostra/Freqüência - </strong>Quantidade e freqüência de amostra.<br><strong>Método de Controle - </strong>Breve descrição de como a operação é controlada<br><strong>Plano de Reação - </strong>Especifica as ações corretivas necessárias.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Plano de Controle &nbsp;<? print $npc; print $res["id"]; ?></div></td>
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
        <a href="apqp_planoc.php">
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
            <td><table width="609" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="85" class="textobold">Opera&ccedil;&atilde;o:</td>
                  <td width="403"><select name="wop" class="formularioselect" onChange="mselop();">
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
                  <td width="91">&nbsp;</td>
                </tr>
                <? if($wop){ ?>
                <tr>
                  <td class="textobold">Caracter&iacute;stica: </td>
                  <td><select name="wcar" class="formularioselect" id="wcar" onChange="<?= $btnsalva2; ?>">
				  <option value="">Selecione</option>
                      <?
$cars=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND pc='S' ORDER BY tipo ASC,numero ASC");
if(mysql_num_rows($cars)){
	while($rcars=mysql_fetch_array($cars)){
?>
                      <option value="<?= $rcars["id"]; ?>">
                      <?= $rcars["numero"]; ?>
              -
              <?= htmlspecialchars($rcars["espec"], ENT_QUOTES); ?>
              -
              <?= htmlspecialchars($rcars["tipo"], ENT_QUOTES); ?>
                      </option>
                      <?
	}
}
?>
                  </select></td>
                  <td >&nbsp;</td>
                </tr>
                <? } ?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><iframe name="lista" id="lista" src="apqp_planot2.php?fase=<?= $fase; ?>" width="100%" height="350" frameborder="0" scrolling="yes"></iframe></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">
	  <br>
	  <table width="600" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999" bgcolor="#999999">
  <tr>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">
    <form name="form1" method="post" action="apqp_plano_sql.php">
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
          <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="button1" type="button" class="microtxt" value="Importar" onClick="<?= $btnsalva4; ?>">
&nbsp;
<input name="acao1" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('controle','<?=$res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>">
&nbsp;
<input name="button122222" type="button" class="microtxt" value="Excluir Linha" onClick="<?= $btnsalva3; ?>">
&nbsp;
<input name="acao" type="hidden" id="acao" value="1">
  <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
  <input name="local" type="hidden" id="local" value="controle">
  </a></div></td>
      </tr>
    </table></form>
</td>
  </tr>

</table>
	</td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>