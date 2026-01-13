<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	$sql=mysql_query("INSERT INTO apqp_viabilidade (peca) VALUES ('$pc')");
	$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc'");
	$res=mysql_fetch_array($sql);
}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Viabilidade'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="form1.acao.value='v2'; form1.submit(); return false;";
		}else{
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Diagrama de Fluxo'");
			if(mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ form1.acao.value='v2'; form1.submit();  } return false;";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='v2'; form1.submit(); return false; }else{ return false; }";
			}
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v2'; form1.submit(); }else{ return false; } }else{ return false; }";
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
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_viabilidade.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Comentários'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Para inserir Comentários / Explicações, selecione a aba Comentários, clique dentro da caixa de texto, digite o texto e clique no botão Salvar.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Viabilidade <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="602"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="594" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top" class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textobold"><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr>
              <td class="txt_inf"><b>Considera&ccedil;&otilde;es sobre Viabilidade</b></td>
            </tr>
            <tr>
              <td class="txt_inf">Nossa equipe de planejamento da qualidade do produto considerou as seguintes quest&otilde;es, que n&atilde;o pretendem ser totalmente inclu&iacute;das na execu&ccedil;&atilde;o de uma avalia&ccedil;&atilde;o de viabilidade. Os desenhos e/ou especifica&ccedil;&otilde;es fornecidos foram usados como base para analisar a capacidade de atender a todos os requisitos especificados. Todas as respostas &quot;n&atilde;o&quot; s&atilde;o suportadas por coment&aacute;rios anexo identificando nossas preocupa&ccedil;&otilde;es e/ou altera&ccedil;&otilde;es propostas para nos habilitar a atender os requisitos especificados. </td>
            </tr>
			<tr>
              <td class="txt_inf"><img src="imagens/spacer.gif" width="46" height="5"></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr align="center"> <a href="apqp_viabilidade1.php">
              <td width="146" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">question&aacute;rio</td>
              </a>
                <td width="146" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">coment&aacute;rios</td>
                <a href="apqp_viabilidade3.php">
                <td width="146" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">conclus&atilde;o</td>
                </a> <a href="apqp_viabilidade4.php">
                <td width="146" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">aprovar</td>
              </a> </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
              <form name="form1" method="post" action="apqp_viabilidade_sql.php">
                <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td class="textobold">coment&aacute;rios / explica&ccedil;&otilde;es </td>
                    </tr>
                    <tr>
                      <td><textarea name="obs" rows="15" wrap="VIRTUAL" class="formularioselect" id="obs" onFocus="enterativa=0;" onBlur="enterativa=1;"><?= $res["obs"]; ?>
    </textarea></td>
                    </tr>
                    <tr>
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                    </tr>
                    <tr>
                      <td align="center">
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
                    <input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('viabilidade','<?=$res["id"];?>')">
					&nbsp;
                    <input name="button12222" type="submit" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>">
					&nbsp;
                    <input name="acao" type="hidden" id="acao">
                    <a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"><span class="textobold">
                    <input name="local" type="hidden" id="local" value="viabilidade">
                    </span></a></td>
                    </tr>
                </table></td>
              </form>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>