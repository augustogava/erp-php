<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
	$sql=mysql_query("SELECT clientes.nome AS nomecli,apqp_pc.cliente,apqp_pc.comprador FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
	if($sql){
		$res2=mysql_fetch_array($sql);
	}
}else{
	header("location:apqp_sub1.php");
	exit;
}
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="form1.acao.value='s2'; form1.submit(); return false;";
		}else{
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='s2'; form1.submit(); }else{ return false; } }else{ return false; }";
		}
$sqlc=mysql_query("SELECT clientes.tag FROM apqp_pc,clientes WHERE apqp_pc.cliente=clientes.id");
$resc=mysql_fetch_array($sqlc);
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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_certf_submi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Certificado de Submiss&atilde;o'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Certificado de Submiss&atilde;o deve ser preenchido conforme o Manual do PPAP da AIAG - Terceira Edi&ccedil;&atilde;o. Utilize as abas da parte superior da tela para navegar entre os diversos t&oacute;picos do certificado de submiss&atilde;o.')"></a><span class="impTextoBold"></span><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Certificado de submiss&atilde;o <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top" class="textobold"><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <a href="apqp_sub1.php">
		<td width="94" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">inf. da pe&ccedil;a </td>
		</a>		
		<td width="115" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">inf. da submiss&atilde;o </td>
		<a href="apqp_sub3.php">
        <td width="127" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">n&iacute;vel de submiss&atilde;o </td>
		</a>
		<a href="apqp_sub4.php">
        <td width="117" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">aprova&ccedil;&atilde;o forn. </td>
		</a>
		<a href="apqp_sub5.php">
		<td width="129" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">disposi&ccedil;&atilde;o do cliente </td>
		</a>        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_sub_sql.php">
          <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="3">
            <tr class="textobold">
              <?php if($resc["tag"]=="S"){?>
			  <td colspan="3"><table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#003366">
                <tr>
                  <td colspan="2" align="center" class="textoboldbranco">nota</td>
                  </tr>
                <tr>
                  <td width="442" bgcolor="#FFFFFF" class="textobold">&nbsp;Esta pe&ccedil;a cont&eacute;m alguma subst&acirc;ncia restrita ou report&aacute;vel? </td>
                  <td width="126" align="center" bgcolor="#FFFFFF" class="textobold"><input name="nota1" type="radio" value="1" <?php if($res["nota1"]=="1") print "checked"; ?>>
Sim
  <input name="nota1" type="radio" value="2" <?php if($res["nota1"]=="2") print "checked"; ?>>
N&atilde;o</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold">&nbsp;As pe&ccedil;as pl&aacute;sticas s&atilde;o identificadas com os c&oacute;digos de identifica&ccedil;&atilde;o&nbsp;ISO &nbsp;apropriados?</td>
                  <td align="center" bgcolor="#FFFFFF" class="textobold"><input name="nota2" type="radio" value="1" <?php if($res["nota2"]=="1") print "checked"; ?>>
Sim
  <input name="nota2" type="radio" value="2" <?php if($res["nota2"]=="2") print "checked"; ?>>
N&atilde;o</td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td colspan="3"><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
            <tr>
              <td class="textobold">Cliente:</td>
              <td width="430"><input name="nomecli" type="text" class="formularioselect" id="nomecli" value="<?php print $res2["nomecli"]; ?>" readonly></td>
              <td width="22" align="center"> <a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Email" width="18" height="18" border="0"></a><a href="#" onClick="return abre('apqp_pccli.php','a','width=320,height=300,scrollbars=1');"></a></td>
            </tr>
            <tr class="textobold">
              <td width="119">Comprador / C&oacute;digo:</td>
              <td><input name="comprador" type="text" class="formularioselect" id="comprador" value="<?php print $res2["comprador"]; ?>" maxlength="50"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><img src="imagens/dot.gif" width="50" height="5"></td>
            </tr>
			<?php } else {?>
            <tr>
              <td colspan="3"><table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#003366">
                <tr>
                  <td colspan="2" align="center" class="textoboldbranco">relat&oacute;rio de materiais </td>
                </tr>
                <tr>
                  <td width="419" bgcolor="#FFFFFF" class="textobold">Cliente requisitou relat&oacute;rio de subst&acirc;ncias restritas? </td>
                  <td width="170" align="center" bgcolor="#FFFFFF" class="textobold"><input name="rela1" type="radio" value="2" <?php if($res["rela1"]=="2") print "checked"; ?>>
                    Sim
                    <input name="rela1" type="radio" value="1" <?php if($res["rela1"]=="1") print "checked"; ?>>
                    N&atilde;o
                    <label>
                    <input name="rela1" type="radio" value="0"  <?php if($res["rela1"]=="0") print "checked"; ?>>
                    n/a</label></td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#FFFFFF" class="textobold"><div align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr bgcolor="#003366">
                        <td width="55%" bgcolor="#FFFFFF" class="textobold">Submetido por IMDS ou formato do cliente: </td>
                        <td width="45%" align="center" bgcolor="#FFFFFF" class="textobold"><div align="left">
                            <textarea name="imds" cols="50" rows="2" class="formulario" id="imds"><?php echo  $res["imds"]?>
                      </textarea>
                        </div></td>
                      </tr>
                    </table>
                  </div></td>
                  </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold">Pe&ccedil;as Pol&iacute;meros, identificadas com c&oacute;digos ISO apropriados? </td>
                  <td align="center" bgcolor="#FFFFFF" class="textobold"><input name="rela2" type="radio" value="2" <?php if($res["rela2"]=="2") print "checked"; ?>>
                    Sim
                    <input name="rela2" type="radio" value="1" <?php if($res["rela2"]=="1") print "checked"; ?>>
                    N&atilde;o
                    <label>
                    <input name="rela2" type="radio" value="0" <?php if($res["rela2"]=="0") print "checked"; ?>>
                    n/a</label></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="3"><img src="imagens/dot.gif" width="50" height="5"><?php } ?></td>
            </tr>
            <tr class="textobold">
              <td colspan="3"><table width="571" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td align="center" class="textoboldbranco">raz&atilde;o para submiss&atilde;o </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold"><table width="560" border="0" align="center" cellpadding="3" cellspacing="0">
                    <tr class="textobold">
                      <td colspan="2"><input name="razao" type="radio" value="1" <?php if($res["razao"]=="1") print "checked"; ?>>
                        Submiss&atilde;o Inicial </td>
                      <td width="316"><input name="razao" type="radio" value="7" <?php if($res["razao"]=="7") print "checked"; ?>>
                        Altera&ccedil;&atilde;o de Material ou Constru&ccedil;&atilde;o Opcional </td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="2"><input name="razao" type="radio" value="2" <?php if($res["razao"]=="2") print "checked"; ?>>
                        Altera&ccedil;&otilde;es de Engenharia </td>
                      <td><input name="razao" type="radio" value="8" <?php if($res["razao"]=="8") print "checked"; ?>>
                        Altera&ccedil;&atilde;o de sub-fornecedor ou na fonte do Material </td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="2"><input name="razao" type="radio" value="3" <?php if($res["razao"]=="3") print "checked"; ?>>
                        Ferramental: Transfer&ecirc;ncia, Reposi&ccedil;&atilde;o, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reparo ou Adicional </td>
                      <td><input name="razao" type="radio" value="9" <?php if($res["razao"]=="9") print "checked"; ?>>
                        Altera&ccedil;&atilde;o no processo da Pe&ccedil;a </td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="2"><input name="razao" type="radio" value="4" <?php if($res["razao"]=="4") print "checked"; ?>>
                        Corre&ccedil;&atilde;o de Discrep&acirc;ncia </td>
                      <td><input name="razao" type="radio" value="10" <?php if($res["razao"]=="10") print "checked"; ?>>
                        Pe&ccedil;as produzidas em outra Localidade</td>
                    </tr>
                    <tr class="textobold">
                      <td colspan="2"><input name="razao" type="radio" value="5" <?php if($res["razao"]=="5") print "checked"; ?>>
                        Ferramental Inativo por mais de 1 ano </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr class="textobold">
                      <td width="225"><input name="razao" type="radio" value="6" <?php if($res["razao"]=="6") print "checked"; ?>>
                        Outros - Especifique: </td>
                      <td colspan="2"><input name="razao_esp" type="text" class="formularioselect" id="razao_esp" value="<?php print $res["razao_esp"]; ?>" maxlength="255"></td>
                      </tr>
                  </table></td>
                  </tr>
              </table></td>
              </tr>
            <tr>
              <td colspan="3"><img src="imagens/dot.gif" width="50" height="5">
                
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
                </table>				</td>
              </tr>
            <tr>
              <td colspan="3" align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('submissao','<?php echo $res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>">

                  <input name="acao" type="hidden" id="acao" value="1">
                  <input name="cliente" type="hidden" id="cliente" value="<?php print $res2["cliente"]; ?>">
                  <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
                  <input name="local" type="hidden" id="local" value="submissao">
                  </a></td>
              </tr>
          </table></td>
        </form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>