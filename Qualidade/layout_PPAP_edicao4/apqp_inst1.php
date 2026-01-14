<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
$local=Input::request("local");
$email=Input::request("email");
$nome=Input::request("nome");
$numero=Input::request("numero");
$prep=Input::request("prep");
$prep_data=Input::request("prep_data");
$obs=Input::request("obs");
$rev=Input::request("rev");
$rev_data=Input::request("rev_data");
$rev_alt=Input::request("rev_alt");
$ap=Input::request("ap");
$lap=Input::request("lap");
$del=Input::request("del");
$salva=Input::request("salva");
$tipo=Input::request("tipo", []);
$texto=Input::request("texto", []);
$apqp=new set_apqp;
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$wop=$_SESSION["wop"];
if($acao=="inc"){
	$sql=mysql_query("INSERT INTO apqp_inst (peca,op) VALUES ('$pc','$wop')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_inst WHERE peca='$pc' AND op='$wop'");
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$_SESSION["iid"]=$id;
}elseif($acao=="alt"){
	$_SESSION["iid"]=$id;
}else{
	$id=$_SESSION["iid"];
}
$sql=mysql_query("SELECT * FROM apqp_inst WHERE id='$id'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
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
function verifica(cad){
	if(cad.nome.value==''){
		alert('Informe a Instrução');
		cad.nome.focus();
		return false;
	}
	if(cad.numero.value==''){
		alert('Informe o N. do Documento');
		cad.numero.focus();
		return false;
	}
	if(cad.prep.value==''){
		alert('Informe Preparado Por');
		cad.prep.focus();
		return false;
	}
	if(cad.prep_data.value==''){
		alert('Informe data Preparado Por');
		cad.prep_data.focus();
		return false;
	}
	if(cad.rev.value==''){
		alert('Informe N. Revisão');
		cad.rev.focus();
		return false;
	}
	if(cad.rev_data.value==''){
		alert('Informe Data Revisão');
		cad.rev_data.focus();
		return false;
	}
	form1.submit();
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
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_instr_opera.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Instru&ccedil;&atilde;o do Operador - Cabeçalho'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Preencha os campos com as informações pertinentes à instrução. Para aprovar a instrução, clique o botão Aprovar')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Instru&ccedil;&otilde;es do operador <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="600" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td width="594"><table width="594" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">cabe&ccedil;alho</td>
              <a href="apqp_inst2.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">imagem / desenho </td>
              </a> <a href="apqp_inst3.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">procedimento</td>
              </a> <a href="apqp_inst4.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">controles</td>
            </a> </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
              <form name="form1" method="post" action="apqp_inst_sql.php">
                <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><table width="571" border="0" cellspacing="0" cellpadding="3">
                        <tr class="textobold">
                          <td width="140">Instru&ccedil;&atilde;o</td>
                          <td colspan="4"><input name="nome" type="text" class="formularioselect" id="nome" value="<?php echo  $res["nome"]; ?>" maxlength="50"></td>
                        </tr>
                        <tr class="textobold">
                          <td>N&ordm; documento </td>
                          <td colspan="4"><input name="numero" type="text" class="formularioselect" id="ini4" value="<?php echo  $res["numero"]; ?>" size="20" maxlength="50"></td>
                        </tr>
                        <tr class="textobold">
                          <td height="27">Preparado por </td>
                          <td><input name="prep" type="text" class="formularioselect" id="prep" value="<?php echo  $res["prep"]; ?>" maxlength="50"></td>
                          <td width="56" colspan="-1" align="center"><div align="left">Data</div></td>
                          <td width="95" colspan="-1" ><input name="prep_data" type="text" class="formulario" id="prep_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["prep_data"]); ?>" size="8" maxlength="10">
                            &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_inst1_1&var_field=prep_data','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
                        </tr>
                        <tr class="textobold">
                          <td>Revis&atilde;o n&ordm; </td>
                          <td><input name="rev" type="text" class="formularioselect" id="numero" value="<?php echo  $res["rev"]; ?>" size="20" maxlength="50"></td>
                          <td colspan="-1" align="center"><div align="left">Data efet. </div></td>
                          <td colspan="-1" ><input name="rev_data" type="text" class="formulario" id="rev_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["rev_data"]); ?>" size="8" maxlength="10">
                            &nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_inst1_2&var_field=rev_data','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
                        </tr>
                        <tr class="textobold">
                          <td>Observa&ccedil;&otilde;es</td>
                          <td colspan="4"><input name="obs" type="text" class="formularioselect" id="nome3" value="<?php echo  $res["obs"]; ?>" maxlength="50"></td>
                        </tr>
                        <tr class="textobold">
                          <td valign="top">Descri&ccedil;&atilde;o das Altera&ccedil;&otilde;es</td>
                          <td colspan="4"><textarea name="rev_alt" rows="4" wrap="VIRTUAL" class="formularioselect" id="rev_alt" onFocus="enterativa=0;" onBlur="enterativa=1;"><?php echo $res["rev_alt"]; ?>
                      </textarea></td>
                        </tr>
                      </table>
                        <table width="100%"  border="0" cellspacing="0" cellpadding="3">
                          <tr>
                            <td width="16%" class="textobold">Aprovado por:</td>
                            <td width="39%"><span class="textobold">
                              <input name="quem" type="text" class="formularioselect" id="quem" value="<?php echo  $res["quem"]; ?>" readonly="">
                            </span></td>
                            <td width="6%"><div align="right"><span class="textobold">Data:
                                
                          </span></div></td>
                            <td width="19%"><span class="textobold">
                              <input name="dtquem" type="text" class="formularioselect" id="dtquem" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dtquem"]); ?>" size="7" maxlength="10" readonly="">
                            </span></td>
							 <?php 
				  if(empty($res["quem"])){
				  	$javas="if(confirm('Deseja Aprovar Apar&ecirc;ncia?')){form1.acao.value='i0';form1.submit();}else{ return false; }";
				  }else{
				  $javas="window.alert('Clique em Limpar primeiro');return false;";
				  }
				  ?>
                            <td width="20%"><div align="center"><span class="textobold">
                                <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?php echo  $javas; ?>">
								&nbsp;
                                <input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="if(confirm('Deseja Aprovar Apar&ecirc;ncia?')){form1.acao.value='i0';form1.submit();}else{ return false; }">
                            </span></div></td>
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
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                    </tr>
                    <tr>
                      <td align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_inst.php';">
					&nbsp;
                    <input name="button12222" type="button" class="microtxt" value="Salvar" onClick="form1.acao.value='i0'; return verifica(form1);">
					&nbsp;
                    <input name="acao1" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('inst','<?php echo $res["id"];?>')">
					&nbsp;&nbsp;
<?php
$apqp->agenda_p("Instruções do Operador","apqp_inst1.php");
//print serialize($apqp);
?>
                    <input name="acao" type="hidden" id="acao" value="1">
                    <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
                    <input name="local" type="hidden" id="local" value="inst">
                    </a></td>
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
<?php include("mensagem.php"); ?>