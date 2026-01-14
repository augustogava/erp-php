<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_interina WHERE peca='$pc'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	$sql=mysql_query("INSERT INTO apqp_interina (peca) VALUES ('$pc')");
	$sql=mysql_query("SELECT * FROM apqp_interina WHERE peca='$pc'");
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
	document.all.form1.ap1.disabled=true;	
	document.all.form1.lap1.disabled=true;	
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
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_viabilidade.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Comprometimento de viabilidade '; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Avaliar a viabilidade do projeto proposto pode ser fabricado, montado, testado, embalado e expedido no prazo e na quantidade requerida. ')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Aprovação Interina <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="604"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="594"><table width="594" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
			<a href="apqp_apro_int1.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">Informações da peça</td>
              </a><a href="apqp_apro_int2.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">Classificação</td>
              </a> <a href="apqp_apro_int3.php">
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">Questões</td>
              </a> 
              <td width="146" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textoboldbranco" >Aprovação</td>
             </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="595" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
              <form name="form1" method="post" id="form1" action="apqp_apro_int_sql.php">
                <td width="573" bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="textoboldbranco">Aprova&ccedil;&atilde;o do Fornecedor </td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellpadding="3" cellspacing="0" class="texto">
                        <tr>
                          <td colspan="6"><img src="imagens/dot.gif" width="50" height="2"></td>
                          </tr>
                        <tr>
						<?php 
				  if(empty($res["quem"])){
				  	$javas="if(confirm('Deseja Aprovar Interina?')){form1.acao.value='v4';form1.submit();}else{ return false; }";
				  }else{
				  $javas="window.alert('Clique em Limpar primeiro');return false;";
				  }
				  ?>
                          <td width="22%"><input name="ap1" type="submit" class="microtxt" id="ap1" onClick="<?php echo  $javas; ?>" value="Aprovar">
                            <input name="lap1" type="submit" class="microtxt" id="lap1" onClick="if(confirm('Deseja Limpar?')){form1.acao.value='v4';form1.submit();}else{ return false; }" value="Limpar"></td>
                          <td width="16%" align="right"><strong>Aprovador Por</strong> </td>
                          <td colspan="4"><input name="tap1" type="text" class="formularioselect" id="tap1" value="<?php echo  $res["quem"]; ?>"></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Cargo</strong></td>
                          <td align="right"><input name="cargo" type="text" class="formulario" id="cargo" size="17" value="<?php echo  $res["cargo"]; ?>"></td>
                          <td width="17%" align="right"><strong>Departamento</strong></td>
                          <td colspan="3"><input name="departamento" type="text" class="formularioselect" id="departamento" value="<?php echo  $res["departamento"]; ?>"></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Tel</strong> </td>
                          <td align="right"><input name="tel" type="text" class="formulario" id="tel" size="17" value="<?php echo  $res["tel"]; ?>"></td>
                          <td align="right"><strong>Fax</strong></td>
                          <td width="19%"><input name="fax2" type="text" class="formulario" id="fax2" size="20" value="<?php echo  $res["fax"]; ?>"></td>
                          <td width="10%" align="right"><strong>Data</strong></td>
                          <td width="16%"><input name="dtquem" type="text" class="formularioselect" id="dtquem" value="<?php echo  banco2data($res["dtquem"]); ?>" size="13" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
                        </tr>
                      </table><?php if($aprov=="N") print "<script>bloke();</script>"; ?></td>
                    </tr>
                    <tr>
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                    </tr>
                    <tr>
                      <td class="textoboldbranco">Aprova&ccedil;&atilde;o do cliente </td>
                    </tr>
                    <tr>
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellpadding="3" cellspacing="0" class="texto">
                        <tr>
                          <td width="39%" align="right"><strong>Gerente da Eng. da Qualidade - Forn. </strong></td>
                          <td width="39%"><input name="apro_eng" type="text" class="formularioselect" id="apro_eng" value="<?php echo  $res["apro_eng"];  ?>"></td>
                          <td width="9%" align="right"><strong>Data</strong></td>
                          <td width="13%"><input name="data_eng" type="text" class="formulario" id="data_eng" value="<?php echo  banco2data($res["data_eng"]);  ?>" size="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Gerente de Compras - Dsenv. Produto</strong></td>
                          <td><input name="apro_com" type="text" class="formularioselect" id="apro_com" value="<?php echo  $res["apro_com"];  ?>"></td>
                          <td align="right"><strong>Data</strong></td>
                          <td><input name="data_com" type="text" class="formulario" id="data_com" value="<?php echo  banco2data($res["data_com"]);  ?>" size="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Gerente da Eng. de Produto da &Aacute;rea</strong></td>
                          <td><input name="apro_engprod" type="text" class="formularioselect" id="apro_engprod" value="<?php echo  $res["apro_engprod"];  ?>"></td>
                          <td align="right"><strong>Data</strong></td>
                          <td><input name="data_engprod" type="text" class="formulario" id="data_engprod" value="<?php echo  banco2data($res["data_engprod"]);  ?>" size="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Coordenador do Projeto</strong></td>
                          <td><input name="apro_coor" type="text" class="formularioselect" id="apro_coor" value="<?php echo  $res["apro_coor"];  ?>"></td>
                          <td align="right"><strong>Data</strong></td>
                          <td><input name="data_coor" type="text" class="formulario" id="data_coor" value="<?php echo  banco2data($res["data_coor"]);  ?>" size="12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
                        </tr>
                      </table></td>
                    </tr>
                    
                    
                    <tr>
                      <td><img src="imagens/dot.gif" width="50" height="5"></td>
                    </tr>
                    <tr>
                      <td align="center">
					    
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
                    <input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('interina','<?php echo $res["id"];?>')">
					&nbsp;
                    <input name="button12222" type="button" class="microtxt" value="Salvar" onClick="form1.acao.value='v4';form1.submit();">
				&nbsp;&nbsp;
<?php
$apqp->agenda_p("Interina");
?>
                    <input name="acao" type="hidden" id="acao" value="1">
                    
                    <input name="local" type="hidden" id="local" value="interina">
                   </td>
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