<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
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
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Diagrama de Fluxo'");
		if(mysql_num_rows($sqlb)){
			$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ form1.acao.value='v4'; form1.submit();  } return false;";
			$javalimp="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
			$javalimp2="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
			$javalimp3="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
			$javalimp4="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
			$javalimp5="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
			$javalimp6="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		}else{
			$btnsalva="form1.acao.value='v4'; form1.submit(); return false;";			
		    $javalimp="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='v4';form1.submit(); } else {return false;}";
		    $javalimp2="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='v4';form1.submit(); } else {return false;}";
			$javalimp3="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='v4';form1.submit(); } else {return false;}";	
			$javalimp4="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='v4';form1.submit(); } else {return false;}";		
			$javalimp5="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='v4';form1.submit(); } else {return false;}";
			$javalimp6="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='v4';form1.submit(); } else {return false;}";
		}
	}else{
		$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp3="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp4="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp5="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp6="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='v4';form1.submit(); }else{ return false; } }else{ return false; }";
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
	document.all.form1.ap1.disabled=true;	
	document.all.form1.ap2.disabled=true;
	document.all.form1.ap3.disabled=true;	
	document.all.form1.ap4.disabled=true;	
	document.all.form1.ap5.disabled=true;	
	document.all.form1.ap6.disabled=true;	
	document.all.form1.lap1.disabled=true;	
	document.all.form1.lap2.disabled=true;	
	document.all.form1.lap3.disabled=true;	
	document.all.form1.lap4.disabled=true;	
	document.all.form1.lap5.disabled=true;	
	document.all.form1.lap6.disabled=true;	
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<form name="form1" method="post" action="apqp_viabilidade_sql.php">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_viabilidade.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Aprovação'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('A cada aprovação é gravado o nome e a data de que aprovou, que esta logado no momento da aprovação.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1">APQP - Viabilidade <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
  </table>
