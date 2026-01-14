<?php
include("conecta.php");
include("seguranca.php");
$muda=Input::request("muda");
$wop=Input::request("wop");
if($muda){
	$_SESSION["wop"]=$wop;
}else{
	$wop=$_SESSION["wop"];
}

$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_fmeaproc WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Preencha o cabeçalho";
	print "<script>window.location='apqp_fmeaprocc.php';</script>";
	exit;
}else{
	$res=mysql_fetch_array($sql);
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
			if(mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ form1.acao.value='altt'; lista.verifica(); } return false;";
				$btnsalva2="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ form1.acao.value='altt'; lista.frmcar.maisum.value=1; lista.frmcar.submit(); return false; } return false;";
				$btnsalva3="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ if(confirm('Deseja excluir as linhas?')) { form1.acao.value='altt';lista.frmcar.delsel.value=1; lista.frmcar.submit(); } return false; } return false;";
				$btnsalva4="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente.')){ abre('apqp_fmeaproct_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes'); } return false;";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='altt'; lista.verifica(); return false; } return false;";
				$btnsalva2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='altt'; lista.frmcar.maisum.value=1; lista.frmcar.submit(); } return false;";
				$btnsalva3="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja excluir as linhas?')) { form1.acao.value='altt'; lista.frmcar.delsel.value=1; lista.frmcar.submit(); } } return false;";
				$btnsalva4="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ abre('apqp_fmeaproct_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes'); } return false;";
			}
		}else{
				$btnsalva="form1.acao.value='altt'; lista.verifica(); return false;";
				$btnsalva2="form1.acao.value='altt'; lista.frmcar.maisum.value=1; lista.frmcar.submit();";
				$btnsalva3="if(confirm('Deseja excluir as linhas?')) { form1.acao.value='altt'; lista.frmcar.delsel.value=1; lista.frmcar.submit(); }";
				$btnsalva4="abre('apqp_fmeaproct_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes'); ";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altt'; lista.verifica(); return false; }else{ return false; } }else{ return false; }";
		$btnsalva2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='altt'; lista.frmcar.maisum.value=1; lista.frmcar.submit(); }else{ return false; } }else{ return false; }";
		$btnsalva3="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ if(confirm('Deseja excluir as linhas?')) { form1.acao.value='altt'; lista.frmcar.delsel.value=1; lista.frmcar.submit(); } }else{ return false; } }else{ return false; }";	
		$btnsalva4="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ abre('apqp_fmeaproct_pop.php?peca=$pc&op=$wop','selimagem','width=625,height=600,scrollbars=yes');  	 }else{ return false; } }else{ return false; }";	
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
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?php echo $pc?> + '');
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
	if(form1.wop[form1.wop.selectedIndex].value==0){
		alert('Selecione uma operação');
		form1.wop.focus();
	}else{
		window.location='apqp_fmeaproct.php?muda=S&wop='+form1.wop[form1.wop.selectedIndex].value;
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
    <td width="645" align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_fmea_process.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='FMEA de Processo'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Requisitos/Funções do Processo - </strong>Descrição simplificada do processo ou operação em análise. <br><strong>Modo de Falha Potencial (Processo) - </strong>É definido como a maneira pela qual o processo potencialmente falharia. <br><strong>Severidade (FMEA de Processo) </strong>Avaliação da gravidade do efeito do modo de falha potencial para o cliente. <br><strong>Classificação (Processo) - </strong>Esta coluna pode ser usada para classificar (ex.: crítica, maior, chave, significante) qualquer característica.<br><strong>Efeitos Potenciais da Falha (Processo) - </strong>É definido como o efeito do modo de falha no cliente.<br><strong>Mecanismo(s)/Causa(s) Potenciais de Falha (Processo) </strong>É definida como a forma pela qual a falha pode ocorrer, descrita de forma específica e objetiva.<br><strong>Ocorrência (FMEA de Processo) - </strong>a probabilidade de um mecanismo/causa específico (listado na coluna anterior) vir a ocorrer.<br><strong>Controles Atuais do Processo - </strong>São descrições dos controles que podem detectar a ocorrência do modo de falha<br><strong>Detecção (FMEA de Processo) - </strong>É uma avaliação da probabilidade dos controles de processo (listados na coluna anterior) identificarem o modo de falha durante o processo. <br><strong>Ações Recomendadas (Processo) -  </strong>Propostas ou medidas preventivas para os itens críticos/ com ponderação alta.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - FMEA de Processo&nbsp;<?php print $npc; ?></div></td>
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
        <a href="apqp_fmeaprocc.php">
        <td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">cabe&ccedil;alho</td>
        </a>
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">tabela</td>		
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="834" align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><form action="apqp_fmeaproc_sql.php" method="post" name="form1"><table width="581" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="61" class="textobold">Opera&ccedil;&atilde;o</td>
                <td width="520"><select name="wop" class="formularioselect" onChange="mselop();">
                    <option value="0">Selecione uma opera&ccedil;&atilde;o</option>
                    <?php
$ops=mysql_query("SELECT * FROM apqp_op WHERE peca='$pc' ORDER BY numero ASC");
if(mysql_num_rows($ops)){
	while($rops=mysql_fetch_array($ops)){
?>
                    <option value="<?php echo  $rops["id"]; ?>" <?php if($rops["id"]==$wop) print "selected"; ?>>
                    <?php echo  htmlspecialchars($rops["numero"], ENT_QUOTES); ?>
        -
        <?php echo  htmlspecialchars($rops["descricao"], ENT_QUOTES); ?>
                    </option>
                    <?php
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
            <td><IFRAME name="lista" id="lista" src="apqp_fmeaproct2.php" width="100%" height="350" frameborder="0" scrolling="yes">
</IFRAME></td>
          </tr>
          <tr>
            <td><img src="imagens/spacer.gif" width="46" height="5">
         
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
                <tr>
                  <td align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF"><input name="button1" type="button" class="microtxt" value="Importar" onClick="<?php echo  $btnsalva4; ?>">
&nbsp;
<input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;<input name="local" type="hidden" id="local" value="processo">
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('processo','<?php echo $res["id"];?>')">
<input name="acao" type="hidden">
&nbsp;
<input name="button1222" type="button" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Adicionar Linha" onClick="<?php echo  $btnsalva2; ?>">
&nbsp;
<input name="button12223" type="button" class="microtxt" value="Excluir Linha" onClick="<?php echo  $btnsalva3; ?>"></td>
                </tr>
              </table></form></td>
        </tr>
        </table></td>
  </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>