<table width="589"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="595" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top" class="textobold"><table width="96%"  border="0" cellspacing="0" cellpadding="0">
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
        <td align="left" valign="top"><table width="594" border="1" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF">
            <tr> <a href="apqp_viabilidade1.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">question&aacute;rio</td>
              </a> <a href="apqp_viabilidade2.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">coment&aacute;rios</td>
              </a> <a href="apqp_viabilidade3.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">conclus&atilde;o</td>
              </a>
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">aprovar</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
              <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    
                    <td width="97"  align="center" class="textobold">Aprovado por: </td>
                    <td width="193" ><input name="tap1" type="text" class="formularioselect" id="tap1" value="<?php echo  $res["ap1"]; ?>"></td>
					 
                    <td width="39"  align="center" class="textobold">Data:</td>
                    <td><input name="dt1" type="text" class="formularioselect" id="dt1" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dt1"]); ?>" size="7" maxlength="10"></td>
				<?php 
				  if(empty($res["ap1"])){
					$javas="if(confirm('Deseja Aprovar Viabilidade?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
					$javalimp="window.alert('Viabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
					$javas="window.alert('A Viabilidade já foi aprovada, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				 ?>
                  	<td width="160" align="center"><input name="ap1" type="submit" class="microtxt" id="ap1" value="aprovar" onClick="<?php echo  $javas; ?>">
                        &nbsp;
						<input name="lap1" type="submit" class="microtxt" id="lap1" value="limpar" onClick="<?php echo  $javalimp;?>"></td></tr>
                  <tr>
                    <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                  </tr>
                  <tr>
                    
                    <td align="center" class="textobold">Aprovado por: </td>
                    <td><input name="tap12" type="text" class="formularioselect" id="tap12" value="<?php echo  $res["ap2"]; ?>"></td>
                    <td align="center" class="textobold">Data:</td>
                    <td><input name="dt2" type="text" class="formularioselect" id="dt2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dt2"]); ?>" size="7" maxlength="10"></td>
					<?php 
				  if(empty($res["ap2"])){
					$javas2="if(confirm('Deseja Aprovar Viabilidade?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
					$javalimp2="window.alert('Viabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";

				  }else{
					$javas2="window.alert('A Viabilidade já foi aprovada, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				 ?>
                  	<td align="center"><input name="ap2" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?php echo  $javas2; ?>">
                        &nbsp;
                        <input name="lap2" type="submit" class="microtxt" id="lap2" value="limpar" onClick="<?php echo  $javalimp2;?>"></td>
                  </tr>
                  <tr>
                    <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                  </tr>
                  <tr>
                    
                    <td align="center" class="textobold">Aprovado por: </td>
                    <td><input name="tap13" type="text" class="formularioselect" id="tap13" value="<?php echo  $res["ap3"]; ?>"></td>
                    <td align="center" class="textobold">Data:</td>
                    <td><input name="dt3" type="text" class="formularioselect" id="dt3" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dt3"]); ?>" size="7" maxlength="10"></td>
					<?php 
				  if(empty($res["ap3"])){
					$javas3="if(confirm('Deseja Aprovar Viabilidade?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
					$javalimp3="window.alert('Viabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";

				  }else{
					$javas3="window.alert('A Viabilidade já foi aprovada, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				 ?>
                  <td align="center"><input name="ap3" type="submit" class="microtxt" id="ap3" value="aprovar" onClick="<?php echo  $javas3; ?>">
                        &nbsp;
						<input name="lap3" type="submit" class="microtxt" id="lap3" value="limpar" onClick="<?php echo  $javalimp3;?>"></td></tr>
                  <tr>
                    <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                  </tr>
                  <tr>
                    
                    <td align="center" class="textobold">Aprovado por: </td>
                    <td><input name="tap14" type="text" class="formularioselect" id="tap14" value="<?php echo  $res["ap4"]; ?>"></td>
                    <td align="center" class="textobold">Data:</td>
                    <td><input name="dt4" type="text" class="formularioselect" id="dt4" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dt4"]); ?>" size="7" maxlength="10"></td>
					<?php 
				  if(empty($res["ap4"])){
					$javas4="if(confirm('Deseja Aprovar Viabilidade?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
					$javalimp4="window.alert('Viabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
					$javas4="window.alert('A Viabilidade já foi aprovada, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				 ?>
                  <td align="center"><input name="ap4" type="submit" class="microtxt" id="ap4" value="aprovar" onClick="<?php echo  $javas4; ?>">
                        &nbsp;
						<input name="lap4" type="submit" class="microtxt" id="lap4" value="limpar" onClick="<?php echo  $javalimp4;?>"></td></tr>
                  <tr>
                    <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                  </tr>
                  <tr>
                    
                    <td align="center" class="textobold">Aprovado por: </td>
                    <td><input name="tap15" type="text" class="formularioselect" id="tap15" value="<?php echo  $res["ap5"]; ?>"></td>
                    <td align="center" class="textobold">Data:</td>
                    <td><input name="dt5" type="text" class="formularioselect" id="dt5" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dt5"]); ?>" size="7" maxlength="10"></td>
					<?php 
				  if(empty($res["ap5"])){
					$javas5="if(confirm('Deseja Aprovar Viabilidade?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
					$javalimp5="window.alert('Viabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
					$javas5="window.alert('A Viabilidade já foi aprovada, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				 ?>
                  	<td align="center"><input name="ap5" type="submit" class="microtxt" id="ap5" value="aprovar" onClick="<?php echo  $javas5; ?>">
                        &nbsp;
						<input name="lap5" type="submit" class="microtxt" id="lap5" value="limpar" onClick="<?php echo  $javalimp5;?>"></td></tr>
                  <tr>
                    <td colspan="5" align="center"><img src="imagens/dot.gif" width="50" height="8"></td>
                  </tr>
                  <tr>
                    
                    <td align="center" class="textobold">Aprovado por: </td>
                    <td><input name="tap16" type="text" class="formularioselect" id="tap16" value="<?php echo  $res["ap6"]; ?>"></td>
                    <td align="center" class="textobold">Data:</td>
                    <td><input name="dt6" type="text" class="formularioselect" id="dt6" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dt6"]); ?>" size="7" maxlength="10"></td>
					<?php 
				  if(empty($res["ap6"])){
					$javas6="if(confirm('Deseja Aprovar Viabilidade?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
					$javalimp6="window.alert('Viabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
					$javas6="window.alert('A Viabilidade já foi aprovada, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				 ?>
                  <td align="center"><input name="ap6" type="submit" class="microtxt" id="ap6" value="aprovar" onClick="<?php echo  $javas6; ?>">
                    &nbsp;
					    <input name="lap6" type="submit" class="microtxt" id="lap6" value="limpar" onClick="<?php echo  $javalimp6;?>"></td></tr>
                  <input name="acao" type="hidden" id="acao" value="0">
              </table>
			  <?php if($aprov=="N") print "<script>bloke();</script>"; ?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
      </tr>
      <tr>
        <td align="center" valign="top">	
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
			
        <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
      <input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('viabilidade','<?php echo $res["id"];?>')">
&nbsp;&nbsp;&nbsp;
<?php
$apqp->agenda_p("Viabilidade","apqp_viabilidade4.php");
?>
      <a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"><span class="textobold">
      <input name="local" type="hidden" id="local" value="viabilidade">
      </span></a>        </td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>